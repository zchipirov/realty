<?php
namespace Library\DB;

use Library\DB\CModel;

class AdminModel extends CModel
{
    public static function getObjects()
    {
        $sql = "SELECT id, CASE type WHEN 0 THEN 'квартира' WHEN 1 THEN 'комната' WHEN 2 THEN 'дача' WHEN 3 THEN 'дом' WHEN 4 THEN 'гараж' WHEN 5 THEN 'земельный участок' END AS type, price, phone, address FROM objects";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getCityById($id)
    {
        $sql = "SELECT id, city, IDregion FROM cities WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeCity($id)
    {
        $sql = "DELETE FROM cities WHERE id=$id";

        return self::mysqlQuery($sql);
    }
    
    public static function getRegions()
    {
        $sql = "SELECT id, name FROM region ORDER BY name";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getRegionById($id)
    {
        $sql = "SELECT id, name FROM region WHERE id=$id ORDER BY name";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeRegion($id)
    {
        $sql = "DELETE FROM region WHERE id=$id";
        self::mysqlQuery($sql);
        
        $sql = "DELETE FROM cities WHERE IDregion=$id";
        self::mysqlQuery($sql);
    }
    
    public static function getModels()
    {
        $sql = "SELECT md.id, md.title, md.IDmake, (SELECT mk.title FROM make AS mk WHERE md.IDmake=mk.id) AS make FROM model AS md ORDER BY md.title";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getModelById($id)
    {
        $sql = "SELECT md.id, md.title, md.IDmake, (SELECT mk.title FROM make AS mk WHERE md.IDmake=mk.id) AS make FROM model AS md WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeModel($id)
    {
        $sql = "DELETE FROM model WHERE id=$id";

        return self::mysqlQuery($sql);
    }
    
    public static function getMakies()
    {
        $sql = "SELECT id, title FROM make ORDER BY title";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getMakeById($id)
    {
        $sql = "SELECT id, title FROM make WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeMake($id)
    {
        $sql = "DELETE FROM make WHERE id=$id";
        self::mysqlQuery($sql);
        
        $sql = "DELETE FROM model WHERE IDmake=$id";
        self::mysqlQuery($sql);
    }
    
    public static function getRates()
    {
        $sql = "SELECT id, name, price FROM rates ORDER BY name";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getRateById($id)
    {
        $sql = "SELECT id, name, price FROM rates WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeRate($id)
    {
        $sql = "DELETE FROM rates WHERE id=$id";
        self::mysqlQuery($sql);
    }
    
    public static function getFactors()
    {
        $sql = "SELECT id, title, k, IDtype_k, (SELECT t.title FROM type_k AS t WHERE t.id=r.IDtype_k) AS type  FROM factor AS r ORDER BY type";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getFactorsByTypeId($id)
    {
        $sql = "SELECT id, title, k FROM factor AS r WHERE IDtype_k=$id ORDER BY title";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getFactorById($id)
    {
        $sql = "SELECT id, title, k, IDtype_k FROM factor AS r WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeFactor($id)
    {
        $sql = "DELETE FROM factor WHERE id=$id";
        self::mysqlQuery($sql);
    }
    
    public static function getTypes()
    {
        $sql = "SELECT id, title FROM type_k ORDER BY title";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getTypeById($id)
    {
        $sql = "SELECT id, title FROM type_k AS r WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeType($id)
    {
        $sql = "DELETE FROM type_k WHERE id=$id";
        self::mysqlQuery($sql);
        
        $sql = "DELETE FROM factor WHERE IDtype_k=$id";
        self::mysqlQuery($sql);
    }
    
    public static function getKCity()
    {
        $sql = "SELECT ct.id, rg.name, ct.city, ct.k1, ct.k2 FROM cities AS ct JOIN region AS rg ON rg.id=ct.IDregion ORDER BY rg.name, ct.city";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getClients()
    {
        $sql = "SELECT id, phone, (SELECT COUNT(*) FROM policy AS p WHERE p.IDuser=u.id) AS cnt, (SELECT SUM(p.price) FROM policy AS p WHERE p.IDuser=u.id) AS summa FROM users AS u ORDER BY phone";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getPolicy($page, $lists)
    {
        $sql = "SELECT id, (SELECT COUNT(id) FROM policy) AS cnt, (SELECT u.phone FROM users AS u WHERE u.id=p.IDuser) AS phone, status, dt, price, pay FROM policy AS p ORDER BY status, dt DESC LIMIT $page, $lists";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getPolicyById($id)
    {
        $sql = "SELECT id, IDcity, IDuser, IDauto, last, first, patro, birthday, yearauto, status, notlimit, pay, (SELECT phone FROM users AS us WHERE us.id=IDuser LIMIT 1) AS phone, power, price, policy_start, gos_num, vin, cert_or_pts, address, term, nogosnum, code FROM policy WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getPolicyByClientId($id)
    {
        $sql = "SELECT id, IDcity, IDuser, dt, IDauto, last, first, patro, birthday, yearauto, status, notlimit, pay, (SELECT phone FROM users AS us WHERE us.id=IDuser LIMIT 1) AS phone, power, price, policy_start, gos_num, vin, cert_or_pts, address, term, nogosnum, code FROM policy WHERE IDuser=$id ORDER BY dt DESC";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getCountPolicy()
    {
        $sql = "SELECT COUNT(*) AS cnt FROM policy WHERE status=0";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removePolicy($id)
    {
        $sql = "DELETE FROM policy WHERE id=$id";
        self::mysqlQuery($sql);
        
        $sql = "DELETE FROM drivers WHERE IDpolicy=$id";
        self::mysqlQuery($sql);
    }
    
    public static function checkPhone($phone)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM policy WHERE phone='".$phone."'";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getCityFactor($id)
    {
        $sql = "SELECT k1 FROM city WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getFactor($id)
    {
        $sql = "SELECT k FROM factor WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array['0']['k'];
    }
    
    public static function getBasePrice($id)
    {
        $sql = "SELECT price FROM rates WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array['0']['price'];
    }
    
    public static function getYear($dt)
    {
        $sql = "select ROUND(DATEDIFF(now(), '".$dt."')/365) AS year";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function loginUser($login, $passwd)
    {
        $sql = "SELECT id, login FROM admin WHERE login='".$login."' AND passwd='".$passwd."'";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function loginClient($login, $passwd)
    {
        $sql = "SELECT id, phone FROM users WHERE phone='".$login."' AND pswd='".$passwd."'";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getPageContent($page)
    {
        $sql = "SELECT id, title, content FROM page WHERE id=$page";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getAddress()
    {
        $sql = "SELECT address FROM page WHERE id=3";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array[0]['address'];
    }
    
    public static function getCoordinates()
    {
        $sql = "SELECT coordinates FROM page WHERE id=3";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array[0]['coordinates'];
    }
    
    public static function getUsers()
    {
        $sql = "SELECT id, fio, login, email FROM admin";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getUserById($id)
    {
        $sql = "SELECT id, fio, login, email, passwd FROM admin WHERE id=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function getClientByPhone($phone)
    {
        $sql = "SELECT id FROM users WHERE phone='".trim($phone)."' LIMIT 1";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
    
    public static function removeUser($id)
    {
        $sql = "DELETE FROM admin WHERE id=$id";
        self::mysqlQuery($sql);
    }
    
    public static function getDrivers($id)
    {
        $sql = "SELECT id, first, last, patronymic, birthday, stage FROM drivers WHERE IDpolicy=$id";
        $array = self::getAssocArray(self::mysqlQuery($sql));
        
        return $array;
    }
}
?>