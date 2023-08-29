<?php

namespace dokterkepin\Belajar\PHP\MVC\Middleware{
    require_once __DIR__ . "/../Helper/helper.php";

    use dokterkepin\Belajar\PHP\MVC\Config\Database;
    use dokterkepin\Belajar\PHP\MVC\Domain\Session;
    use dokterkepin\Belajar\PHP\MVC\Domain\User;
    use dokterkepin\Belajar\PHP\MVC\Middleware\MustLoginMiddleware;
    use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
    use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
    use dokterkepin\Belajar\PHP\MVC\Service\SessionService;
    use dokterkepin\Belajar\PHP\MVC\Service\UserService;
    use PHPUnit\Framework\TestCase;

    class MustNotLoginMiddlewareTest extends TestCase
    {
        private MustNotLoginMiddleware $middleware;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;

        protected function setUp(): void
        {
            $this->middleware = new MustNotLoginMiddleware();
            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->userRepository = new UserRepository(Database::getConnection());

            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();
            putenv("mode=test");
        }

        public function testBeforeGuest(){
            $this->middleware->before();
            $this->expectOutputString("");
        }

        public function testBeforeLoginUser(){
            $user = new User();
            $user->name = "Kevin";
            $user->id = "dokterkepin";
            $user->password = "rahasia";
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $this->middleware->before();
            $this->expectOutputRegex("[Location: /]");


    }
    }
}


