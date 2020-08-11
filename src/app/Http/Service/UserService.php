<?php

namespace App\Http\Service;

use App\User;


class UserService{
    public static function getUsers(){
        //$user = User::orderBy('id', 'desc')->get();
        return User::orderBy('id', 'desc')->paginate(10);
    }

    public static function destroyUser($id)
    {
        User::destroy($id);
    }
}