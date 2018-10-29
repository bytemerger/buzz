<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/28/18
 * Time: 9:05 PM
 */

namespace App\config;

class Db
{
    //hold the db connection
    public static $db;

    public function __construct()
    {
        self::$db= new \PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
        self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}