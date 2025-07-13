<?php

namespace App\Services;

use App\Interfaces\KpiItemInterface;

class KpiService
{
    private $kpiRepository;

    public function __construct(KpiItemInterface $kpiRepository)
    {
        $this->kpiRepository = $kpiRepository;
    }

    public function searchPaginate(array $data)
    {
        return $this->kpiRepository->searchPaginate($data);
    }

    public function getItem($id)
    {
        return $this->kpiRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->kpiRepository->create($data);
    }
    public function update($id, array $data)
    {
        return $this->kpiRepository->update($data, $id);
    }



}
