<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:level');
    }


    public function index()
    {
        return view('users.index',[
            'users' => DB::table('users')->orderBy('name')->paginate('20')
        ]);
    }

    public function edit($id)
    {
        return view('users.edit', [
            'user' => User::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(
            [
                'level' => $request->input('level'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]
        );

        return redirect()->route('user.index');
    }


}
