<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/28/18
 * Time: 10:09 PM
 */

namespace App\controllers;

use \App\helpers\session;
use \App\models\user as users;

class user
{
    public function login()
    {
        $session = new Session;
        $session->createSession();

        if($session->isLogged()){
            header('Location: /index');
            exit();
        }

        $error=array();

            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'];

            if ($username == '') {
                $error[] = 'Username is required';
            }

            if(!$error) {
                $user = users::getUser($username);
                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        $session->logUser($user['username']);
                        header('Location: /index');
                        exit();

                    } else {
                        $error[] = 'incorrect password';
                    }
                } else {
                    $error[] = 'Username does not exist';
                }
            }


        return $error;


    }
    public function signup($response)
    {

       // if (isset($_POST['submit'])) {

            //collect form data
            $userName=$_POST['userName'];
            $firstName=$_POST['firstName'];
            $lastName=$_POST['lastName'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $confirmPassword=$_POST['confirmPassword'];


            $error=array();
            if (users::getUser($userName)){
                $error[]="The username already exists";
            }
            if ($userName == '') {
                $error[] = 'Please enter the username.';
            }


            if ($password == '') {
                $error[] = 'Please enter the password.';
            }


            if ($confirmPassword == '') {
                $error[] = 'Please confirm the password.';
            }

            if ($password != $confirmPassword) {
                $error[] = 'Passwords do not match.';
            }
            if (!$error)
            {
                $hashedPassword= password_hash($password,PASSWORD_BCRYPT);
                $data = array(
                    'username' => $userName,
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => $email,
                    'hashPass' => $hashedPassword

                );
                $status=users::signUp($data);
                if (isset($status) && !empty($status)) {
                    $error[] = $status;
                }

                if (!$error){
                   $response->redirect('/login');
                }
            }




        //}
        return $error;
    }

    public function logout()
    {
        $session = new Session;
        $session->createSession();
        $session->logOut();
        header('location: /login');
        exit();
    }
}