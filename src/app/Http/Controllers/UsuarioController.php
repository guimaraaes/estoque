<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        $p = User::where('id', '>', '1')->get();
        return response()->json($p->toArray());
    }

    public function userAuth()
    {
        $user = Auth::user();
        return response()->json($user->toArray());
    }

    public function destroy($id)
    {
        User::destroy($id);
    }
}
