<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $users = $this->model->where('name', 'like', $name .'%')->get();
        return $users;
    }

    public function destroy($id)
    {
        if ($id == 1){
            $message = [
                'message' => 'Usuário não pode ser excluído.'
            ];
        } else {
            $this->model->destroy($id);
            $message = [
                'message' => 'Usuário excluído.'
            ];
        }
        throw new HttpResponseException(response()->json($message, 201)); 
    }
}