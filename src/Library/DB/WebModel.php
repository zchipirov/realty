<?php
namespace Library\DB;

use Library\DB\CModel;

class WebModel extends CModel
{
    public static function getObjects()
    {
        $sql = "SELECT id, CASE stype WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS stype, price, phone, address FROM objects ORDER BY dt DESC";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
}
?>