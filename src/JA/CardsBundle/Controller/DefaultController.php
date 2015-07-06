<?php

namespace JA\CardsBundle\Controller;

use JA\CardsBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JA\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function joinGameAction($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('JACardsBundle:Game');
        $game = $repo->find($id);
        if (null === $game){
            bao
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

    public function lobbyAction()
    {
        $allGame = $this->getDoctrine()->getManager()->getRepository('JACardsBundle:Game')->findAll();
        $usr= $this->get('security.context')->getToken()->getUser();
        $pwd = $usr->getPassword();
        return $this->render('JACardsBundle:Default:lobby.html.twig', array('games'=>$allGame));
    }

}
