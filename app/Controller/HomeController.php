<?php 
namespace dokterkepin\Belajar\PHP\MVC\Controller;

use dokterkepin\Belajar\PHP\MVC\App\View;
use dokterkepin\Belajar\PHP\MVC\Domain\Session;
use dokterkepin\Belajar\PHP\MVC\Domain\User;
use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
use dokterkepin\Belajar\PHP\MVC\Service\SessionService;
use dokterkepin\Belajar\PHP\MVC\Config\Database;

class HomeController{

    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function index(){
        $user = $this->sessionService->current();
        if($user == null){
            View::render("Home/index", [
                "title" => "PHP Login Management"
            ]);
        }else{
            View::render("Home/dashboard", [
                "title" => "Dashboard",
                "user" => [
                    "name" => $user->name
                ]
            ]);
        }

    }
}
