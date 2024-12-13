<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('transactions.index', [
            'transactions' => Transaction::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $category = Category::find($request->input('category'));
        $transaction = new Transaction;
        $transaction->category = $category;

        return view('transactions.create', [
            'category' => $category,
            'transaction' => $transaction,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'transfer' => $request->input('transfer', false)
        ]);

        $validated = $request->validate([
            'category_id' => 'required',
            'merchant' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'transfer' => 'required'
        ]);

        $request->user()->transactions()->create($validated);

        return redirect(route('dashboard.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): View
    {
        return view('transactions.edit', [
            'category' => $transaction->category,
            'transaction' => $transaction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $request->merge([
            'transfer' => $request->input('transfer', false)
        ]);

        $validated = $request->validate([
            'category_id' => 'required',
            'merchant' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'transfer' => 'required'
        ]);

        $transaction->update($validated);

        return redirect(route('dashboard.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();
        return redirect(route('dashboard.index'));
    }
}
