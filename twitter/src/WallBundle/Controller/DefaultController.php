<?php

namespace WallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/wall")
     */
    public function indexAction()
    {
        return $this->render('WallBundle:Default:index.html.twig');
    }
}
