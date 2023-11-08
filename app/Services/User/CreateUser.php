<?php

namespace App\Services\User;

use App\Models\User;

class CreateUser
{
    /**
     * Create user.
     */
    public function execute(array $data): User
    {
        $user = User::create($data);
//        app(UpdateProfileImage::class)->execute(['user'=>$user,'image'=>$this->nullOrValue($data,'image')]);
        return $user;
    }
}
