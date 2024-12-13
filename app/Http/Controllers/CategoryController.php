<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class CategoryController extends Controller
{
    public function summary(): View
    {
        return view('summary', [
            'categories' => Category::all(),
            'transactions' => Transaction::all()
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('categories.index', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'infrequent' => $request->input('infrequent', false),
            'expense' => $request->input('expense', false)
        ]);

        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'budget' => 'required',
            'sort' => 'required',
            'infrequent' => 'required',
            'expense' => 'required'
        ]);

        Category::create($validated);

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->merge([
            'infrequent' => $request->input('infrequent', false),
            'expense' => $request->input('expense', false)
        ]);

        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'budget' => 'required',
            'sort' => 'required',
            'infrequent' => 'required',
            'expense' => 'required'
        ]);

        $category->update($validated);

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        //
        $category->delete();
        return redirect(route('categories.index'));
    }
}
