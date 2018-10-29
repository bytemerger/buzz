<?php
require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', true);

use App\config\settings;
use App\controllers\Auth;

//define the app configurations
$set= new settings();


// Set error display and the type to be displayed.



$klein = new \Klein\Klein();
$klein->respond('GET', '/login',[new Auth,'login']);
$klein->respond('GET', '/?',[new Auth,'login']);
$klein->get('/signup', function ($request, $response)
{
    $auth = new Auth();
    $auth->signup();
    //var_dump($request->paramsGet());
    //$response->body(json_encode($auth->signup()));
});


$klein->dispatch();