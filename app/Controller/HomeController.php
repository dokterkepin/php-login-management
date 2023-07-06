<?php 
namespace dokterkepin\Belajar\PHP\MVC\Controller;

use dokterkepin\Belajar\PHP\MVC\App\View;

class HomeController{
    public function index(){
        View::render("home/index", [
            "title" => "PHP Login Management"
        ]);
    }
}
