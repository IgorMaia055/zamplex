<?php

namespace Controllers;

use Zamplate\Zamplate;
use src\Helpers\Helpers;

class ErrorControl
{
    private $zamplate;

    public function __construct()
    {
        $this->zamplate = new Zamplate(__DIR__ . '/../views');
        $this->zamplate->addFunction('url', [Helpers::class, 'generateUrl']);
    }

    public function error($type)
    {

        echo $this->zamplate->renderizar('error.html', [
            'type' => $type
        ]);
    }
}
