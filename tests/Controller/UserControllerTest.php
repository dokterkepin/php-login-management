<?php
namespace dokterkepin\Belajar\PHP\MVC\Controller{

    require_once __DIR__ . "/../Helper/helper.php";

    use dokterkepin\Belajar\PHP\MVC\Domain\Session;
    use dokterkepin\Belajar\PHP\MVC\Domain\User;
    use dokterkepin\Belajar\PHP\MVC\Model\UserUpdatePasswordRequest;
    use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
    use dokterkepin\Belajar\PHP\MVC\Config\Database;
    use dokterkepin\Belajar\PHP\MVC\Repository\SessionRepository;
    use dokterkepin\Belajar\PHP\MVC\Service\SessionService;
    use PHPUnit\Framework\TestCase;

    class UserControllerTest extends TestCase
    {
        private UserController $userController;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;


        protected function setUp(): void
        {
            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->sessionRepository->deleteAll();

            $this->userController = new UserController();
            $this->userRepository =  new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();
            putenv("mode=test");
        }

        public function testRegister()
        {
            $this->userController->register();

            $this->expectOutputRegex("[Register New User]");
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");

        }

        public function testPostRegisterSuccess()
        {
            $_POST["id"] = "dokterkepin55";
            $_POST["name"] = "Kevinchang";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();
            $this->expectOutputRegex("[Location: login]");
        }

        public function testPostRegisterValidationError(){
            $_POST["id"] = "";
            $_POST["name"] = "Kevin";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Register New User]");
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Id, name or password can not be blank]");


        }

        public function testPostRegisterDuplicate()
        {
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = "rahasia";

            $this->userRepository->save($user);

            $_POST["id"] = "dokterkepin";
            $_POST["name"] = "Kevin";
            $_POST["password"] = "rahasia";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Register New User]");
            $this->expectOutputRegex("[Register]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[id, name or password can not be blank]");
            $this->expectOutputRegex("[user already exist]");

        }

        public function testLogin(){
            $this->userController->login();
            $this->expectOutputRegex("[User Login]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Password]");

        }

        public function testLoginSuccess(){
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $_POST["id"] = "dokterkepin";
            $_POST["password"] =  "rahasia";

            $this->userController->postLogin();
            $this->expectOutputRegex("[Location: /]");
            $this->expectOutputRegex("[X-DOKTERKEPIN-SESSION: ]");
        }

        public function testLoginValidationError(){
            $_POST["id"] = "";
            $_POST["password"] = "";

            $this->userController->postLogin();

            $this->expectOutputRegex("[User Login]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Id or password can not be blank]");

        }

        public function testUserLoginNotFound(){
            $_POST["id"] = "notfound";
            $_POST["password"] = "notfound";

            $this->userController->postLogin();

            $this->expectOutputRegex("[User Login]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Id or Password is wrong]");
        }

        public function testLoginWrongPassword(){
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $_POST["id"] = "dokterkepin";
            $_POST["password"] = "salah";

            $this->userController->postLogin();

            $this->expectOutputRegex("[User Login]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Password]");
            $this->expectOutputRegex("[Id or Password is wrong]");
        }

        public function testLogout(){
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

            $this->userController->logout();
            $this->expectOutputRegex("[Location: /]");
            $this->expectOutputRegex("[X-DOKTERKEPIN-SESSION: ]");
        }

        public function testUpdateProfile(){
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

            $this->userController->UpdateProfile();


            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Name]");
            $this->expectOutputRegex("[Kevin]");
            $this->expectOutputRegex("[dokterkepin]");
            $this->expectOutputRegex("[Update Profile]");
        }

        public function testPostUpdateProfile(){
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

            $_POST["name"] = "Shawn";
            $this->userController->postUpdateProfile();
            $this->expectOutputRegex("[Location: /]");

            $result = $this->userRepository->findById("dokterkepin");
            $this->assertEquals("Shawn", $result->name);
        }

        public function testPostUpdateProfileValidationError(){
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

            $_POST["name"] = "";
            $this->userController->postUpdateProfile();
            $this->expectOutputRegex("[Update Profile]");
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[dokterkepin]");
            $this->expectOutputRegex("[name or id can not be blank]");
        }

        public function testUpdatePassword(){
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;


            $this->userController->updatePassword();
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Old Password]");
            $this->expectOutputRegex("[New Password]");
            $this->expectOutputRegex("[Change Password]");
        }

        public function testPostUpdatePassword(){
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST["old"] = "rahasia";
            $_POST["new"] = "new";

            $this->userController->postUpdatePassword();
            $result = $this->userRepository->findById($user->id);

            $this->expectOutputRegex("[Location: /]");
            $this->assertTrue(password_verify("new", $result->password));
        }

        public function testPostUpdatePasswordValidationError(){
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST["old"] = "";
            $_POST["new"] = "";

            $this->userController->postUpdatePassword();
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Old Password]");
            $this->expectOutputRegex("[New Password]");
            $this->expectOutputRegex("[Change Password]");
            $this->expectOutputRegex("[Change Password]");
            $this->expectOutputRegex("[Your Id, New Password or Old Password can not be blank]");
        }

        public function testPostUpdatePasswordWrong(){
            $user = new User();
            $user->id = "dokterkepin";
            $user->name = "Kevin";
            $user->password = password_hash("rahasia", PASSWORD_BCRYPT);
            $this->userRepository->save($user);

            $session = new Session();
            $session->id = uniqid();
            $session->userId = $user->id;
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

            $_POST["old"] = "wrong";
            $_POST["new"] = "new";

            $this->userController->postUpdatePassword();
            $this->expectOutputRegex("[Id]");
            $this->expectOutputRegex("[Old Password]");
            $this->expectOutputRegex("[New Password]");
            $this->expectOutputRegex("[Change Password]");
            $this->expectOutputRegex("[Change Password]");
            $this->expectOutputRegex("[Old password is wrong]");
        }


    }


}


