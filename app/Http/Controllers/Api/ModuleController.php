<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = $this->module
        ->orderBy('name')
        ->get();

        return response()->json($modules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->module->rules(), $this->module->feedback());

        $module = $this->module->create($request->all());
        return response()->json($module, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($module = $this->module->find($id))) {
            return response()->json(['errors' => ['O módulo informada não existe!']], 404);
        }

        return response()->json($module, 200);
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
        if (empty($module = $this->module->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a atualização, porque o módulo informado não existe!']], 404);
        }

        $rules = [];
        if ($request->method() === 'PATCH') {
            foreach ($module->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $regra;
                }
            }
        } else {
            $rules = $module->rules();
        }

        $request->validate($rules, $module->feedback());
        $module->update($request->all());

        return response()->json($module, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($module = $this->module->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a exclusão, porque o módulo informado não existe!']], 404);
        }

        $module->delete();
        return response()->json(['message' => ['Módulo removido com sucesso!']], 200);
    }
}
