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
                'code' => 'vendas-do-dia',
                'name' => 'Vendas do Dia',
            ],
            [
                'code' => 'ltv',
                'name' => 'LTV',
            ],
            [
                'code' => 'trafego-site',
                'name' => 'Tráfego do Site',
            ],
            [
                'code' => 'taxa-de-rejeicao',
                'name' => 'Taxa de Rejeição',
            ],
            [
                'code' => 'tempo-de-ciclo',
                'name' => 'Tempo de Ciclo',
            ],
            [
                'code' => 'turnover',
                'name' => 'Turnover',
            ],
            [
                'code' => 'nps',
                'name' => 'NPS',
            ],
        ];

        foreach($listItems as $item) {

            if (KpiType::where('code', $item['code'])->exists()) {
                continue;
            }

            KpiType::create($item);
        }

    }
}
