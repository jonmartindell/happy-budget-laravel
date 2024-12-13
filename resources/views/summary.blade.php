<x-app-layout>
    <p id="notice">{{ session('notice') }}</p>

    <h1>Income</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Heading</th>
                <th>Budget</th>
                <th>Actual</th>
                <th>Difference</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categories->where('expense', false)->sortBy(['heading', 'name']) as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->heading }}</td>
                <td>{{ '$' . number_format($category->budget * 12, 0, '.', ',') }}</td>
                <td>{{ '$' . number_format($category->spentToEom('December'), 0, '.', ',') }}</td>
                <td>{{ '$' . number_format($category->spentToEom('December') - ($category->budget * 12), 0, '.', ',') }}</td>
            </tr>
            @endforeach
            <tr>
                <td><b>Total Income</b></td>
                <td></td>
                <td><b>{{ '$' . number_format($categories->where('expense', false)->sum('budget') * 12, 0, '.', ',') }}</b></td>
                <td><b>{{ '$' . number_format($categories->where('expense', false)->sum(function($category) { 
            return $category->transactions->sum('amount');
        }), 0, '.', ',') }}</b></td>
                <td><b>{{ '$' . number_format($categories->where('expense', false)->sum(function($category) { 
            return $category->transactions->sum('amount');
        }) - ($categories->where('expense', false)->sum('budget') * 12), 0, '.', ',') }}</b></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h1>Expenses</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Heading</th>
                <th>Budget</th>
                <th>Transfers</th>
                <th>Actual</th>
                <th>Difference</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categories->where('expense', true)->sortBy(['heading', 'name']) as $category)
            <tr class="text-{{ $category->status('December') }}">
                <td>{{ $category->name }}</td>
                <td>{{ $category->heading }}</td>
                <td>{{ '$' . number_format($category->budget * 12, 0, '.', ',') }}</td>
                <td>{{ '$' . number_format(App\Models\Transaction::transfers()->where('category_id', $category->id)->sum('amount'), 0, '.', ',') }}</td>
                <td>{{ '$' . number_format(App\Models\Transaction::nonTransfers()->where('category_id', $category->id)->sum('amount'), 0, '.', ',') }}</td>
                <td>{{ '$' . number_format(($category->budget * 12) - $category->transactions->sum('amount'), 0, '.', ',') }}</td>
            </tr>
            @endforeach
            <tr>
                <td><b>Total Expenses</b></td>
                <td></td>
                <td><b>{{ '$' . number_format($categories->where('expense', true)->sum('budget') * 12, 0, '.', ',') }}</b></td>
                <td><b>{{ '$' . number_format($categories->where('expense', true)->sum(function($category) { 
            return App\Models\Transaction::transfers()->where('category_id', $category->id)->sum('amount');
        }), 0, '.', ',') }}</b></td>
                <td><b>{{ '$' . number_format($categories->where('expense', true)->sum(function($category) { 
            return App\Models\Transaction::nonTransfers()->where('category_id', $category->id)->sum('amount');
        }), 0, '.', ',') }}</b></td>
                <td><b>{{ '$' . number_format(($categories->where('expense', true)->sum('budget') * 12) - $categories->where('expense', true)->sum(function($category) { 
            return $category->transactions->sum('amount');
        }), 0, '.', ',') }}</b></td>
            </tr>
        </tbody>
    </table>
</x-app-layout>
