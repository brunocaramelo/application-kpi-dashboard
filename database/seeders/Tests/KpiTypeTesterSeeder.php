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
                'id' => 1,
                'code' => 'vendas-do-dia',
                'name' => 'Vendas do Dia',
            ],
            [
                'id' => 2,
                'code' => 'ltv',
                'name' => 'LTV',
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
