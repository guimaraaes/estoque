<?php

namespace App\Http\Service;

use App\User;


class UserService{
    public static function getUsers(){
        $user = User::orderBy('id', 'desc')->get();
        //$user = User::orderBy('id', 'desc')->paginate(1);
        return $user;
    }

    public static function destroyUser($id)
    {
        User::destroy($id);
    }
}