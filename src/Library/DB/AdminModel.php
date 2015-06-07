<?php
namespace Library\DB;

use Library\DB\CModel;

class AdminModel extends CModel
{
    public static function getObjects()
    {
        $sql = "SELECT id, CASE stype WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS stype, price, phone, address FROM objects ORDER BY dt DESC";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeObject($id)
    {
        $sql = "DELETE FROM objects WHERE id=$id";
        return self::mysqlQuery($sql);
    }
    
    public static function getObjectById($id)
    {
        $sql = "SELECT id, phone, area, title, sdesc, stype, status, price, soption, address, rooms FROM objects WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array[0];
    }
    
    public static function getUsers()
    {
        $sql = "SELECT id, login FROM admin ORDER BY login";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getUserById($id)
    {
        $sql = "SELECT id, login, passwd FROM admin WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array[0];
    }
    
    public static function removeUser($id)
    {
        $sql = "DELETE FROM admin WHERE id=$id";
        return self::mysqlQuery($sql);
    }
}
?>