<?php
namespace Library\DB;

use Library\DB\CModel;

class WebModel extends CModel
{
    public static function getObjects()
    {
        $sql = "SELECT id, (SELECT path FROM photo WHERE Idobject=ob.id LIMIT 1) AS path, CASE stype WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS stype, price, phone, address, title FROM objects AS ob ORDER BY dt DESC";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getObjectById($id)
    {
        $sql = "SELECT id, CASE soption WHEN 0 THEN 'аренда в сутки' WHEN 1 THEN 'аренда в месяц' WHEN 2 THEN 'продажа' END AS soption, rooms, sdesc, area, CASE stype WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS stype, price, phone, address, title FROM objects WHERE id=$id ORDER BY dt DESC";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getPhotosById($id)
    {
        $sql = "SELECT path, id FROM photo WHERE Idobject=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getObjectsByType($id)
    {
        $where = "";
        if ($id != "" && $id != "-1")
            $where .= " stype=$id AND ";
        if ($where != "")
        {
            $where = substr($where, 0, strlen($where)-4);
            $where = " WHERE ".$where;
        }
        $sql = "SELECT id, CASE stype WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS stype, price, phone, address, title FROM objects $where ORDER BY dt DESC";
        
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getObjectsByParams($item, $view, $option, $area1, $area2, $rooms, $price1, $price2)
    {
        $where = "";
        if ($item != "")
            $where .= " stype=$item AND ";
        if ($view != "-1")
            $where .= " status=$view AND ";
        if ($option != "-1")
            $where .= " soption=$option AND ";
        if ($area1 != "")
            $where .= " area>=$area1 AND ";
        if ($area2 != "")
            $where .= " area<=$area2 AND ";
        if ($rooms != "")
            $where .= " rooms=$rooms AND ";
        if ($price1 != "")
            $where .= " price>=$price1 AND ";
        if ($price2 != "")
            $where .= " price<=$price2 AND ";
        if ($where != "")
        {
            $where = substr($where, 0, strlen($where)-4);
            $where = " WHERE ".$where;
        }
        
        $sql = "SELECT id, CASE stype WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS stype, price, phone, address, title FROM objects $where ORDER BY dt DESC";
        $array = self::getAssocArray(self::mysqlQuery($sql));

        return $array;
    }
}
?>