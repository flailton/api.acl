<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Action;

class Module extends Model
{
    use HasFactory;

    /**
     * The module actions that belong to the modules.
     */
    public function actions()
    {
        return $this->belongsToMany(Action::class);
    }

    public function rules()
    {
        return [
            'name' => 'required|min:1|max:50',
            'controller' => 'required|min:1|max:25'
        ];
    }

    public function feedback()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 1 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 50 caracteres!',

            'controller.required' => 'O campo controlador é obrigatório!',
            'controller.min' => 'O controlador deve ter, pelo menos, 1 caracteres!',
            'controller.max' => 'O controlador deve ter, no máximo, 25 caracteres!'
        ];
    }
}
