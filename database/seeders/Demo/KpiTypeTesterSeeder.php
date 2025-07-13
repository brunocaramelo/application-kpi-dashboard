<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\KpiType;

class KpiTypeTesterSeeder extends Seeder
{

    public function run()
    {
        $listItems = [
            [
                'id' => 1,
                'code' => 'vendas-do-dia',
                'name' => 'Vendas do Dia',
            ],
            [
                'id' => 2,
                'code' => 'ltv',
                'name' => 'LTV',
            ],
            [
                'id' => 3,
                'code' => 'trafego-site',
                'name' => 'Tráfego do Site',
            ],
            [
                'id' => 4,
                'code' => 'taxa-de-rejeicao',
                'name' => 'Taxa de Rejeição',
            ],
            [
                'id' => 5,
                'code' => 'tempo-de-ciclo',
                'name' => 'Tempo de Ciclo',
            ],
            [
                'id' => 6,
                'code' => 'turnover',
                'name' => 'Turnover',
            ],
            [
                'id' => 7,
                'code' => 'nps',
                'name' => 'NPS',
            ],
        ];

        foreach($listItems as $item) {

            if (KpiType::where('id', $item['id'])->exists()) {
                continue;
            }

            KpiType::create($item);
        }

    }
}
