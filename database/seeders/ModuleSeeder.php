<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                'name' => 'Usuários',
                'controller' => 'user'
            ],
            [
                'name' => 'Ações',
                'controller' => 'action'
            ],
            [
                'name' => 'Funções',
                'controller' => 'role'
            ],
            [
                'name' => 'Módulos',
                'controller' => 'module'
            ],
            [
                'name' => 'Permissões',
                'controller' => 'permission'
            ]
        ];

        foreach($modules as $module){
            $moduleObject = new Module();
            $moduleObject->name = $module['name'];
            $moduleObject->controller = $module['controller'];
            $moduleObject->save();
        }
    }
}
