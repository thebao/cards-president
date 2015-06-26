<?php

namespace JA\CardsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JACardsBundle:Default:index.html.twig', array('name' => $name));
    }
}
