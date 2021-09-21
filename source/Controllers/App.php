<?php

namespace Source\Controllers;

use Source\Models\User;

/**
 * Class Auth
 * @package	Source\Controller
 */
class App extends Controller
{
    /** @var $user */
    protected $user;
    /**
     * Auth constructor
     * @param	$router	
     */
    public function __construct($router)
    {
        parent::__construct($router);  
        
        if(
            empty($_SESSION["user"]) 
            || !$this->user = (new User())->findById(($_SESSION["user"])) // if user exists instances var user
        ) {
            unset($_SESSION["user"]);
            flash("error", "Acesso negado. Favor realizar o Log In");
            $this->router->redirect("web.login");
        }
    }

    public function home(): void
    {
        $head = $this->seo->optimize(
            "Bem-vindo(a) {$this->user->userFirstName} | " . site("name"),
            site("desc"),
            $this->router->route("app.home"),
            routerImage("Conta de {$this->user->userFirstName}"),
        )->render();

        echo $this->view->render("theme/dashboard", [
            "head"=>$head,
            "user"=>$this->user
        ]);
    }

    public function logoff(): void
    {
        unset($_SESSION["user"]);

        flash("info", "Você saiu com sucesso, volte logo {$this->user->userFirstName}");
        $this->router->redirect("web.login");
    }

}