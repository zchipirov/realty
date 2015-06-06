<?php
namespace Web\Library;
use Web\AdminBundle\DB\UsersModel;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Authorization
{
    private static $id;
    public function __construct()
    {
        
    }
    
    public static function isAuth()
    {
        UsersModel::setConnect();
        if (UsersModel::isConnected())
        {
            if (isset($_SESSION['id']))
            {
                if(isset($_COOKIE['login']))
                {
                    setCookie("login", "", time() - 1, '/');

                    setcookie ("login", $_COOKIE['login'], time() + 50000, '/');

                    return true;
                }
                else
                {
                    $sql =  "SELECT id, email, pswd FROM clients WHERE active=1 AND id = ".$_SESSION['id'];

                    if (UsersModel::numRows($sql) == 1)
                    {
                        $user = UsersModel::getAssocArray(UsersModel::mysqlQuery($sql));
                        setcookie ("login", $user[0]['email'], time()+50000, '/');

                        return true;
                    }
                }
            }
            UsersModel::closeConnect();
        }
        
        return false;
    }
    
    public static function Login($email, $pass)
    {
        UsersModel::setConnect();
        if (UsersModel::isConnected())
        {
            $error = array();
            if ($email != "" && $pass != "")
            {
                $sql = "SELECT id, email, pswd FROM clients WHERE active=1 AND email='$email'";
                
                if (UsersModel::numRows($sql) == 1)
                {
                    $user = UsersModel::getAssocArray(UsersModel::mysqlQuery($sql));
                    if ($user[0]['pswd'] == $pass)
                    {
                        setcookie ("login", $user[0]['email'], time() + 50000);
                        $_SESSION['id'] = $user[0]['id'];
                        
                        return "0";
                    }
                    else
                    {
                        $error[] = "Неверный пароль";
                    }
                }
                else
                {
                    $error[] = "Неверный логин и пароль";
                }
            }
            else
            {
                $error[] = "Поля не должны быть пустыми!";
            }

            UsersModel::closeConnect();
        }
        
        return $error;
    }
    
    public static function Logout()
    {
        UsersModel::setConnect();
        if (UsersModel::isConnected())
        {
            // session_start();	
            unset($_SESSION['id']);
            SetCookie("login", "");
            UsersModel::closeConnect();
            
            return true;
        }
        
        return false;
    }
    
    public static function getUser()
    {
        UsersModel::setConnect();
        if (UsersModel::isConnected())
        {
            $sql = "SELECT id, email, pswd FROM clients WHERE active=1 AND id='".$_SESSION['id']."'";
            $user = UsersModel::getAssocArray(UsersModel::mysqlQuery($sql));
            
            UsersModel::closeConnect();
            
            return $user;
        }
        
        return false;
    }
    
    public static function getId()
    {
        if (isset($_SESSION['id']))
        {
            return $_SESSION['id'];
        }
        
        return false;
    }
    
    public static function getLogin()
    {
        if (isset($_COOKIE['login']))
        {
            return $_COOKIE['login'];
        }
        
        return false;
    }
}
?>
