<?php

namespace App\Controllers;

class PageController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $template = $this->twig->load('home.html.twig');
        echo $template->render([]);
    }

}