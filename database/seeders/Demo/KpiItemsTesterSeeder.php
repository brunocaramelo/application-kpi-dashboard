<?php

namespace Database\Seeders\Demo;

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
            [
                'id' => 3,
                'titulo' => 'Visitantes únicos no site',
                'valor' => '8450.25',
                'variacao_percentual' => '8.75',
                'kpi_type_id' => 3,
            ],
            [
                'id' => 4,
                'titulo' => 'Porcentagem de visitantes que saíram sem interação',
                'valor' => '32.60',
                'variacao_percentual' => '-2.40',
                'kpi_type_id' => 3,
            ],
            [
                'id' => 5,
                'titulo' => 'Tempo médio para completar um processo',
                'valor' => '4.75',
                'variacao_percentual' => '-1.25',
                'kpi_type_id' => 4,
            ],
            [
                'id' => 6,
                'titulo' => 'Taxa de rotatividade de funcionários',
                'valor' => '15.30',
                'variacao_percentual' => '3.20',
                'kpi_type_id' => 5,
            ],
            [
                'id' => 7,
                'titulo' => 'Índice de promotores líquidos',
                'valor' => '42.50',
                'variacao_percentual' => '5.75',
                'kpi_type_id' => 6,
            ],
            [
                'id' => 8,
                'titulo' => 'Receita total do mês atual',
                'valor' => '58750.00',
                'variacao_percentual' => '18.90',
                'kpi_type_id' => 1,
            ],
            [
                'id' => 9,
                'titulo' => 'Custo para adquirir um novo cliente',
                'valor' => '125.75',
                'variacao_percentual' => '-8.25',
                'kpi_type_id' => 1,
            ],
            [
                'id' => 10,
                'titulo' => 'Porcentagem de conversão de leads',
                'valor' => '7.80',
                'variacao_percentual' => '1.30',
                'kpi_type_id' => 2,
            ],
            [
                'id' => 11,
                'titulo' => 'Valor médio por transação',
                'valor' => '85.90',
                'variacao_percentual' => '3.45',
                'kpi_type_id' => 2,
            ],
            [
                'id' => 12,
                'titulo' => 'Taxa de cancelamento de assinaturas',
                'valor' => '5.25',
                'variacao_percentual' => '-1.75',
                'kpi_type_id' => 2,
            ],
            [
                'id' => 13,
                'titulo' => 'Taxa de cliques em campanhas',
                'valor' => '2.45',
                'variacao_percentual' => '0.35',
                'kpi_type_id' => 3,
            ],
            [
                'id' => 14,
                'titulo' => 'Leads qualificados gerados',
                'valor' => '125.00',
                'variacao_percentual' => '25.50',
                'kpi_type_id' => 3,
            ],
            [
                'id' => 15,
                'titulo' => 'Porcentagem de produtos defeituosos',
                'valor' => '1.75',
                'variacao_percentual' => '-0.25',
                'kpi_type_id' => 4,
            ],
            [
                'id' => 16,
                'titulo' => 'Eficiência geral dos equipamentos',
                'valor' => '78.50',
                'variacao_percentual' => '3.75',
                'kpi_type_id' => 4,
            ],
            [
                'id' => 17,
                'titulo' => 'Nível de satisfação dos colaboradores',
                'valor' => '82.75',
                'variacao_percentual' => '4.25',
                'kpi_type_id' => 5,
            ],
            [
                'id' => 18,
                'titulo' => 'Taxa de ausência não programada',
                'valor' => '3.20',
                'variacao_percentual' => '-0.80',
                'kpi_type_id' => 5,
            ],
            [
                'id' => 19,
                'titulo' => 'Satisfação geral dos clientes',
                'valor' => '88.90',
                'variacao_percentual' => '2.10',
                'kpi_type_id' => 6,
            ],
            [
                'id' => 20,
                'titulo' => 'Tempo médio de resposta a chamados',
                'valor' => '2.25',
                'variacao_percentual' => '-0.75',
                'kpi_type_id' => 6,
            ],
            [
                'id' => 21,
                'titulo' => 'Porcentagem de entregas no prazo',
                'valor' => '94.50',
                'variacao_percentual' => '1.25',
                'kpi_type_id' => 7,
            ],
            [
                'id' => 22,
                'titulo' => 'Precisão do inventário',
                'valor' => '98.75',
                'variacao_percentual' => '0.25',
                'kpi_type_id' => 7,
            ],
            [
                'id' => 23,
                'titulo' => 'Margem de lucro bruto',
                'valor' => '35.25',
                'variacao_percentual' => '2.75',
                'kpi_type_id' => 1,
            ],
            [
                'id' => 24,
                'titulo' => 'Retorno sobre investimento em marketing',
                'valor' => '320.50',
                'variacao_percentual' => '45.75',
                'kpi_type_id' => 1,
            ],
            [
                'id' => 25,
                'titulo' => 'Taxa de recompra de clientes',
                'valor' => '65.80',
                'variacao_percentual' => '8.40',
                'kpi_type_id' => 2,
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
