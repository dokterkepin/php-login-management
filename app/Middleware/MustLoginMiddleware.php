<?php

namespace dokterkepin\Belajar\PHP\MVC\Middleware;

use dokterkepin\Belajar\PHP\MVC\App\View;
use dokterkepin\Belajar\PHP\MVC\Config\Database;
use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
use dokterkepin\Belajar\PHP\MVC\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct(){
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }
    function before(): void{
        $user = $this->sessionService->current();
        if($user == null){
            View::redirect("/users/login");
        }
    }

}