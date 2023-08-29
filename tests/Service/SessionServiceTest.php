<?php

namespace dokterkepin\Belajar\PHP\MVC\Service;

require_once __DIR__ . "/../Helper/helper.php";

use dokterkepin\Belajar\PHP\MVC\Domain\User;
use dokterkepin\Belajar\PHP\MVC\Domain\Session;
use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
use dokterkepin\Belajar\PHP\MVC\Config\Database;
use PHPUnit\Framework\TestCase;
class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;


    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "dokterkepin";
        $user->name  = "Kevin";
        $user->password = "rahasia";
        $this->userRepository->save($user);
    }

    public function testCreate(){
        $session = $this->sessionService->create("dokterkepin");
        $this->expectOutputRegex("[X-DOKTERKEPIN-SESSION: $session->id]");

        $result = $this->sessionRepository->findById($session->id);
        $this->assertEquals("$session->id", $result->id);
    }

    public function testDestroy(){
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "dokterkepin";
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;
        $this->sessionService->destroy();

        $this->expectOutputRegex("[X-DOKTERKEPIN-SESSION: ]");
        $result = $this->sessionRepository->findById($session->id);
        $this->assertNull($result);

    }

    public function testCurrent(){
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "dokterkepin";
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $user = $this->sessionService->current();

        $this->assertEquals("dokterkepin", $user->id);

    }
}
