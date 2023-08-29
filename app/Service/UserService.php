<?php

namespace dokterkepin\Belajar\PHP\MVC\Service;

use dokterkepin\Belajar\PHP\MVC\Config\Database;
use dokterkepin\Belajar\PHP\MVC\Domain\User;
use dokterkepin\Belajar\PHP\MVC\Model\UserLoginResponse;
use dokterkepin\Belajar\PHP\MVC\Model\UserLoginRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserProfileUpdateResponse;
use dokterkepin\Belajar\PHP\MVC\Model\UserProfileUpdateRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserRegisterRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserRegisterResponse;
use dokterkepin\Belajar\PHP\MVC\Model\UserUpdatePasswordRequest;
use dokterkepin\Belajar\PHP\MVC\Model\UserUpdatePasswordResponse;
use dokterkepin\Belajar\PHP\MVC\Repository\UserRepository;
use dokterkepin\Belajar\PHP\MVC\Exception\ValidationException;


class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse{
        $this->validateUserRegistrationRequest($request);

       try {
           Database::beginTransaction();
           $user = $this->userRepository->findById($request->id);
           if($user !== null){
               throw new ValidationException("user already exist");
           }

           $user = new User();
           $user->id = $request->id;
           $user->name = $request->name;
           $user->password = password_hash($request->password, PASSWORD_BCRYPT);

           $this->userRepository->save($user);

           $response = new UserRegisterResponse();
           $response->user = $user;

           Database::commitTransaction();
           return $response;
       }catch (\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
       }

    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request){
        if($request->id == null || $request->name == null || $request->password == null ||
            trim($request->id) == " " || trim($request->name) == " " || trim($request->password) == " ")
        {
            throw new ValidationException("Id, name or password can not be blank");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);
        $user = $this->userRepository->findById($request->id);
        if($user == null){
            throw new ValidationException("Id or Password is wrong");
        }

        if(password_verify($request->password, $user->password)){
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        }else{
            throw new ValidationException("Id or Password is wrong");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if($request->id == null || $request->password == null ||
            trim($request->id) == " " || trim($request->password) == " ")
        {
            throw new ValidationException("Id or password can not be blank");
        }
    }

    public function updateProfile(UserProfileUpdateRequest $request): UserProfileUpdateResponse{
        $this->validateUserProfileUpdate($request);

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if($user == null){
                throw new ValidationException("User is not found");
            }
            $user->name = $request->name;
            $this->userRepository->update($user);

            Database::commitTransaction();
            $response = new UserProfileUpdateResponse();
            $response->user = $user;
            return $response;
        }catch(\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }


    }

    private function validateUserProfileUpdate(UserProfileUpdateRequest $request){
        if($request->name == null || $request->id == null ||
            trim($request->name) == " " || trim($request->id) == " ")
        {
            throw new ValidationException("name or id can not be blank");
        }
    }

    public function updatePassword(UserUpdatePasswordRequest $request): UserUpdatePasswordResponse{
        $this->validateUserPasswordUpdate($request);

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if ($user == null){
                throw new ValidationException("User is not found");
            }

            if(!password_verify($request->oldPassword, $user->password)){
                throw new ValidationException("Old password is wrong");
            }

            $user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->userRepository->update($user);

            Database::commitTransaction();
            $response = new UserUpdatePasswordResponse();
            $response->user = $user;
            return $response;
        }catch(\Exception $exception){
            Database::rollbackTransaction();
            throw $exception;
        }

    }

    private function validateUserPasswordUpdate(UserUpdatePasswordRequest $request){
        if($request->oldPassword == null || $request->newPassword == null || $request->id == null ||
            trim($request->oldPassword) == " " || trim($request->newPassword) == " " || trim($request->id) == " ")
        {
            throw new ValidationException("Your Id, New Password or Old Password can not be blank");
        }
    }
}