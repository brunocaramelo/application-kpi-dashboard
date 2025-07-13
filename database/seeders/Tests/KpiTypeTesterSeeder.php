<?php

namespace Database\Seeders\Tests;

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
        ];

        foreach($listItems as $item) {

            if (KpiType::where('code', $item['code'])->exists()) {
                continue;
            }

            KpiType::create($item);
        }

    }
}
