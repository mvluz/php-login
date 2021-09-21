<?php

namespace Source\Controllers;

use Source\Models\User;

/**
 * Class Auth
 * @package	Source\Controller
 */
class Auth extends Controller
{
    /**
     * Auth constructor
     * @param	$router	
     */
    public function __construct($router)
    {
        parent::__construct($router);              
    }

    /**
     * @param	$data	
     */
    public function login($data): void
    {
        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data["passwd"], FILTER_DEFAULT);

        if(!$email || !$passwd){
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Informe seu e-mail e senha para fazer Log In"
            ]);
            return;
        }

        $user = (new User())->find("userEmail = :email", "email={$email}")->fetch();
        
        if(!$user || password_verify($passwd, $user->userPassword)){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "E-mail ou Senha informados não conforem"
            ]);
            return;
        }

        $_SESSION["user"] = $user->id;
        echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route("app.home")
        ]);
        
    }


    /**
     * @param	$data	
     */
    public function register($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (in_array("", $data)){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Preencha todos os campos para cadastrar-se"
            ]);
            return;
        }
/*
        if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Favor informar um e-mail vádido para continuar"
            ]);
            return;
        }

        $checkUserEmail = (new User())->find("userEmail=:e", "e={$data["email"]}")->count();
        if($checkUserEmail){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => "Já existe um usuário cadastrado com esse e-mail"
            ]);
            return;
        }
*/        
        $user = new User;
        $user->userFirstName = $data["first_name"];
        $user->userLastName = $data["last_name"];
        $user->userEmail = $data["email"];
        $user->userPassword = $data["passwd"];

        if(!$user->save()){
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $user->fail()->getMessage()
            ]);
            return;
        }
        
        $_SESSION["user"] = $user->id;

        echo $this->ajaxResponse("redirect", [
            "url"=>$this->router->route("app.home")
        ]);
    }
}