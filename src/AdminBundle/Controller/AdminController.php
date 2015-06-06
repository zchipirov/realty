<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Library\DB\AdminModel;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Admin:index.html.twig', 
                array('page'=>'home'));
    }
    
    public function usersAction()
    {
        return $this->render('AdminBundle:Admin:users.html.twig', array('page'=>'users'));
    }
    
    public function advAction()
    {
        AdminModel::setConnect();
        if (AdminModel::isConnected())
        {
            $objects = AdminModel::getObjects();
        }
        return $this->render('AdminBundle:Admin:adv.html.twig', 
                array('page'=>'adv', 'objects'=>$objects));
    }
    
    public function advAddAction()
    {
        return $this->render('AdminBundle:Admin:advAdd.html.twig', array('page'=>'adv'));
    }
    
    public function advStatAction()
    {
        return $this->render('AdminBundle:Admin:advStat.html.twig', array('page'=>'adv'));
    }
}
