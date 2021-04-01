<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->role
            ->orderBy('name')
            ->get();

        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->role->rules(), $this->role->feedback());

        $role = $this->role->create($request->all());
        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($role = $this->role->find($id))) {
            return response()->json(['errors' => ['A função informada não existe!']], 404);
        }

        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (empty($role = $this->role->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a atualização, porque a função informada não existe!']], 404);
        }

        $rules = [];
        if ($request->method() === 'PATCH') {
            foreach ($role->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $regra;
                }
            }
        } else {
            $rules = $role->rules();
        }

        $request->validate($rules, $role->feedback());
        $role->update($request->all());

        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($role = $this->role->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a exclusão, porque a função informada não existe!']], 404);
        }

        $role->delete();
        return response()->json(['message' => ['Função removida com sucesso!']], 200);
    }

    /**
     * Get permissions from role.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rolePermissions(Request $request)
    {   
        $id = $request->get('id');

        if (empty($role = $this->role->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a exclusão, porque a função informada não existe!']], 404);
        }

        $return = [];
        foreach($role->permissions as $permission){
            $return[$permission->module_id][$permission->action_id] = $permission->id;
        }

        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detach(Request $request)
    {   
        $id = $request->get('id');
        $permission_id = $request->get('permission_id');

        if (empty($role = $this->role->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a desvinculação, porque a função informada não existe!']], 404);
        }

        if($role->permissions()->detach($permission_id)){
            return response()->json(['message' => 'Permissão desvinculada com sucesso!'], 200);
        }

        return response()->json(['errors' => 'Falha ao desvincular a permissão!'], 400);

    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attach(Request $request)
    {   
        $id = $request->get('id');

        if (empty($role = $this->role->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a vinculação, porque a função informada não existe!']], 404);
        }

        $module_id = $request->get('module_id');
        $action_id = $request->get('action_id');
        $permission = Permission::where('module_id', $module_id)
            ->where('action_id', $action_id)
            ->first();
        
        if (empty($permission)) {
            return response()->json(['errors' => ['Não foi possível realizar a vinculação, porque a permissão informada não existe!']], 404);
        }

        $role->permissions()->attach($permission->id);

        return response()->json(['message' => 'Permissão vinculada com sucesso!'], 200);
    }
}
