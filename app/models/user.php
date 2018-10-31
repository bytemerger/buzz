<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/30/18
 * Time: 11:59 AM
 */

namespace App\models;


use App\config\Db;

class user
{
    public static function signUp($data)
    {
        $conn=new Db();
            try {
                $sql = "INSERT INTO users ( username, password, firstName, lastName, email, image ) VALUES ( :user, :pass, :firstName, :lastName, :email, :image )";
                $st = $conn->db->prepare($sql);
                $st->bindValue(":user", $data['username']);
                $st->bindValue(":pass", $data['hashPass']);
                $st->bindValue(":firstName", $data['firstname']);
                $st->bindValue(":lastName", $data['lastname']);
                $st->bindValue(":email", $data['email']);
                $st->bindValue(":image", $data['image']);
                $st->execute();
                $conn=null;
                $status='';
            }
            catch (\Exception $e) {
                $status='unable to create user';
            }
        return $status;
    }
    public static function getUser($username)
    {
        $conn=new Db();
        $sql= "SELECT * FROM users WHERE username=:user";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $username);
        $st->execute();
        $user=$st->fetch(\PDO::FETCH_ASSOC);
        $conn=null;
        return $user;
    }

}