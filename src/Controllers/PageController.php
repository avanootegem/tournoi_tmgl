<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\PersonneModel\UserModel;
use App\Models\PersonneModel\StaffModel;

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