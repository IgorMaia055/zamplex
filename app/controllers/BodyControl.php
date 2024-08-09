<?php

namespace Controllers;

use Zamplate\Zamplate;

class BodyControl
{
    private $zamplate;

    public function __construct()
    {
        $this->zamplate = new Zamplate(__DIR__ . '/../views');
    }

    public function header()
    {
        echo $this->zamplate->renderizar('header.html', []);
    }

    public function footer()
    {
        echo $this->zamplate->renderizar('footer.html', []);
    }
}
