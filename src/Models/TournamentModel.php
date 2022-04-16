<?php

namespace App\Models;

class TournamentModel extends GeneralModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLastTounament() 
    {
        $sql = "SELECT * FROM tournament WHERE 1 ORDER BY date_maj DESC LIMIT 1";
        $req = $this->pdo->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    public function getRankingT($saison, $catégorie)
    {
        $sql = "SELECT pseudo, champ_medal, gold_medal, silver_medal, bronze_medal FROM tournament NATURAL JOIN ranking_t NATURAL JOIN participant WHERE catégorie = :categorie AND saison = :saison ORDER BY champ_medal DESC, gold_medal DESC, silver_medal DESC, bronze_medal DESC, id_rankingT";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "saison" => $saison,
            "categorie" => $catégorie
        ]);
        return $req->fetchAll();
    }
}