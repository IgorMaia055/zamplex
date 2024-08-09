<?php
require 'vendor/autoload.php';

use src\Zamrouter\Zamrouter;
use src\Helpers\Helpers;

session_start();

$router = new Zamrouter();

try {
    $router->setDefaultNamespace('Controllers');

    // Registre as rotas
    $router->get('/', 'HomeControl@index');
    $router->get('/login', 'LoginControl@index');
    $router->post('/login/verification', 'LoginControl@verification');

    //Registro de bodys
    $router->get('/header-html', 'BodyControl@header');
    $router->get('/footer-html', 'BodyControl@footer');


    $router->start();

} catch (Exception $e) {
    if ($e->getCode() == 404) {
        Helpers::redirect('erro/404');
    }
}
