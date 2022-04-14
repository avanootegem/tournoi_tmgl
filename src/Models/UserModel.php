<?php

namespace App\Models;

class UserModel extends GeneralModel 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_account($username, $email, $password) {
        $sql = "INSERT INTO users (`id_user`, `username`, `email`, `password`, `confirmed_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`) VALUES(NULL, :username, :email, :password, NULL, NOW(), NULL, NULL, NULL)";
        $req = $this->pdo->prepare($sql);
        $req->execute([
            "username" => $username,
            "email" => $email,
            "password" => $password
        ]);
    }

    public function login($username, $password) 
    {
        $sql = "SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL";
        $req = $this->pdo->prepare($sql);
        $req->execute(["username" => $username]);
        $auth = $req->fetch();

        if (password_verify($password, $auth['password']) && $auth) {
            $_SESSION['auth'] = $auth;
        } else {
            $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
        }
    }
}