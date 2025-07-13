<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'DatabaseTestSuiteSeeder']);
});

describe('KpisController', function () {

    test('search with filters and results', function () {


        $response = $this->getJson('/api/kpis', [])
                 ->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'total',
                 ]);

                $total = $response->json('total');

                $this->assertIsInt($total);
                $this->assertGreaterThan(0, $total);
    });

    test('search with filters and no results', function () {
        $response = $this->getJson('/api/kpis?type_id=999')
                 ->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'total',
                 ]);

                $total = $response->json('total');

                $this->assertIsInt($total);
                $this->assertEquals(0, $total);
    });

    test('create KPI with fails validation', function () {
        $response = $this->postJson('/api/kpis', [
                    'name' => 'ok'
                ])
                ->assertStatus(422)
                 ->assertJsonStructure([
                     'message',
                     'errors',
                 ]);
    });

    test('create KPI with success', function () {
        $response = $this->postJson('/api/kpis', [
                    'kpi_type_id' => 2,
                    'titulo' => 'kpi com sucesso',
                    'valor' => 22.10,
                    'variacao_percentual' => 12.01,
                ])
                ->assertStatus(201)
                 ->assertJsonStructure([
                     'id',
                     'valor',
                 ]);
    });

    test('update KPI with fails validation', function () {
        $response = $this->putJson('/api/kpis/1', [
                    'name' => 'ok'
                ])
                ->assertStatus(422)
                 ->assertJsonStructure([
                     'message',
                     'errors',
                 ]);
    });

    test('update KPI with success', function () {
        $response = $this->putJson('/api/kpis/1', [
                    'titulo' => 'kpi com sucesso mudei',
                    'valor' => 12.30,
                    'variacao_percentual' => 11.03,
                ])
                ->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'valor',
                 ]);
    });

    test('get KPI with success', function () {
        $response = $this->getJson('/api/kpis/1')
                ->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'valor',
                 ]);
    });

    test('get KPI Types with success', function () {
        $response = $this->getJson('/api/kpis/types')
                ->assertStatus(200)
                 ->assertJsonStructure([
                        '*' => [
                            'code',
                            'name',
                        ],
                    ]);
    });


});
