<?php

namespace JA\CardsBundle\Controller;

use JA\CardsBundle\Entity\Game;
use JA\CardsBundle\Entity\GameSettings;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JA\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use JA\CardsBundle\Form\GameType;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function joinGameAction($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('JACardsBundle:Game');
        $game = $repo->find($id);
        if (null === $game){
            throw new NotFoundHttpException("La partie d'id ".$id." n'existe pas.");
        }
        $usr= $this->get('security.context')->getToken()->getUser();
        if(!in_array($usr->getUsername(), $game->getPlayers())){
            throw new NotFoundHttpException("Pas le droit !");
        }
        $pwd = $usr->getGameHandle();
        $em = $this->getDoctrine()->getManager();
        return $this->render('JACardsBundle:Default:index.html.twig', array('user'=>$pwd,'game'=>$game));
    }

    public function lobbyAction(Request $request)
    {

        $allGame = $this->getDoctrine()->getManager()->getRepository('JACardsBundle:Game')->findAll();
        $usr= $this->get('security.context')->getToken()->getUser();
        $pwd = $usr->getPassword();
        return $this->render('JACardsBundle:Default:lobby.html.twig', array('games'=>$allGame));
    }

    public function queueAction($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('JACardsBundle:Game');
        $allGame = $repo->findAll();
        $game = $repo->find($id);
        $usr= $this->get('security.context')->getToken()->getUser();
        $pwd = $usr->getPassword();
        return $this->render('JACardsBundle:Default:lobby.html.twig', array('games'=>$allGame,'gameId'=>$game->getId()));
    }

    public function newGameAction(Request $request)
    {
        $user = $this->getUser();
        if($this->isGameOwner($user)){
            throw new NotFoundHttpException("Interdit!");
        }
        $settings = new GameSettings();


        $game = new Game();
        $game->setSettings($settings);
        $form = $this->get('form.factory')->create(new GameType, $game);
        $form->handleRequest($request);




        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $game->setOwner($user);
            $game->addPlayer($user);
            $em->persist($settings);
            $em->persist($game);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée !');
            $request->attributes->set('gameId', $game->getId());
            return $this->redirect($this->generateUrl('ja_cards_queue', array('id'=>$game->getId())));
        }
        return $this->render('JACardsBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
        ));


    }

    public function isGameOwner(User $user)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM `game` WHERE `owner_id` = :id");
        $statement->bindValue(':id', $user->getId());
        $statement->execute();
        $results = $statement->fetchAll();

        if ($results)
            return true;
        else
            return false;
    }

    public function removeGameAction($id)
    {
        $user = $this->getUser();
        $em =   $this->getDoctrine()->getManager();

        /** @var Game $game */
        $game = $em->getRepository('JACardsBundle:Game')->find($id);
        if (null === $game){
            throw new NotFoundHttpException("La partie d'id ".$id." n'existe pas.");
        }
        if ($user == $game->getOwner()){
            $em->remove($game);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('ja_cards_lobby'));

    }

    public function retrieveGamesAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('JACardsBundle:Game');
        $games = $repository->findAll();

        $array = array();
        foreach ($games as $game) {
            /** @var Game $game */
            $array[] = $game->getJsonArray();
        }

        return new JsonResponse($array);
    }

}
