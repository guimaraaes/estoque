<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Service\UserService;

class UserController extends Controller
{
    public function index()
    {
        $p = UserService::getUsers();
        return response()->json($p->toArray());
    }

    public function userAuth()
    {
        $p = Auth::user();
        return response()->json($p);
    }

    public function destroy($id)
    {
        UserService::destroyUser($id);
    }

}
