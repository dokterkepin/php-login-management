<?php

namespace dokterkepin\Belajar\PHP\MVC\Controller;

use dokterkepin\Belajar\PHP\MVC\Domain\Session;
use dokterkepin\Belajar\PHP\MVC\Domain\User;
use dokterkepin\Belajar\PHP\MVC\Service\SessionService;
use PHPUnit\Framework\TestCase;
use dokterkepin\Belajar\PHP\MVC\Config\Database;
use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void{
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest(){
        $this->homeController->index();
        $this->expectOutputRegex("[New User]");
    }

    public function testUserLogin(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->homeController->index();
        $this->expectOutputRegex("[Welcome Home]");
    }

}
