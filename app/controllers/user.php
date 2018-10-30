<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/28/18
 * Time: 10:09 PM
 */

namespace App\controllers;


class user
{
    public function login($service)
    {
        $service->render('app/views/login.phtml');

    }
    public function signup()
    {
        if(isset($_POST)){
            $message=$_POST['first_name'];
        }
        if (isset($_POST['submit'])) {

            //collect form data
            extract($_POST);


            if ($username == '') {
                $message[] = 'Please enter the username.';
            }


            if ($password == '') {
                $message[] = 'Please enter the password.';
            }


            if ($passwordConfirm == '') {
                $message[] = 'Please confirm the password.';
            }

            if ($password != $passwordConfirm) {
                $message[] = 'Passwords do not match.';
            }
            if (!$message)
            {
                $hashedPassword= password_hash($password,PASSWORD_BCRYPT);
                $data = array(
                    'username' => $username,
                    'hashPass' => $hashedPassword

                );
                $status = $this->model->updateAdmin($data);
                if (isset($status) && !empty($status)) {
                    $error[] = $status;
                }
                if (!$error) {
                    header('location: /admin/index');
                }
            }




        }
        return $message;
    }
}