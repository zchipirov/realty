<?php
namespace Library\DB;

class CModel
{
    private static $dblocation = "localhost";
    private static $dbname = "realty";
    private static $dbuser = "root";
    private static $dbpasswd = "123123";
    private static $dbcnx;
    private static $connect = null;
    
    // Устанавливается соединение с базой данных
    public function __construct()
    {
        self::$dbcnx = mysqli_connect(self::$dblocation, self::$dbuser, self::$dbpasswd, self::$dbname);
        // обработчик
        if (mysqli_connect_errno())
        {
            die(mysqli_connect_error());
        }
        else
        {
           // echo "База данных доступна. Соединение установлено!";
        }
    }
    
    // Подключение к БД
    public static function setConnect()
    {
        if (null === self::$connect)
        {
            self::$connect = new self();
        }
        
        return self::$connect;        
    }
    
    // Закрытие соединения
    public static function closeConnect()
    {
        if (!mysqli_close(self::$dbcnx))
        {
            echo "Ошибка при закрытии соединения!";
        }
        else
        {
            self::$connect = null;
        }
    }
    
    public static function numRows($sql)
    {
        if ($stmt = mysqli_prepare(self::$dbcnx, $sql)) {
            $stmt->execute();
            $stmt->store_result();
            return  $stmt->num_rows;
        }
        
        return "0";
    }
    
    // Проверка подключения
    public static function isConnected()
    {
        if (self::$dbcnx)
            return true;
        return false;        
    }
    
    // Получение последней ошибки
    public static function getLastError()
    {
        return mysqli_errno(self::$dbcnx) . ": ".  mysqli_error(self::$dbcnx);
    }
    
    // Получение номера последнего добавленного ID
    public static function getLastInsertID()
    {
        return mysqli_insert_id( self::$dbcnx );
    }
    
    // Экранирование символов
    public static function escapeString($sql)
    {
        return mysqli_real_escape_string(self::$dbcnx, $sql);
    }
    
    // Запрос к БД
    public static function mysqlQuery($sql, $_debug = 0 )
    {
        if ($_debug > 0 ) 
        { 
            print ("EXECUTING $sql");
        }
        if ( !($query = mysqli_query(self::$dbcnx, $sql) ) ) 
        {
            if ($_debug ) 
            {
                print("ERROR SQL $sql"); 
            }
            self::throwException();
        }
        return $query;
    }
    
    public static function getAssocArray($query)
    {
        $array = array();
        if ($query) {
            while ($row = mysqli_fetch_assoc($query))
            {
                $array[] = $row;
            }
        }
        
        return $array;
    }
    
    public static function throwException()
    {
        if (self::getLastError())
        {
            throw new \Exception(self::getLastError());
        }
    }
    
    public static function update($table, $row, $pk = "id")
    {
        $cols = "";
        $vals = "";
        $upd = "";
        foreach ($row as $key => $value) 
        {
            if ( $key == $pk && $value != -1 )
            {
                $cols .= $key.',';
                $vals .= '\''.$value.'\',';
            }
            if ( $key != $pk )
            { 
                $upd .= "$key='$value',"; 
                $cols .= $key.',';
                $vals .= '\''.$value.'\',';
            }
        }
        $cols = substr($cols, 0, strlen($cols) - 1);
        $vals = substr($vals, 0, strlen($vals) - 1);
        $upd = substr($upd, 0, strlen($upd) - 1);

        $sql = "INSERT INTO `$table` ($cols) VALUES ($vals) ON DUPLICATE KEY UPDATE $upd";
echo $sql;
        if (self::mysqlQuery($sql))
            return 0;
        return self::getLastError();
    }
	
    public static function validate($paramlist, $params, $fstrict)
    {
        for ($i = 0; $i<sizeof($paramlist); $i++ )
            if ( !isset($params[$paramlist[$i]]) ) 
                return false;

        if ( $fstrict && sizeof($paramlist) != sizeof($params) )
            return false;
        
        return true;
    }
}
?>