<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allEntries = Finance::entries()->where('user_id', Auth::user()->id)->sum('value_transaction');
        $allExpenses = Finance::expenses()->where('user_id', Auth::user()->id)->sum('value_transaction');
        $allFinances = Finance::where('user_id', Auth::user()->id)->paginate(20);

        $total = $allEntries - $allExpenses;

        $entries = Finance::entries()->where('user_id', Auth::user()->id)->get();
        $expenses = Finance::expenses()->where('user_id', Auth::user()->id)->get();



        return view('finance.index', compact('allEntries', 'allExpenses', 'total', 'entries', 'expenses', 'allFinances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('user_id', Auth::user()->id)->get();

        return view('finance.create', ['types' => $types])->with('success', 'Movimentação cadastrada com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'transaction_type' => 'required',
            'type_id' => 'required',
            'value_transaction' => 'required|numeric',
            'description' => 'required',
            'short_description' => 'nullable',
        ]);

        Finance::create([
            'user_id' => $request->user_id,
            'transaction_type' => $request->transaction_type,
            'type_id' => $request->type_id,
            'value_transaction' => $request->value_transaction,
            'description' => $request->description,
            'short_description' => $request->short_description ?? '',
        ]);

        return redirect()->route('finance.index')->with('success', 'Registro salvo com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Finance $finance)
    {
        $types = Type::where('user_id', Auth::user()->id)->get();

        return view('finance.show', [
            'finance' => $finance,
            'types' => $types
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Finance $finance)
    {
        $finance->update($request->all());

        return redirect()->route('finance.index')->with('success', 'Movimentação atualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
