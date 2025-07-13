<?php

namespace App\Repositories;

use App\Models\KpiItem;
use App\Interfaces\KpiItemInterface;

class KpiItemRepository implements KpiItemInterface
{    private $model = KpiItem::class;

    public function update(array $data, $id)
    {
        $this->model::find($id)
                    ->update($data);

        return $this->model::find($id);
    }

    public function getById($id)
    {
        return cache()->tags(['kpiItem'])
            ->remember('kpiItem:'.$id, config('cache.default_duration'), function () use ($id){
                return $this->model::find($id);
        });
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function searchPaginate(array $filters)
    {
        return cache()->tags(['kpiList'])
            ->remember('kpiList:'.json_encode($filters), config('cache.default_duration'), function () use ($filters){
                return $this->searchPaginateQuery($filters)
                            ->paginate($filters['per_page'] ?? 10);
        });
    }

    public function searchPaginateQuery(array $filters)
    {
        return $this->model::with(['type'])
                ->when(!empty($filters['type_id']), function ($query) use($filters) {
                    return $query->where('kpi_type_id', $filters['type_id']);
                })
                ->when(!empty($filters['titulo']), function ($query) use($filters) {
                    return $query->where('titulo', 'LIKE' ,'%'.$filters['titulo'].'%');
                })
                ->orderBy($filters['order_by'] ?? 'id', $filters['order_by_order'] ?? 'DESC');
    }

}
