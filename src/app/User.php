<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

//class User extends Model
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'token'
        ];
    //

    protected $hidden = [
        'password', 'remember_token',
    ];
    //
}
