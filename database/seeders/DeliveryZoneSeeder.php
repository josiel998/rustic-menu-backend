<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryZone; // 1. Importe o seu model

class DeliveryZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Define a estrutura de dados em PHP
        $zonas = [
            "Mario Campos" => [
                ["nome" => "Centro", "taxa" => 6.00],
                ["nome" => "Primavera", "taxa" => 6.00],
                ["nome" => "Campos Belo", "taxa" => 6.00],
                ["nome" => "Balneário", "taxa" => 12.00],
                ["nome" => "Rádium pra frente", "taxa" => 7.00],
                ["nome" => "Reta 2", "taxa" => 12.00],
                ["nome" => "Funil", "taxa" => 15.00],
                ["nome" => "Tangará", "taxa" => 4.00],
                ["nome" => "Lambaria", "taxa" => 6.00],
                ["nome" => "Bela vista", "taxa" => 4.00],
                ["nome" => "Campo verde", "taxa" => 6.00]
            ],
            "Sarzedo" => [
                ["nome" => "Vera Cruz", "taxa" => 6.00],
                ["nome" => "Santa Mônica", "taxa" => 7.00],
                ["nome" => "Planalto", "taxa" => 6.00],
                ["nome" => "Liberdade 2", "taxa" => 7.00],
                ["nome" => "Liberdade 1", "taxa" => 7.00],
                ["nome" => "Bairro Brasília - Início", "taxa" => 10.00],
                ["nome" => "Bairro Brasília - Centro", "taxa" => 12.00],
                ["nome" => "Bairro Brasília - Antenas", "taxa" => 15.00],
                ["nome" => "Serra Azul - Início", "taxa" => 7.00]
            ]
        ];

        // 3. Itera e cria os registros no banco
        foreach ($zonas as $cidade => $bairros) {
            foreach ($bairros as $bairro) {
                // Usamos updateOrCreate para evitar duplicatas se você rodar o seeder de novo
                DeliveryZone::updateOrCreate(
                    [
                        'cidade' => $cidade,
                        'bairro' => $bairro['nome']
                    ],
                    [
                        'taxa' => $bairro['taxa']
                    ]
                );
            }
        }
    }
}