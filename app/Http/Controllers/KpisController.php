<?php

namespace App\Http\Controllers;

use App\Services\KpiService;

use App\Http\Requests\{KpiItemCreateRequest,
                       KpiItemUpdateRequest};

use Illuminate\Http\Request;

class KpisController extends Controller
{
    private $service;
    public function __construct(KpiService $service)
    {
        $this->service = $service;
    }

    public function search(Request $request)
    {
        return $this->service->searchPaginate($request->all());
    }

    public function create(KpiItemCreateRequest $request)
    {
        return $this->service->create($request->all());
    }

    public function update($id, KpiItemUpdateRequest $request)
    {
        return $this->service->update($id, $request->all());
    }
    public function getItem($id)
    {
        return $this->service->getItem( $id);
    }

    public function getTypes()
    {
        return \App\Models\KpiType::all();
    }

}
