<?php
require_once __DIR__ . "/../vendor/autoload.php";

use dokterkepin\Belajar\PHP\MVC\App\Router;
use dokterkepin\Belajar\PHP\MVC\Controller\HomeController;
use dokterkepin\Belajar\PHP\MVC\Controller\ProductController;
use dokterkepin\Belajar\PHP\MVC\Middleware\AuthMiddleware;

Router::add("GET", "/", HomeController::class, "index");
Router::add("GET", "/hello", HomeController::class, "hello");
Router::add("GET", "/world", HomeController::class, "world", [AuthMiddleware::class]);
Router::add("GET", "/products/([0-9a-zA-Z]+)/categories/([0-9a-zA-Z]+)", ProductController::class, "categories");
Router::run();
