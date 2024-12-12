<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;




class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Fetch the 'month' parameter from the request, or use the default month
        $month = $request->input('month', $this->defaultMonth());

        // Get the prior and next month
        list($prior_month, $next_month) = $this->monthsFor($month);

        // Group categories by 'heading' based on whether it's an expense or income
        $expenses = Category::where('expense', true)->get()->groupBy('heading');
        $incomes = Category::where('expense', false)->get()->groupBy('heading');

        // Return the data to a view (assuming you have 'welcome.index' view)
        return view('dashboard', compact('month', 'prior_month', 'next_month', 'expenses', 'incomes'));
    }

    private function defaultMonth()
    {
        // Get the current month's name (in full, e.g., 'January')
        return Carbon::now()->format('F');
    }

    private function monthsFor($month)
    {
        // Use Carbon to find the current month index
        $currentIndex = Carbon::parse($month)->month;

        // Determine the previous and next months
        $priorMonth = Carbon::create()->month($currentIndex)->subMonth()->format('F');
        $nextMonth = Carbon::create()->month($currentIndex)->addMonth()->format('F');

        return [$priorMonth, $nextMonth];
    }
}
