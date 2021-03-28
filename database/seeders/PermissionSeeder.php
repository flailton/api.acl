<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Module;
use App\Models\Action;
use App\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = (new Action)->all();
        $modules = (new Module)->all();
        $roleAdmin = (new Role)->where('name', 'Administrador')->first();
        $roleUser = (new Role)->where('name', 'Usuário')->first();

        foreach($actions as $action){
            foreach($modules as $module){
                $permission = new Permission();
                $permission->module_id = $module->id;
                $permission->action_id = $action->id;
                $permission->save();

                $roleAdmin->permissions()->attach($permission->id);
                if($module->controller === 'users' && !in_array($action->method, ['all', 'destroy'])){
                    $roleUser->permissions()->attach($permission->id);
                }
            }
        }
        $userAdmin = (new User)->where('email', 'admin@admin.com')->first();
        $userAdmin->roles()->attach($roleAdmin->id);

        $userUser = (new User)->where('email', 'user@user.com')->first();
        $userUser->roles()->attach($roleUser->id);
    }
}
