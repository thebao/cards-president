<?php
/**
 * Created by PhpStorm.
 * User: theo
 * Date: 6/27/15
 * Time: 12:06 PM
 */

namespace JA\CardsBundle\Controller;

use JA\CardsBundle\Entity\Card;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class CardActionController extends Controller {

    public function generateDeck(){
        $packs=1;
        $deck=array();
        for($n=0;$n<$packs;$n++){
            for($i=0;$i<4;$i++){
                for($j=1;$j<14;$j++){
                    $card = new Card();
                    $card->setFace($j);
                    $card->setSuit($i);
                    $card->setUniqueId(hash('md5',uniqid('', true)));
                    array_push($deck, $card);
                }
            }

            $joker1 = new Card();
            $joker2 = new Card();
            $joker1->setSuit("jk1")->setFace("jk1")->setUniqueId(hash('md5',uniqid('', true)));
            $joker2->setSuit("jk2")->setFace("jk2")->setUniqueId(hash('md5',uniqid('', true)));
            array_push($deck, $joker1);
            array_push($deck, $joker2);
            shuffle($deck);
        }
        return $deck;
    }

    public function getCardsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $game = $em->getRepository('JACardsBundle:Game')->findByUniqueId($id);
        $players=4;

        $gameId = hash('md5',uniqid('', true));
        $channelName = "/chat";
        $welcomeMessage = "Nouvelle partie lancée à ".date("H:i:s");

        $datas = array(
            "text"=>$welcomeMessage,
            "type"=>"notif"
        );

        $faye = $this->container->get('NomDuBundle.faye.client');
        $faye->send($channelName, $datas);

        $timeToLive = 60*60*24;

        $deck = $this->generateDeck();

        $array = array();
        foreach($deck as $card){
            /** @var Card $card */
            $array[] = $card->getJSONArray();
        }
        $nCards = array();
        $eCards = array();
        $wCards = array();
        $myCards = array();
        for($i=0;$i<count($array);$i++){
            if($i % $players == 0){
                array_push($myCards,$array[$i]);
            }
            if($i % $players == 1){
                array_push($nCards,$array[$i]);
            }
            if($i % $players == 2){
                array_push($eCards,$array[$i]);
            }
            if($i % $players == 3){
                array_push($wCards,$array[$i]);
            }
        }
        $decks =array(
            "gameId"=>$gameId,
            "myCards"=>$myCards,
            "eCards"=>$eCards,
            "nCards"=>$nCards,
            "wCards"=>$wCards,
            "round"=>0
        );

        $cache = $this->get('memcache.default');
        $cache->set($gameId, $decks, $timeToLive);

        $game = array(
            "gameId"=>$gameId,
            "cards"=>$myCards,
            "opponents"=>array(
                "east"=>sizeof($eCards),
                "west"=>sizeof($wCards),
                "north"=>sizeof($nCards)
            )
        );
        return new JsonResponse($game);
    }


    public function checkMoveIsLegalAction(Request $request)
    {

        $cache = $this->get('memcache.default');
        $status="ok";
        $error="";
        $message="";
        if($this->playerDoesNotHaveCards($request)){

            $status="error";
            $error="C'est pas beau de tricher...\n >:(";
        }



        $postedGameId = $request->request->get('gameid');
        $game = $cache->get($postedGameId);
        if($game["round"]==0){
            $message="first round";
            $this->executeMove($game["gameId"]);
        }
        else{
            $status="error";
        }

        return new JsonResponse(array(
            "gameId"=>$game["gameId"],
            "status"=>$status,
            "error"=>$error,
            "message"=>$message,
            "round"=>$game["round"]
        ));

    }
    public function executeMove($gameId){

        $timeToLive = 60*60;

        $cache = $this->get('memcache.default');
        $game = $cache->get($gameId);
        $game["round"]+=1;
        $cache->set($gameId, $game, $timeToLive);
        /* @var User $user */
        $user = $this->getUser();

        $channelName = $user->getGameHandle();


        $faye = $this->container->get('NomDuBundle.faye.client');
        $faye->send("/".$channelName, "move played");

    }

    public function playerDoesNotHaveCards(Request $request)
    {
        $postedCards = $request->request->get('cards');
        $postedGameId = $request->request->get('gameid');
        $cachedGameData = $this->get('memcache.default')->get($postedGameId);
        $ownedCards = $cachedGameData["myCards"];
        $ownedIds = array();
        foreach($ownedCards as $card){
            array_push($ownedIds, $card['uid']);
        }
        foreach($postedCards as $card){
            if(!in_array($card, $ownedIds))
                return true;
        }

        return false;

    }

    public function pingAction()
    {
        $date = date_create();
        return new JsonResponse(array("pong"=>date_format($date, 'U')));
    }

}
