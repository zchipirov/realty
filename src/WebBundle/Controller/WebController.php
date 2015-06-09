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
    
    public function itemAction()
    {
        $request = $this->getRequest();
        
        $item = $request->query->get("item");
        
        WebModel::setConnect();
        if (WebModel::isConnected())
        {
            $object = WebModel::getObjectById($item);
            $photos = WebModel::getPhotosById($item);
        }
        WebModel::closeConnect();
        return $this->render('WebBundle:Web:item.html.twig', 
                array('page'=>'home', 'object'=>$object, 'photos'=>$photos));
    }
    
    public function aboutAction()
    {
        return $this->render('WebBundle:Web:about.html.twig', 
                array('page'=>'about'));
    }
    
    public function catalogAction()
    {
        WebModel::setConnect();
        if (WebModel::isConnected())
        {
            $objects = WebModel::getObjects();
        }
        WebModel::closeConnect();
        return $this->render('WebBundle:Web:catalog.html.twig', 
                array('page'=>'catalog', 'objects'=>$objects));
    }
    
    public function contactAction()
    {
        return $this->render('WebBundle:Web:contact.html.twig', 
                array('page'=>'contact'));
    }
    
    public function filterAction()
    {
        $request = $this->getRequest();
        
        $item = $request->query->get("item");
        $item = $item == "-1"? "": $item;
        
        if ($request->getMethod() == "POST")
        {
            $item = $request->request->get("item");
            $view = $request->request->get("view");
            $option = $request->request->get("option");
            $area1 = $request->request->get("area1");
            $area2 = $request->request->get("area2");
            $rooms = $request->request->get("rooms");
            $price1 = $request->request->get("price1");
            $price2 = $request->request->get("price2");
            WebModel::setConnect();
            if (WebModel::isConnected())
            {
                $objects = WebModel::getObjectsByParams($item ,$view, $option, $area1, $area2, $rooms, $price1, $price2);
            }
            WebModel::closeConnect();
        }
        else
        {
            WebModel::setConnect();
            if (WebModel::isConnected())
            {
                $objects = WebModel::getObjectsByType($item);
            }
            WebModel::closeConnect();
        }
        
        return $this->render('WebBundle:Web:catalog.html.twig', 
            array('page'=>'catalog', 'item'=>$item, 'objects'=>$objects));
    }
}