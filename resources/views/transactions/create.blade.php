<x-app-layout>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        @if ($errors->any())
        <div id="error_explanation">
            <h2>{{ $errors->count() }} error{{ $errors->count() > 1 ? 's' : '' }} prohibited this transaction from being saved:</h2>
            <ul>
                @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <h3>{{$category->name}} Transaction</h3>

        <input type="hidden" name="category_id" value="{{ $transaction->category->id }}">

        <div class="row form-group">
            <div class="form-group form-inline col-xs-12">
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $transaction->date ?? now('America/New_York')->format('Y-m-d')) }}" required>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="form-group col-xs-12">
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <input type="number" name="amount" class="form-control" placeholder="Amount" step="0.01" value="{{ old('amount', $transaction->amount ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="form-group col-xs-12">
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-question-sign"></i></div>
                    <input type="text" name="merchant" class="form-control" placeholder="Where? What?" value="{{ old('merchant', $transaction->merchant ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="form-group col-xs-12">
                <div class="checkbox-inline">
                    <input type="checkbox" name="transfer" class="form-check-input" {{ old('transfer', $transaction->transfer ?? false) ? 'checked' : '' }}>
                    <label for="transfer">Transfer</label>
                </div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5">
                <a href="{{ route('dashboard.index') }}" class="btn btn-danger btn-block">
                    <i class="glyphicon glyphicon-remove"></i>
                </a>
            </div>
            <div class="col-xs-2"></div>
            <div class="col-xs-5">
                <button type="submit" class="btn btn-success glyphicon glyphicon-ok btn-block"></button>
            </div>
        </div>
    </form>

</x-app-layout>
