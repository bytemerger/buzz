<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/6/18
 * Time: 11:58 PM
 */

namespace App\controllers;

use \App\helpers\session;
use \App\models\friends;

class home
{
    public function __construct()
    {
        $session=new session();
        $session->createSession();

        if(!$session->isLogged()){
            header('location: /login');
        }
    }

    public function index($service)
    {
        $user=$_SESSION['userName'];
        $result=friends::getFriends($user);
        $service->render('app/views/index.phtml',array('friends'=>$result));
    }
    public function action(){
        switch ($_POST['action'])
        {
            case 'list': $this->friendRequest();
                break;
            case 'listSent': $this->listSent();
                break;
            case 'cancelReq': $this->cancelReq();
                break;
            case 'deleteReq': $this->deleteReq();
                break;
            case 'acceptReq': $this->acceptReq();
                break;
            case 'deleteFriend': $this->deleteFriend();
                break;
        }
    }
    //list notification
    public function friendRequest(){
        $user=$_SESSION['userName'];
        $result =friends::friendRequest($user);
        echo json_encode($result);
    }

    public function listSent()
    {
        $user=$_SESSION['userName'];
        $result=friends::sentRequest($user);
        echo json_encode($result);
    }

    public function cancelReq()
    {
        $user=$_SESSION['userName'];
        $data=array(
            'user'=>$user,
            'friend'=>$_POST['friend']
        );
        friends::cancelRequest($data);
        echo 'request deleted';
    }
    public function deleteReq()
    {
        $user=$_SESSION['userName'];
        $data=array(
            'user'=>$user,
            'friend'=>$_POST['friend']
        );
        friends::deleteRequest($data);
        echo 'request deleted';
    }
    public function acceptReq()
    {
        $user=$_SESSION['userName'];
        $data=array(
            'user'=>$user,
            'friend'=>$_POST['friend']
        );
        friends::acceptRequest($data);
        echo 'request accepted';
    }

    public function deleteFriend()
    {
        $user=$_SESSION['userName'];
        $data=array(
            'user'=>$user,
            'friend'=>$_POST['friend']
        );
        friends::deleteFriend($data);
        echo $data['friend'].' has been un-friend';
    }

}