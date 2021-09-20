<?php

namespace Source\Controllers;

class Web extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);
                
        //if(!empty($_SESSION["user"])){            
         //  $this->router->redirect("app.home");           
        //}
              
    }

    public function login(): void
    {
        $head = $this->seo->optimize(
            "Faça o Login Para Continuar | " . site("name"),
            site("desc"),
            $this->router->route("web.login"),
            routerImage("Login"),
        )->render();

        echo $this->view->render("theme/login", [
            "head"=>$head
        ]);
    }

    public function register(): void
    {
        $head = $this->seo->optimize(
            "Crie sua conta no " . site("name"),
            site("desc"),
            $this->router->route("web.register"),
            routerImage("Register"),
        )->render();

        $form_user = new \stdClass();
        $form_user->first_name = null;
        $form_user->last_name = null;
        $form_user->email = null;        

        echo $this->view->render("theme/register", [
            "head"=> $head,
            "user"=> $form_user
        ]);
    }

    public function forget(): void
    {
        $head = $this->seo->optimize(
            "Recupere Sua Senha | " . site("name"),
            site("desc"),
            $this->router->route("web.forget"),
            routerImage("Forget"),
        )->render();

        echo $this->view->render("theme/forget", [
            "head"=> $head
        ]);
    }

    public function reset(): void
    {
        $head = $this->seo->optimize(
            "Crie Sua Nova Senha | " . site("name"),
            site("desc"),
            $this->router->route("web.reset"),
            routerImage("Reset"),
        )->render();

        echo $this->view->render("theme/reset", [
            "head"=>$head
        ]);
    }

    public function error($data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);
        $head = $this->seo->optimize(
            "Ooops {$error} | " . site("name"),
            site("desc"),
            $this->router->route("web.error", ["errcode" => $error]),
            routerImage($error),
        )->render();

        echo $this->view->render("theme/error", [
            "head"=> $head,
            "error"=> $error
        ]);
    }
}