<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/4/18
 * Time: 10:49 AM
 */

namespace App\models;
use App\config\Db;

class friends
{
    public static function search($search)
    {
        $conn=new Db();
        $sql= "SELECT * FROM users WHERE username NOT IN (SELECT acceptFriend AS friend FROM friends WHERE sendFriend=:user UNION DISTINCT SELECT sendFriend FROM friends WHERE acceptFriend=:user) AND (username LIKE :name OR firstName LIKE :name OR lastName LIKE :name) AND (username <> :user)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":name", '%'.$search['search'].'%');
        $st->bindValue(":user", $search['user']);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public static function add($add)
    {
        $conn=new Db();
        try {
        $sql = "INSERT INTO friends ( sentFriend, acceptFriend, accepted) VALUES ( :friend, :friend2, :acc)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":friend", $add['sentFriend']);
        $st->bindValue(":friend2", $add['acceptFriend']);
        $st->bindValue(":acc", 0);
        $st->execute();
        $conn=null;
        $status='';
        }
        catch (\Exception $e) {
            $status='unable to add user';
        }
        return $status;

    }
}