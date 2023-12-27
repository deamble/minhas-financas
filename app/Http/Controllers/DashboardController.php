<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $allEntries = Finance::entries()->where('user_id', $user_id)->sum('value_transaction');
        $allExpenses = Finance::expenses()->where('user_id', $user_id)->sum('value_transaction');
        $total = $allEntries - $allExpenses;

        $entries = Finance::entries()->where('user_id', $user_id)->get();
        $expenses = Finance::expenses()->where('user_id', $user_id)->get();

        $allFinances = Finance::where('user_id', $user_id)->get();

        // Quantidade mensal
        $entriesPerMonth = $this->entriesPerMonthly($user_id);
        $expensesPerMonth = $this->expensesPerMonthly($user_id);
        $balancePerMonthly = $this->balancePerMonthly($user_id);

        // Valor mensal
        $totalValuesEntries = $this->totalEntriesSum($user_id);
        $totalValuesExpenses = $this->totalExpensesSum($user_id);
        $totalBalancePerMonthly = $this->valueBalancePerMonthly($user_id);

        // Transações por tipo
        $transactionsByType = $this->transactionsByType($user_id);

        return view('dashboard.index', compact(
            'allEntries',
            'allExpenses',
            'total',
            'entriesPerMonth',
            'expensesPerMonth',
            'totalValuesEntries',
            'totalValuesExpenses',
            'totalBalancePerMonthly',
            'entries',
            'expenses',
            'allFinances',
            'balancePerMonthly',
            'transactionsByType'
        ));
    }

    /**
     * Return entries per monthly (qty)
     */
    private function entriesPerMonthly()
    {
        $user_id = Auth::user()->id;

        $entriesPerMonth = Finance::entries()
            ->where('user_id', $user_id)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as entry_count')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return $entriesPerMonth;
    }

    /**
     * Return the total sum of all entries
     */
    private function totalEntriesSum()
    {
        $user_id = Auth::user()->id;

        $totalSum = Finance::entries()
            ->where('user_id', $user_id)
            ->sum('value_transaction');

        return $totalSum;
    }

    /**
     * Return expenses per monthly (qty)
     */
    private function expensesPerMonthly()
    {
        $user_id = Auth::user()->id;

        $expensesPerMonth = Finance::expenses()
            ->where('user_id', $user_id)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as expenses_count')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return $expensesPerMonth;
    }

    /**
     * Return the total sum of all expenses
     */
    private function totalExpensesSum()
    {
        $user_id = Auth::user()->id;

        $totalSum = Finance::expenses()
            ->where('user_id', $user_id)
            ->sum('value_transaction');

        return $totalSum;
    }

    /**
     * Return balance per monthly (qty)
     */
    private function balancePerMonthly()
    {
        $user_id = Auth::user()->id;

        $balancePerMonth = Finance::selectRaw('MONTH(created_at) as month, COUNT(*) as balance_count')
            ->where('user_id', $user_id)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return $balancePerMonth;
    }

    /**
     * Return the total sum of balance (entries - expenses)
     */
    private function valueBalancePerMonthly()
    {
        $user_id = Auth::user()->id;

        $totalEntriesSum = Finance::entries()
            ->where('user_id', $user_id)
            ->sum('value_transaction');
        $totalExpensesSum = Finance::expenses()
            ->where('user_id', $user_id)
            ->sum('value_transaction');

        $totalBalance = $totalEntriesSum - $totalExpensesSum;

        return $totalBalance;
    }

    /**
     * Display a listing of all transactions by type.
     */
    private function transactionsByType()
    {
        $types = Type::all()->where('user_id', Auth::user()->id);

        $transactionsByType = [];

        foreach ($types as $type) {
            $transactions = Finance::where('type_id', $type->id)->get();
            $transactionsByType[$type->name] = $transactions;
        }

        return $transactionsByType;
    }
}
