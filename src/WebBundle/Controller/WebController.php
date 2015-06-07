<?php

namespace WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Library\DB\WebModel;

class WebController extends Controller
{
    public function indexAction()
    {
        return $this->render('WebBundle:Web:index.html.twig', 
                array('page'=>'home'));
    }
}
