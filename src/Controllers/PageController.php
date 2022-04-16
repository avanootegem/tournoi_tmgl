<?php

namespace App\Controllers;


use App\Models\TournamentModel;
use App\Models\UserModel;


class PageController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {   
        $auth = $_SESSION['auth'];
        $flash = flash();
        $tournamentModel = new TournamentModel();
        $lastTournament = $tournamentModel->getLastTounament();
        if($lastTournament['type'] == 1) {
            $type = "Qualif";
            $tournament = $lastTournament;
            $template = $this->twig->load('home.html.twig');
            echo $template->render([
                "type" => $type,
                "tournament" => $tournament
            ]);
        } else {
            $type = "Championship";
            $masters = $tournamentModel->getRankingT($lastTournament['saison'], "Master");
            $challengers = $tournamentModel->getRankingT($lastTournament['saison'], "Challenger");
            $outsiders = $tournamentModel->getRankingT($lastTournament['saison'], "Outsider");
            $template = $this->twig->load('home.html.twig');
            echo $template->render([
                "auth" => $auth,
                "flash" => $flash,
                "type" => $type,
                "saison" => $lastTournament['saison'],
                "masters" => $masters,
                "challengers" => $challengers,
                "outsiders" => $outsiders
            ]); 
        }
    }

    public function create_account()
    {
        $template = $this->twig->load('account/create_account.html.twig');
        echo $template->render([]);

    }

    public function creating_account()
    {
        if($_POST['password'] === $_POST['confirm_password']) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $userModel = new UserModel();
            $userModel->create_account($_POST['username'], $_POST['email'], $password);
            $userModel->login($_POST['username'], $_POST['password']);
            $_SESSION['flash']['succes'] = "Votre compte a bien été créer";
            header("Location : ".$this->baseUrl."/my_account");
        } else {
            $_SESSION['flash']['danger'] = "Erreur lors de la création de votre compte";
            header("Location : ".$this->baseUrl."/create_account");
        }
    }

    public function my_account()
    {   
        $auth = $_SESSION['auth'];
        $flash = flash();

        $template = $this->twig->load('account/my_account.html.twig');
        echo $template->render([
            "auth" => $auth,
            "flash" => $flash
        ]);
    }

    public function login() {
        $template = $this->twig->load('account/login.html.twig');
        $auth = $_SESSION['auth'];
        $flash = flash();
        echo $template->render([
            "auth" => $auth,
            "flash" => $flash
        ]);
    }

    public function loging()
    {
        $userModel = new UserModel();
        $userModel->login($_POST['username'], $_POST['password']);
        header("Location: ".$this->baseUrl);
    }

    public function logout()
    {
        $_SESSION['auth'] = false;
        header("Location: ".$this->baseUrl);
    }
}