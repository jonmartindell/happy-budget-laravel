<x-app-layout>
    <style>
        .category-rows:nth-child(even) {
            background-color: #f1f1f1;
        }

        main {
            background-color: white;
        }
    </style>

    <p id="notice">{{ session('notice') }}</p>

    <div class="container-fluid">
        <div class="row">
            <h3 class="col-xs-12 text-center">
                @php
                $prior_month = \Carbon\Carbon::parse($prior_month);
                $next_month = \Carbon\Carbon::parse($next_month);
                @endphp
                <a href="{{ route('dashboard.index', ['month' => $prior_month->format('F')]) }}">
                    <span class="glyphicon glyphicon-chevron-left pull-left"></span>
                </a>
                {{ $month }}
                <a href="{{ route('dashboard.index', ['month' => $next_month->format('F')]) }}">
                    <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                </a>
            </h3>
        </div>

        <div class="row">
            <h4 class="col-xs-4">Income</h4>
            <h6 class="col-xs-2 text-nowrap"><small>YTD</small></h6>
            <h6 class="col-xs-3 text-nowrap"><small>Curr Mnth</small></h6>
            <h6 class="col-xs-2"></h6>
        </div>
        @foreach($incomes as $heading => $categories)
        <div class="row">
            <h4 class="col-xs-12 text-nowrap">{{ $heading }}</h4>
        </div>
        @foreach($categories as $category)
        <div class="row category-rows">
            @if($category->infrequent)
            <h6 class="col-xs-4 text-nowrap">
                <a href="{{ route('categories.show', $category->id) }}">{{ Str::limit($category->name, 13) }}<sup>*</sup></a>
            </h6>
            <h6 class="col-xs-2 text-nowrap">
                <small>${{ number_format($category->spentToEom($month), 0) }} <small> /${{ number_format($category->budget * 12, 0) }}</small></small>
            </h6>
            <h6 class="col-xs-3 text-nowrap">
                ${{ number_format($category->spent($month), 0) }}<small>/${{ number_format($category->budget, 0) }}</small>
            </h6>
            <div class="col-xs-1">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
            @else
            <h6 class="col-xs-4 text-nowrap">
                <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
            </h6>
            <h6 class="col-xs-2 text-nowrap">
                <small>${{ number_format($category->spentToEom($month), 0) }}<small> /${{ number_format($category->budgetToEom($month), 0) }}</small></small>
            </h6>
            <h6 class="col-xs-3 text-nowrap">
                ${{ number_format($category->spent($month), 0) }}<small>/${{ number_format($category->budget, 0) }}</small>
            </h6>
            <div class="col-xs-1">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
            @endif
        </div>
        @endforeach
        @endforeach

        <div class="row">
            <hr class="col-xs-12">
        </div>

        <div class="row">
            <h4 class="col-xs-4">Expenses</h4>
            <h6 class="col-xs-2 text-nowrap"><small>YTD +/-</small></h6>
            <h6 class="col-xs-1"></h6>
            <h6 class="col-xs-2 text-nowrap"><small>Remaining</small></h6>
            <h6 class="col-xs-2"></h6>
        </div>
        @foreach($expenses as $heading => $categories)
        <div class="row">
            <h4 class="col-xs-12 text-nowrap">{{ $heading }}</h4>
        </div>
        @foreach($categories as $category)
        <div class="row category-rows">
            @if($category->infrequent)
            <h6 class="col-xs-4 text-nowrap">
                <a href="{{ route('categories.show', $category->id) }}">{{ Str::limit($category->name, 13) }}<sup>*</sup></a>
            </h6>
            <h6 class="col-xs-2 text-nowrap">
                <small class="text-{{ $category->status($month) }}">
                    ${{ number_format($category->remainingForYear($month), 0) }} <small>({{ number_format($category->yearlyPercentRemaining($month), 0) }}% rem)</small>
                </small>
            </h6>
            <h6 class="col-xs-1">
                @if($category->status($month) == 'warning')
                <span class="text-warning glyphicon glyphicon-warning-sign" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @elseif($category->status($month) == 'danger')
                <span class="text-danger glyphicon glyphicon-alert" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @endif
            </h6>
            <h6 class="col-xs-2 text-nowrap">
                ${{ number_format($category->budgetToEom($month) - $category->spentToEom($month), 0) }}<small> saved</small>
            </h6>
            @else
            <h6 class="col-xs-4 text-nowrap">
                <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
            </h6>
            <h6 class="col-xs-2 text-nowrap">
                <small class="text-{{ $category->status($month) }}">
                    ${{ number_format($category->budgetToSom($month) - $category->ytdSpent($month), 0) }}
                </small>
            </h6>
            <h6 class="col-xs-1">
                @if($category->status($month) == 'warning')
                <span class="text-warning glyphicon glyphicon-warning-sign" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @elseif($category->status($month) == 'danger')
                <span class="text-danger glyphicon glyphicon-alert" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @endif
            </h6>
            <h6 class="col-xs-2 text-nowrap">
                ${{ number_format($category->remaining($month), 0) }}<small>/${{ number_format($category->budget, 0) }}</small>
            </h6>
            @endif
            <div class="col-xs-1">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="btn btn-success">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>

</x-app-layout>
