<?php

namespace Database\Seeders\Tests;

use App\Models\KpiItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KpiItemsTesterSeeder extends Seeder
{

    public function run()
    {
        $listItems = [
            [
                'id' => 1,
                'titulo' => 'Total de vendas realizadas hoje',
                'valor' => '1250.75',
                'variacao_percentual' => '5.25',
                'kpi_type_id' => 2,
            ],
            [
                'id' => 2,
                'titulo' => 'Valor médio do tempo de vida do cliente',
                'valor' => '3250.50',
                'variacao_percentual' => '12.30',
                'kpi_type_id' => 1,
            ],
        ];

        foreach($listItems as $item) {

            if (KpiItem::where('id', $item['id'])->exists()) {
                continue;
            }

            KpiItem::create($item);
        }

    }
}
