<?php

namespace Controllers;

use Zamplate\Zamplate;
use src\Helpers\Helpers;

class LoginControl
{
    private $zamplate;

    public function __construct()
    {
        $this->zamplate = new Zamplate(__DIR__ . '/../views');
        $this->zamplate->addFunction('url', [Helpers::class, 'generateUrl']);
    }

    public function index()
    {
        echo $this->zamplate->renderizar('login.html', []);
    }

}
