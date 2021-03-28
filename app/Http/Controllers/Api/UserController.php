<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->user->rules(), $this->user->feedback());
        
        $userRequest = $request->all();
        $userRequest['password'] = bcrypt($userRequest['password']);

        $user = $this->user->create($userRequest['password']);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (empty($user = $this->user->find($id))) {
            return response()->json(['errors' => ['O usuário informado não existe!']], 404);
        }

        return response()->json($user, 200);
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
        if (empty($user = $this->user->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a atualização, porque o usuário informado não existe!']], 404);
        }

        $rules = [];
        if ($request->method() === 'PATCH') {
            foreach ($user->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $rules[$input] = $regra;
                }
            }
        } else {
            $rules = $user->rules();
        }

        $request->validate($rules, $user->feedback());
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($user = $this->user->find($id))) {
            return response()->json(['errors' => ['Não foi possível realizar a exclusão, porque o usuário informado não existe!']], 404);
        }

        $user->delete();
        return response()->json(['message' => ['Usuário removido com sucesso!']], 200);
    }
}
