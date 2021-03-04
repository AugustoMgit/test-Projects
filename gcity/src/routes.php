<?php
use core\Router;
$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@signin');
$router->post('/login', 'LoginController@signinLogged');

$router->get('/cadastro', 'LoginController@signup');
$router->post('/cadastro', 'LoginController@signupCheck');

$router->post('/ajax/setCoords', 'AjaxController@setCoords');

//publicações
$router->post('/ajax/publish', 'AjaxController@addPublish');

$router->get('/sobre/{nome}', 'HomeController@sobreP');
$router->get('/sobre', 'HomeController@sobre');