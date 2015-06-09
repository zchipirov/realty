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
        AdminModel::setConnect();
        if (AdminModel::isConnected())
        {
            $users = AdminModel::getUsers();
        }
        AdminModel::closeConnect();
        return $this->render('AdminBundle:Admin:users.html.twig', array('page'=>'users', "users"=>$users));
    }
    
    public function EditUsersAction($action)
    {
        $request = $this->getRequest();

        switch($action)
        {
            case "add2":
                $login = $request->request->get("login");
                $passwd = $request->request->get("passwd");
                $passwd2 = $request->request->get("passwd2");
                $iduser = $request->request->get("idUser");
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $params = array("login"=>$login, "passwd"=>$passwd);
                    if ($iduser != "")
                        $params["id"] = $iduser;
                    if ($passwd==$passwd2)
                        AdminModel::update("admin", $params);
                }
                AdminModel::closeConnect();
                return $this->redirect($this->generateUrl('_users'), 301);
                break;
            case "edit":
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $IDuser = $request->request->get("idUser");
                    $user = AdminModel::getUserById($IDuser);
                }
                AdminModel::closeConnect();
                return $this->render('AdminBundle:Admin:usersAdd.html.twig', array('page'=>'users', 'action'=>'edit', 'user'=>$user));
            case "add":
                return $this->render('AdminBundle:Admin:usersAdd.html.twig', array('page'=>'users', 'action'=>'add'));
                break;
            case "remove":
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $IDuser = $request->request->get("idUser");
                    AdminModel::removeUser($IDuser);
                }
                AdminModel::closeConnect();
            break;
        }
        return $this->redirect($this->generateUrl('_users', array('message'=>"Пользователь удален.")), 301);
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
            case "add2":
                $title = $request->request->get("title");
                $type = $request->request->get("type");
                $view = $request->request->get("view");
                $phone = $request->request->get("phone");
                $option = $request->request->get("option");
                $desc = $request->request->get("desc");
                $price = $request->request->get("price");
                $address = $request->request->get("address");
                $area = $request->request->get("area");
                $rooms = $request->request->get("rooms");
                $rooms = $rooms == ""? 0: $rooms;
                $idobject = -1;
                if ($request->request->get("idObject"))
                {
                    $idobject = $request->request->get("idObject");
                }
                
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $params = array("title"=>$title, "stype"=>$type, "soption"=>$option, "sdesc"=>$desc, 
                                "price"=>$price, "address"=>$address, "phone"=>$phone, "area"=>$area, "rooms"=>$rooms,
                                "status"=>$view, "dt"=>date("Y-m-d H:m:s"));
                    if ($idobject != -1)
                        $params["id"] = $idobject;
                    AdminModel::update("objects", $params);
                    
                    $fileElementName = 'fileToUpload';
                    $i = 0;
                    $files_count = sizeof($_FILES[$fileElementName]["name"]);
                    $lid = $idobject != -1? $idobject: AdminModel::getLastInsertID();
                    
                    for ($i = 0; $i < $files_count-1; $i++) {	
                        move_uploaded_file($_FILES[$fileElementName]['tmp_name'][$i], "C:/Apache24/htdocs/realty/web/bundles/admin/uploads/" . $_FILES[$fileElementName]['name'][$i]);
                        AdminModel::update("photo", array("Idobject"=>$lid, "path"=>"/realty/web/bundles/admin/uploads/" . $_FILES[$fileElementName]['name'][$i]));
                    }
                    //for security reason, we force to remove all uploaded file
                    @unlink($_FILES[$fileElementName][$i]);
                }
                AdminModel::closeConnect();
                return $this->redirect($this->generateUrl('_adv'), 301);
                break;
            case "edit":
                AdminModel::setConnect();
                if (AdminModel::isConnected())
                {
                    $IDobj = $request->request->get("idObject");
                    $object = AdminModel::getObjectById($IDobj);
                    $photos = AdminModel::getPhotosById($IDobj);
                }
                AdminModel::closeConnect();
                return $this->render('AdminBundle:Admin:advAdd.html.twig', array('page'=>'adv', 'action'=>'edit', 'object'=>$object, 'photos'=>$photos));
                break;
            case "add":
                return $this->render('AdminBundle:Admin:advAdd.html.twig', array('page'=>'adv', 'action'=>'add'));
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
    
    public function advStatAction()
    {
        AdminModel::setConnect();
        if (AdminModel::isConnected())
        {
            $objects = AdminModel::getObjects();
            $users= AdminModel::getUsers();
        }
        AdminModel::closeConnect();
        return $this->render('AdminBundle:Admin:advStat.html.twig', array('page'=>'adv', 'objects'=>  count($objects), 'users'=>count($users)));
    }
    
    public function removeAction()
    {
        $request = $this->getRequest();
        $id = $request->request->get("id");
        
        AdminModel::setConnect();
        if (AdminModel::isConnected())
        {
            AdminModel::removePhotos($id);
        }
        AdminModel::closeConnect();
        return new \Symfony\Component\HttpFoundation\Response("");
    }
}
