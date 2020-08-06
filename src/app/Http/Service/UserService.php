<?php

namespace App\Http\Service;

use App\User;


class UserService{
    public static function getUsers(){
        $user = User::all();
        return $user;
    }
    public static function destroyUser($id)
    {
        User::destroy($id);
    }
}