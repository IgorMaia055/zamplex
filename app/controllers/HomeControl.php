<?php

namespace Controllers;

use Zamplate\Zamplate;

class HomeControl
{
    private $zamplate;

    public function __construct()
    {
        $this->zamplate = new Zamplate(__DIR__ . '/../views');
    }

    public function index()
    {
        echo $this->zamplate->renderizar('home.html', [
            'teste' => 'Henry'
        ]);
    }

    public function test()
    {
        echo 'teste2';
    }

    public function dynamicRoute($str)
    {
        echo "Parâmetro recebido: " . htmlspecialchars($str);
    }
}
