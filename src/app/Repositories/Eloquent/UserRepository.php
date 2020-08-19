<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use JWTAuth;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $users = $this->model->orderBy('id', 'desc')->paginate(9);
        return $users;
    }

    public function show($name)
    {
        $users = $this->model->where('name', 'like', '%'. $name .'%')->paginate(9);
        return $users;
    } 

    public function update(array $attributes, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user['id'] == $id){
            $this->model->where('id', $id)->update([ 'name' => $attributes['name'], 
                                                     'password' => bcrypt($attributes['password'])
                                                     ]);
            $message = ['message' => 'Dados atualizado.'];
            $cod = 201;
        } else {
            $message = ['message' => 'Sem autorização para atualizar os dados.'];
            $cod = 422;
        }
        throw new HttpResponseException(response()->json($message, $cod)); 
    }

    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user['id'] != 1 || $id == 1){
            $message = ['message' => 'Sem autorização para excluir usuário.'];
            $cod = 422;
        } else {
            $this->model->destroy($id);
            $message = ['message' => 'Usuário excluído.'];
            $cod = 201;
        }
        throw new HttpResponseException(response()->json($message, $cod)); 
    }
}