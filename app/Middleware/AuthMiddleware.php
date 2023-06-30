<?php

namespace dokterkepin\Belajar\PHP\MVC\Middleware;

class AuthMiddleware implements Middleware
{
    function before(): void{
        session_start();
        if(!isset($_SESSION["user"])){
            header("Location: /public/login");
            exit();
        }
    }
}