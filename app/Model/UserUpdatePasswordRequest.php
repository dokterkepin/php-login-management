<?php

namespace dokterkepin\Belajar\PHP\MVC\Model;

class UserUpdatePasswordRequest
{

    public ?string $id = null;
    public ?string $oldPassword = null;
    public ?string $newPassword =  null;

}