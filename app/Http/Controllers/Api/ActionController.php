<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Action;

class ActionController extends Controller
{
    public function __construct(Action $action)
    {
        $this->action = $action;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = $this->action->all();

        return response()->json($actions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->action->rules(), $this->action->feedback());

        $action = $this->action->create($request->all());
        return response()->json($action, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($action = $this->action->find($id))) {
            return response()->json(['errors' => ['A ação informada não existe!']], 404);
        }

        return response()->json($action, 200);
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
        if (empty($action = $this->action->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a atualização, porque a ação informada não existe!']], 404);
        }

        $rules = [];
        if ($request->method() === 'PATCH') {
            foreach ($action->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $regra;
                }
            }
        } else {
            $rules = $action->rules();
        }

        $request->validate($rules, $action->feedback());
        $action->update($request->all());

        return response()->json($action, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($action = $this->action->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a exclusão, porque a ação informada não existe!']], 404);
        }

        $action->delete();
        return response()->json(['message' => ['Ação removida com sucesso!']], 200);
    }
}
