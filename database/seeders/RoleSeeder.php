<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrador'
            ],
            [
                'name' => 'Usuário'
            ]
        ];

        foreach($roles as $module){
            $roleObject = new Role();
            $roleObject->name = $module['name'];
            $roleObject->save();
        }
    }
}
