<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/31/18
 * Time: 1:06 PM
 */

namespace App\helpers;

use App\models\login;
class session
{
    // create session
    public function createSession(){
        session_start();
    }

    //create user session and insert user login auth into db
    public function logUser($userName){
        $_SESSION['userName'] = $userName;

        $selector = base64_encode(random_bytes(8));
        $token = bin2hex(random_bytes(32));

        $cookieValue = $selector.':'.base64_encode($token);
        $hashedToken = hash('sha256', $token);

        $timestamp = time() + (86400 * 14);

        setcookie('authToken', $cookieValue, $timestamp, NULL, NULL, NULL, true);

        $data= array(
            'selector'=>$selector,
            'hashedToken'=>$hashedToken,
            'userName'=>$userName,
            'time'=>$timestamp
        );
        login::insertLogin($data);
    }

    public function relogUser($userName){
        $_SESSION['userName'] = $userName;
    }

    public function isLogged(){
        if(isset($_SESSION['userName'])){
            return true;
        }else{
            if(isset($_COOKIE['authToken'])){

                list($selector, $token) = explode(':', $_COOKIE['authToken']);

                $results= login::checkLogin($selector);

                if($results){
                    if(hash_equals($results['loginToken'], hash('sha256', base64_decode($token)))){
                        $this->relogUser($results['loginUserName']);
                    }else{
                        $this->logOut();
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    public function logOut(){

        list($selector, $token) = explode(':', $_COOKIE['authToken']);
        $data= array(
            'selector'=>$selector,
            'userName'=>$_SESSION['userName']
        );
        login::deleteLogin($data);
        unset($_SESSION['userName']);
        session_destroy();
        setcookie('authToken', '', time() - 3600);
        unset($_COOKIE['authToken']);
    }


}