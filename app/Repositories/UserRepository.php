<?php

namespace App\Repositories;

use App\Models\{User, Person};
use App\Interfaces\UserInterface;

class UserRepository implements UserInterface
{    private $model = User::class;

    public function update(array $data, $id)
    {
        return $this->model::find($id)->update($data);
    }

    public function create(array $data)
    {
        return $this->model::create($data);

    }
    public function findByEmail(string $email)
    {
        return $this->model::where('email', $email)
                ->get();
    }
}
