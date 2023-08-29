<?php

namespace dokterkepin\Belajar\PHP\MVC\Repository;

use dokterkepin\Belajar\PHP\MVC\Domain\Session;
use dokterkepin\Belajar\PHP\MVC\Domain\User;
use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
use dokterkepin\Belajar\PHP\MVC\Config\Database;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->id = "dokterkepin";
        $user->name  = "Kevin";
        $user->password = "rahasia";
        $this->userRepository->save($user);
    }

    public function testSaveSuccess(){
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "dokterkepin";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        $this->assertEquals($session->id, $result->id);
        $this->assertEquals($session->userId, $result->userId);
    }

    public function testDeleteIdSuccess(){
        $session = new Session();
        $session->id = uniqid();
        $session->userId = "dokterkepin";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        $this->assertEquals($session->id, $result->id);
        $this->assertEquals($session->userId, $result->userId);

        $this->sessionRepository->deleteById($session->id);
        $result = $this->sessionRepository->findById($session->id);
        $this->assertNull($result);
    }

    public function testFindByIdNotFound(){
        $result = $this->sessionRepository->findById("notfound");
        $this->assertNull($result);
    }

}
