<?php
require_once __DIR__ . '/vendor/autoload.php';

// Set error display and the type to be displayed.

ini_set('display_errors', true);

use App\config\settings;
use App\controllers\user;
use App\controllers\home;
use App\controllers\friends;


//define the app configurations
$set= new settings();





$klein = new \Klein\Klein();
$klein->respond('GET', '/signup', function ($request, $response,$service){$service->render('app/views/signup.phtml');});
//$klein->respond('GET', '/?',[new Auth,'login']);
//r
$klein->respond('GET', '/login', function ($request, $response,$service){$service->render('app/views/login.phtml');});

$klein->respond('GET', '/?',function ($request, $response){$response->redirect('/login');});

/*$klein->respond('GET', '/login', function ($request, $response, $service) {
    $auth = new Auth();
    $auth->login($service);
});*/
//this is for signup the post is sent to /create
$klein->respond('POST', '/create', function ($request, $response,$service){
    $user=new user();
    //passing response for redirect
    $error=$user->signup($response);
    $service->render('app/views/signup.phtml',array('error'=>$error));
});

$klein->respond('POST', '/login',function ($request, $response,$service){
    $user=new user();
    $error= $user->login();
    $service->render('app/views/login.phtml',array('error'=>$error));
});

$klein->respond('GET', '/logout',function ($request, $response){
    $user=new user();
    $user->logout();
});

$klein->respond('GET', '/index', function ($request, $response,$service){
    $service->render('app/views/index.phtml');
});
$klein->respond('POST', '/index', function ($request, $response,$service){
    $home=new home();
    $home->action();
});

$klein->respond('GET', '/addfriend', function ($request, $response,$service){$service->render('app/views/addfriend.phtml');});
$klein->respond('POST', '/addfriend', function ($request, $response,$service){
    $friend=new friends();
    $friend->action();
});

$klein->dispatch();