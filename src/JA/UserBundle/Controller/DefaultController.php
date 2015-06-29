<?php

namespace JA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JAUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
