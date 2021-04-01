<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    /**
     * Get the module actions for the role.
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'role_module_action', 'role_id', 'module_id');
    }

    public function rules()
    {
        return [
            'name' => 'required|min:1|max:50'
        ];
    }

    public function feedback()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 1 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 50 caracteres!'
        ];
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission($controller, $method)
    {
        $permissions = $this->permissions;
        $return = false;
        foreach($permissions as $permission){
            if(!empty($authorization = $permission->hasModuleAction($controller, $method))){
                if(empty($return) || $authorization['method'] === 'all'){
                    $return = $authorization;
                }
            }
        }
        return $return;
    }
}
