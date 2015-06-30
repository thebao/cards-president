<?php

namespace JA\CardsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JA\UserBundle\Entity\User;

class DefaultController extends Controller
{
    public function joinGameAction()
    {

        /** @var User $usr */
        $usr= $this->get('security.context')->getToken()->getUser();
        $pwd = $usr->getPassword();
        $em = $this->getDoctrine()->getManager();
        $usr->setCurrentGame($pwd);
        $em->persist($usr);
        $em->flush();
        return $this->render('JACardsBundle:Default:index.html.twig', array('user'=>$pwd));
    }

    public function lobbyAction()
    {
        $usr= $this->get('security.context')->getToken()->getUser();
        $pwd = $usr->getPassword();
        return $this->render('JACardsBundle:Default:lobby.html.twig', array('user'=>$pwd));
    }

}
