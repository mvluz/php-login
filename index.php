<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/Source/Controllers/Controller.php";
require __DIR__ . "/Source/Controllers/Web.php";

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

/**
 * AUTH SOCIAL
 */

/**
 * PROFILE
 */

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
