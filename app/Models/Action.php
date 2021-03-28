<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public function rules()
    {
        return [
            'name' => 'required|min:1|max:50',
            'method' => 'required|min:1|max:25'
        ];
    }

    public function feedback()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 1 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 50 caracteres!',

            'method.required' => 'O campo método é obrigatório!',
            'method.min' => 'O método deve ter, pelo menos, 1 caracteres!',
            'method.max' => 'O método deve ter, no máximo, 25 caracteres!'
        ];
    }
}
