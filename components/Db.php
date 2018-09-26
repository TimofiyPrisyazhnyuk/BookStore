<?php


class Db
{

    /**
     * Path to config file with parameters
     *
     * @var string
     */
    protected static $dbParams = ROOT . '/config/DataBase.php';

    /**
     * Create new connection to DB / PDO
     *
     * @return PDO
     */
    public static function getConnection()
    {

        $params = include(self::$dbParams);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        return $db;
    }

    /**
     * Close connection to db / PDO
     *
     * @param $db
     */
    public static function closeDbConnection(&$db)
    {
        $db = null;
    }
}
