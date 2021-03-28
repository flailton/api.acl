<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Action;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            [
                'name' => 'Listar',
                'method' => 'index'
            ],
            [
                'name' => 'Adicionar',
                'method' => 'store'
            ],
            [
                'name' => 'Atualizar',
                'method' => 'update'
            ],
            [
                'name' => 'Visualizar',
                'method' => 'show'
            ],
            [
                'name' => 'Excluir',
                'method' => 'destroy'
            ],
            [
                'name' => 'Todas',
                'method' => 'all'
            ]
        ];

        foreach($actions as $action){
            $actionObject = new Action();
            $actionObject->name = $action['name'];
            $actionObject->method = $action['method'];
            $actionObject->save();
        }
    }
}
