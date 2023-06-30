<?php 
namespace dokterkepin\Belajar\PHP\MVC\Controller;

use dokterkepin\Belajar\PHP\MVC\App\View;

class HomeController{
    function index(): void{
        $model = [
            "title" => "Belajar PHP",
            "content" => "selamat belajar PHP di channel Programmer Zaman Now"
        ];

        View::render("Home/index", $model);
    }

    function hello(): void{
        echo "HomeController.hello()";
    }

    function world(): void{
        echo "HomeController.world()";
    }

    function about(): void{
        echo "Author: dokterkepin";
    }

    function login(): void{
        $request = [
          "username" => $_POST["username"],
          "password" => $_POST["password"]
        ];

        $user = [

        ];

        $response = [
          "message" => "Login Successfully"
        ];
    }
}

