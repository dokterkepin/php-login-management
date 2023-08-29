<?php

namespace dokterkepin\Belajar\PHP\MVC\Service;

use dokterkepin\Belajar\PHP\MVC\Exception\ValidationException;
use dokterkepin\Belajar\PHP\MVC\Model\UserLoginRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserProfileUpdateRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserRegisterRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserUpdatePasswordRequest;
use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
use PHPUnit\Framework\TestCase;
use dokterkepin\Belajar\PHP\MVC\Config\Database;
use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
use dokterkepin\Belajar\PHP\MVC\Domain\User;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void{
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);

        $this->sessionRepository = new SessionRepository($connection);
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess(){
        $request = new UserRegisterRequest();
        $request->id = "dokterkepin";
        $request->name = "Kevin";
        $request->password = "rahasia";

        $response = $this->userService->register($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->name, $response->user->name);
        self::assertNotEquals($request->password, $response->user->password);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed(){
        self::expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->id = "";
        $request->name = "";
        $request->password = "";
        $this->userService->register($request);
    }

    public function testRegisterDuplicate(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "dokterkepin";
        $request->name = "Kevin";
        $request->password = "rahasia";

        $this->userService->register($request);
    }

    public function testLoginNotFound(){
        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = "dokterkepin";
        $request->password = "rahasia";

        $this->userService->login($request);


    }

    public function testLoginWrongPassword(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = password_hash("seorangdokter", PASSWORD_BCRYPT);


        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = "dokterkepin";
        $request->password = "rahasia";

        $this->userService->login($request);
    }


    public function testLoginSuccess(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);


        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = "dokterkepin";
        $request->password = "rahasia";

        $response = $this->userService->login($request);

        $this->assertEquals($request->id, $response->user->id);
        $this->assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testUpdateSuccess(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $request = new UserProfileUpdateRequest();
        $request->id = "dokterkepin";
        $request->name = "Shawn";
        $this->userService->updateProfile($request);

        $result = $this->userRepository->findById($user->id);

        $this->assertEquals($request->name, $result->name);

    }

    public function testUpdateValidationError(){
        $this->expectException(ValidationException::class);

        $request = new UserProfileUpdateRequest();
        $request->id = "";
        $request->name = "";
        $this->userService->updateProfile($request);
    }

    public function testUpdateNotFound(){
        $this->expectException(ValidationException::class);

        $request = new UserProfileUpdateRequest();
        $request->id = "kevin";
        $request->name = "Shawn";
        $this->userService->updateProfile($request);
    }

    public function testUpdatePasswordSuccess(){
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest();
        $request->id = "dokterkepin";
        $request->oldPassword = "rahasia";
        $request->newPassword = "baru";

        $this->userService->updatePassword($request);

        $result = $this->userRepository->findById($request->id);

        $this->assertTrue(password_verify($request->newPassword, $result->password));
    }

    public function testUpdatePasswordValidationError(){
        $this->expectException(ValidationException::class);

        $request = new UserUpdatePasswordRequest();
        $request->id = "dokterkepin";
        $request->oldPassword = "rahasia";
        $request->newPassword = "";

        $this->userService->updatePassword($request);
    }

    public function testUpdatePasswordWrong(){
        $this->expectException(ValidationException::class);
        $user = new User();
        $user->id = "dokterkepin";
        $user->name = "Kevin";
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
        $this->userRepository->save($user);

        $request = new UserUpdatePasswordRequest();
        $request->id = "dokterkepin";
        $request->oldPassword = "salah";
        $request->newPassword = "baru";

        $this->userService->updatePassword($request);

        $result = $this->userRepository->findById($user->id);



    }

    public function testUpdatePasswordNotFound(){
        $this->expectException(ValidationException::class);
        $request = new UserUpdatePasswordRequest();
        $request->id = "dokterkepin";
        $request->oldPassword = "salah";
        $request->newPassword = "baru";

        $this->userService->updatePassword($request);
    }

}
