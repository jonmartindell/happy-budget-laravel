<x-app-layout>
    <p id="notice">{{ session('notice') }}</p>

    <h1>Listing Transactions</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Month</th>
                <th>Who</th>
                <th>Category</th>
                <th>Merchant</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Tfer</th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('F') }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->category->name }}</td>
                <td>{{ $transaction->merchant }}</td>
                <td>{{ number_format($transaction->amount, 2) }}</td>
                <td>{{ $transaction->date }}</td>
                <td>{{ $transaction->transfer ? '⇆' : '' }}</td>
                <td>
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning">Edit</a>
                </td>
                <td>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Destroy</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
