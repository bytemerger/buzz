<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/28/18
 * Time: 9:10 PM
 */

namespace App\config;
//app configurations

class settings
{
    public function __construct()
    {
        //set default date and time
        date_default_timezone_set( "Africa/Lagos" );  // http://www.php.net/manual/en/timezones.php
        //define database connection variables
        define( "DB_DSN", "mysql:host=localhost;dbname=buzz" );
        define( "DB_USERNAME", "franc" );
        define( "DB_PASSWORD", "come1234" );
        //set a default language
        define('LANGUAGE_CODE', 'en');
        define('IMAGE_PATH', '/app/public/img');
    }

}