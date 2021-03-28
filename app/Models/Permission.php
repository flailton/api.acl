<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The modules that belong to the permissions.
     */
    public function module()
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }

    /**
     * The actions that belong to the permissions.
     */
    public function action()
    {
        return $this->hasOne(Action::class, 'id', 'action_id');
    }

    public function hasModuleAction($controller, $method)
    {
        if ($this->module->controller === $controller &&  in_array($this->action->method, [$method, 'all'])) {
            return [
                'controller' => $this->module->controller,
                'method' => $this->action->method
            ];
        }

        return false;
    }
}
