<?php

namespace Tests\Feature\Http\Controllers;

use App\Services\KpiService;
use App\Repositories\KpiItemRepository;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'DatabaseTestSuiteSeeder']);
});

describe('KpiService', function () {

    test('searchPaginate with results', function () {
        $service = new KpiService(new KpiItemRepository());
        $response = $service->searchPaginate(['per_page' => 10])
                            ->toArray();

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['data', 'total', 'per_page']);
    });

    test('getItem with results', function () {

        $service = new KpiService(new KpiItemRepository());
        $response = $service->getItem(1)
                            ->toArray();

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['titulo', 'valor']);
    });

    test('update with success', function () {

        $service = new KpiService(new KpiItemRepository());
        $response = $service->update(1, [
                    'titulo' => 'kpi com sucesso mudei',
                    'valor' => 12.30,
                    'variacao_percentual' => 11.03
                ])->toArray();

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['titulo', 'valor']);
    });

    test('create with success', function () {

        $service = new KpiService(new KpiItemRepository());
        $response = $service->create( [
                    'titulo' => 'kpi com sucesso mudei',
                    'valor' => 12.30,
                    'kpi_type_id' => 1,
                    'variacao_percentual' => 11.03
                ])->toArray();

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['titulo', 'valor']);
    });


});
