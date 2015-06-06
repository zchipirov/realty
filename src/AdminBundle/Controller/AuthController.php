<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Library\DB\AdminModel;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function isAuthAction()
    {
        $session = $this->get('request')->getSession();
        $id = $session->get('id');
        if (is_numeric($id))
        {
            return new Response($id);
        }
        else
        {
            return new Response("0");
        }
    }
    
    public function authAction($action)
    {
        $request = $this->getRequest();

        switch ($action) {
            case 'login':
                $login = $request->request->get('login');
                $passwd = $request->request->get('passwd');
                
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $user = AdminModel::loginUser($login, $passwd);
                    
                    if (count($user) > 0)
                    {
                        $session = $this->get('request')->getSession();
                        $session->set('id', $user[0]['id']);
                        $session->set('login', $user[0]['login']);
                        AdminModel::closeConnect();
                        
                        return $this->redirect($this->generateUrl('_home'), 301);
                    }
                    AdminModel::closeConnect();
                }
                break;
        }
        $session = $this->get('request')->getSession();
        $session->set('id', "");
        $session->set('login', "");
        
        return $this->render('AdminBundle:Secured:login.html.twig');
    }
    
    public function getUserIdAction()
    {
        $session = $this->get('request')->getSession();
        $id = $session->get('id');
        
        return new Response($id);
    }

    public function logoutAction()
    {
        $session = $this->get('request')->getSession();
        $session->set('id', "");
        $session->set('login', "");
        
        return $this->redirect($this->generateUrl('_home'), 301);
    }
    
}