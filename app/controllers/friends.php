<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/4/18
 * Time: 10:32 AM
 */

namespace App\controllers;

use \App\helpers\session;
use \App\models\friends as friend;

class friends
{
    public function __construct()
    {
        $session=new session();
        $session->createSession();

        if(!$session->isLogged()){
            header('location: /login');
        }
    }

    public function search(){

        $search=array(
            'search'=>$_POST['text'],
            'user'=>$_SESSION['userName']
        );
        $result = friend::search($search);
        if ($result){
            $data['status']='ok';
            $data['result']=$result;
        }

        echo json_encode($data);
    }
    public function add(){
        //request is being sent to
        $accept=$_POST['text'];

        $add= array(
            'sendFriend'=> $_SESSION['userName'],
            'acceptFriend'=>$accept,
        );
        $result = friend::add($add);
        if ($result != ''){
            echo 'unable to add friend';
            exit();
        }
        else{
            echo 'friend added';
        }


    }
}