<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $users = $this->model->orderBy('id', 'desc')->paginate(10);
        return $users;
    }

    public function destroy($id)
    {
        $this->model->destroy($id);
        return response('Usuário excluído', 200);
    }
}