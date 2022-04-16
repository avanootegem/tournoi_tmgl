<?php

namespace App\Controllers;

use App\Models\TournamentModel;

class PageController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {   
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
                "type" => $type,
                "saison" => $lastTournament['saison'],
                "masters" => $masters,
                "challengers" => $challengers,
                "outsiders" => $outsiders
            ]); 
        }
    }

}