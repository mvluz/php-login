<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/Source/Controllers/Controller.php";
require __DIR__ . "/Source/Controllers/Web.php";
require __DIR__ . "/Source/Controllers/Auth.php";
require __DIR__ . "/Source/Controllers/App.php";
require __DIR__ . "/Source/Models/User.php";

use CoffeeCode\Router\Router;

$router = new Router(site());
$router->namespace("Source\Controllers");

/**
 * WEB
 */
$router->group(null);
$router->get("/","Web:login","web.login");
$router->get("/cadastrar","Web:register","web.register");
$router->get("/recuperar","Web:forget","web.forget");
$router->get("/senha/{email}/{forget}","Web:reset","web.reset");


/**
 * AUTH
 */
$router->group(null);
$router->post("/login","Auth:login","auth.login");
$router->post("/register","Auth:register","auth.register");
$router->post("/forget","Auth:forget","auth.forget");
$router->post("/reset","Auth:reset","auth.reset");


/**
 * AUTH SOCIAL
 */

/**
 * PROFILE
 */
$router->group("agenda");
$router->get("/","App:home","app.home");
$router->get("/sair","App:logoff","app.logoff");

/**
 * ERROR
 */
$router->group("ops");
$router->get("/{errcode}", "Web:error", "web.error");

/**
 * ROUTER PROCESS
 */
 $router->dispatch();

 /**
  * ERRORS PROCESS
  */
if($router->error()){
  echo $router->error();
   $router->redirect("web.error", ["errcode" => $router->error()]);
}

ob_end_flush();
