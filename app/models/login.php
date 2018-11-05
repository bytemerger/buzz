<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/31/18
 * Time: 9:50 PM
 */

namespace App\models;

use App\config\Db;

class login
{
    //insert the login info like the token and the user
    public static function insertLogin($data)
    {
        $conn=new Db();
        $sql= "INSERT INTO logins (loginSelector, loginToken, loginUserName, loginExpires) VALUES (:selector, :hashedToken, :userName, :time)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":selector", $data['selector']);
        $st->bindValue(":hashedToken", $data['hashedToken']);
        $st->bindValue(":userName", $data['userName']);
        $st->bindValue(":time", $data['time']);
        $st->execute();
        $conn=null;
    }

    public static function checkLogin($selector)
    {
        $conn=new Db();
        $stmt = $conn->db->prepare('SELECT * FROM logins WHERE loginSelector = :selector');
        $stmt->bindValue(':selector', $selector);
        $stmt->execute();
        $results = $stmt->fetch();
        $conn=null;
        return $results;

    }

    public static function deleteLogin($data)
    {
        $conn=new Db();

        $stmt = $conn->db->prepare('DELETE FROM logins WHERE loginSelector = :selector');
        $stmt->bindValue(':selector', $data['selector']);

        $stmt->execute();

        $stmt = $conn->db->prepare('DELETE FROM logins WHERE loginUserName = :userName');
        $stmt->bindValue(':userName', $data['userName']);

        $stmt->execute();
    }

}
