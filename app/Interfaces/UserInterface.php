<?php

namespace App\Interfaces;


interface UserInterface
{
    public function findByEmail(string $mail);
    public function update(array $data, $id);
    public function create(array $data);
}
