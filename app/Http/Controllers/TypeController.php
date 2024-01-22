<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:level')->only('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('type.index',[
            'types' => Type::orderBy('name')->paginate('20')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types.create');
    }

    public function typesByUser(User $id)
    {
        $user = User::findOrFail($id->id);
        $types = $user->types()->paginate(20);

        return view('types.types_by_user', [
            'types' => $types
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingType = Type::where('name', Str::lower($request->name))
                    ->where('user_id', $request->user_id)
                    ->first();

        if ($existingType) {
            return redirect()->route('type.create')->with('error', 'Já existe uma categoria com nome: ' . $request->name);
        }

        $type = new Type();
        $type->user_id = $request->user_id;
        $type->name = Str::lower($request->name);
        $type->description = $request->description ?? '';

        $type->save();

        return redirect()->route('type.create')->with('success', 'Categoria cadastrada com sucesso!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('types.edit', [
            'type' => $type
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $type->update($request->all());

        return redirect()->route('type.byuser', Auth::user()->id)->with('success', 'Categoria atualizada com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        Type::findOrFail($type->id)->delete();
        return redirect()->route('type.byuser', Auth::user()->id)->with('delete', 'A categoria ' . $type->name . ' foi deleta com sucesso!');
    }

    /**
     * show alert for delete confirmation
     */
    public function deleteConfirm(Type $id)
    {
        return view('types.delete_confirm', ['id' => $id]);
    }
}
