<?php

namespace dokterkepin\Belajar\PHP\MVC\Repository;

use dokterkepin\Belajar\PHP\MVC\Domain\User;
use dokterkepin\Belajar\PHP\MVC\Config\Database;
use PHPUnit\Framework\TestCase;


class UserRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;


    protected function setUp(): void{
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = "rahasia";

        $this->userRepository->save($user);
        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);

    }

    public function testFindByIdNotFound(){
        $user = $this->userRepository->findById("not found");
        self::assertNull($user);

    }

    public function testUpdate(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $user->name = "Shawn";
        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }
}
