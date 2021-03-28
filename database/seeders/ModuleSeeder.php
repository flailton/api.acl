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
                'controller' => 'users'
            ],
            [
                'name' => 'Ações',
                'controller' => 'actions'
            ],
            [
                'name' => 'Funções',
                'controller' => 'roles'
            ],
            [
                'name' => 'Módulos',
                'controller' => 'modules'
            ],
            [
                'name' => 'Permissões',
                'controller' => 'permissions'
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
