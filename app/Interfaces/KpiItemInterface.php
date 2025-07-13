<?php

namespace App\Interfaces;


interface KpiItemInterface
{
    public function searchPaginate(array $filters);
    public function getById($id);
    public function create(array $data);
    public function update(array $data, $id);
}
