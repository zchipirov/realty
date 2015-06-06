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
        AdminModel::closeConnect();
        return $this->render('AdminBundle:Admin:adv.html.twig', 
                array('page'=>'adv', 'objects'=>$objects));
    }
    
    public function EditAdvAction($action)
    {
        $request = $this->getRequest();
        
        switch($action)
        {
            case "edit":
                break;
            case "add":
                break;
            case "remove":
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $IDobj = $request->request->get("idObject");
                    AdminModel::removeObject($IDobj);
                }
                AdminModel::closeConnect();
            break;
        }
        return $this->redirect($this->generateUrl('_adv', array('message'=>"Объявление удалено.")), 301);
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
