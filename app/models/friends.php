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
        $sql = "INSERT INTO friends ( sendFriend, acceptFriend, accepted,seen) VALUES ( :friend, :friend2, :acc,:seen)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":friend", $add['sendFriend']);
        $st->bindValue(":friend2", $add['acceptFriend']);
        $st->bindValue(":acc", 0);
        $st->bindValue(":seen", 0);
        $st->execute();
        $conn=null;
        $status='';
        }
        catch (\Exception $e) {
            $status='unable to add user';
        }
        return $status;

    }

    public static function check($search)
    {
        $conn=new Db();
        $sql="SELECT * FROM friends WHERE (sendFriend=:send AND acceptFriend=:accept) OR (acceptFriend=:send AND sendFriend=:accept)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":send", $search['sendFriend']);
        $st->bindValue(":accept", $search['acceptFriend']);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public static function friendRequest($user)
    {
        $conn=new Db();
        $sql="SELECT * FROM friends WHERE acceptFriend=:user AND accepted=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $user);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public static function sentRequest($user)
    {
        $conn=new Db();
        $sql="SELECT * FROM friends WHERE sendFriend=:user AND accepted=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $user);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    //cancel sent request
    public static function cancelRequest($data)
    {
        $conn=new Db();
        $sql="DELETE FROM friends WHERE sendFriend=:user AND acceptFriend=:friend AND accepted=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
    }

    public static function deleteRequest($data)
    {
        $conn=new Db();
        $sql="DELETE FROM friends WHERE acceptFriend=:user AND sendFriend=:friend AND accepted=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
    }

    public static function acceptRequest($data)
    {
        $conn=new Db();
        $sql="UPDATE friends SET accepted=1 WHERE acceptFriend=:user AND sendFriend=:friend AND accepted=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
    }

    public static function getFriends($search)
    {
        $conn=new Db();
        $sql= "SELECT * FROM users WHERE username IN (SELECT acceptFriend AS friend FROM friends WHERE sendFriend=:user AND accepted=1 UNION DISTINCT SELECT sendFriend FROM friends WHERE acceptFriend=:user AND accepted=1)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $search);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public static function deleteFriend($data)
    {
        $conn=new Db();
        $sql="DELETE FROM friends WHERE (acceptFriend=:user AND sendFriend=:friend) OR (sendFriend=:user AND acceptFriend=:friend) AND accepted=1";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
    }


    public static function searchFriends($search)
    {
        $conn=new Db();
        $sql= "SELECT * FROM users WHERE username  IN (SELECT acceptFriend AS friend FROM friends WHERE sendFriend=:user UNION DISTINCT SELECT sendFriend FROM friends WHERE acceptFriend=:user) AND (username LIKE :name OR firstName LIKE :name OR lastName LIKE :name) AND (username <> :user)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":name", '%'.$search['search'].'%');
        $st->bindValue(":user", $search['user']);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public static function friendRequestCount($user)
    {
        $conn=new Db();
        $sql="SELECT * FROM friends WHERE acceptFriend=:user AND accepted=0 AND seen=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $user);
        $st->execute();
        $conn=null;
        $result= $st->rowCount();
        return $result;
    }
    public static function removeUnseen($user)
    {
        $conn=new Db();
        $sql="UPDATE friends SET seen=1 WHERE acceptFriend=:user AND accepted=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $user);
        $st->execute();
        $conn=null;

    }

    public static function sendChatMessage($data)
    {
        $conn=new Db();
        $sql="INSERT INTO messages(sender,acceptor,text,time,seen) VALUES (:user, :friend, :text,NOW(),0)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->bindValue(":text", $data['message']);
        $st->execute();
        $conn=null;
    }

    public static function getChatHistory($data)
    {
        $conn=new Db();
        $sql= "SELECT * FROM messages WHERE (sender=:user AND acceptor=:friend) OR (sender=:friend AND acceptor=:user) ORDER BY time ASC";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user",$data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
        $result= $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public static function clearChat($data)
    {
        $conn=new Db();
        $sql= "DELETE FROM messages WHERE (sender=:user AND acceptor=:friend) OR (sender=:friend AND acceptor=:user)";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user",$data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
    }

    public static function chatCount($data)
    {
        $conn=new Db();
        $sql="SELECT * FROM messages WHERE sender=:friend AND acceptor=:user AND seen=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;
        $result= $st->rowCount();
        return $result;
    }

    public static function clearCountChat($data)
    {
        $conn=new Db();
        $sql="UPDATE messages SET seen=1 WHERE sender=:friend AND acceptor=:user AND seen=0";
        $st= $conn->db->prepare($sql);
        $st->bindValue(":user", $data['user']);
        $st->bindValue(":friend", $data['friend']);
        $st->execute();
        $conn=null;

    }
}