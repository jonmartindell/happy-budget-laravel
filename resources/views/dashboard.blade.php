<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .category-rows:nth-child(even) {
            background-color: #f1f1f1;
        }
    </style>

    <p id="notice" class="text-center text-lg text-blue-600">{{ session('notice') }}</p>

    <div class="container mx-auto px-4">
        <div class="flex justify-center py-4">
            <h3 class="text-center text-2xl">
                <a href="{{ route('dashboard.index', ['month' => $prior_month]) }}" class="text-gray-600">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                {{ $month }}
                <a href="{{ route('dashboard.index', ['month' => $next_month]) }}" class="text-gray-600">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </h3>
        </div>

        <div class="flex items-center space-x-4 py-2">
            <h4 class="flex-1 text-lg">Income</h4>
            <h6 class="text-xs text-gray-500">YTD</h6>
            <h6 class="text-xs text-gray-500">Curr Mnth</h6>
            <h6 class="w-16"></h6>
        </div>

        @foreach ($incomes as $heading => $categories)
        <div class="flex items-center space-x-4 py-2">
            <h4 class="text-lg">{{ $heading }}</h4>
        </div>
        @foreach ($categories as $category)
        <div class="flex items-center py-2 px-4 category-rows">
            @if ($category->infrequent)
            <h6 class="flex-1 text-sm text-nowrap">
                <a href="{{ route('categories.show', $category) }}" class="text-blue-500">{{ Str::limit($category->name, 13) }}<sup>*</sup></a>
            </h6>
            <h6 class="text-xs text-gray-500">
                <small> ${{ $category->spentToEom($month) }} /$ {{ $category->budget * 12 }} </small>
            </h6>
            <h6 class="text-xs text-gray-500">
                ${{ $category->spent($month) }}<small>/{{ $category->budget }}</small>
            </h6>
            <div class="w-16 text-center">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="bg-green-500 text-white px-2 py-1 rounded-full hover:bg-green-600">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
            @else
            <h6 class="flex-1 text-sm">
                <a href="{{ route('categories.show', $category) }}" class="text-blue-500">{{ $category->name }}</a>
            </h6>
            <h6 class="text-xs text-gray-500">
                <small>$ {{ $category->spentToEom($month) }}<small>/{{ $category->budgetToEom($month) }}</small></small>
            </h6>
            <h6 class="text-xs text-gray-500">
                ${{ $category->spent($month) }}<small>/{{ $category->budget }}</small>
            </h6>
            <div class="w-16 text-center">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="bg-green-500 text-white px-2 py-1 rounded-full hover:bg-green-600">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
            @endif
        </div>
        @endforeach
        @endforeach

        <div class="my-4">
            <hr class="border-t-2">
        </div>

        <div class="flex items-center space-x-4 py-2">
            <h4 class="flex-1 text-lg">Expenses</h4>
            <h6 class="text-xs text-gray-500">YTD +/-</h6>
            <h6 class="w-16"></h6>
            <h6 class="text-xs text-gray-500">Remaining</h6>
            <h6 class="w-16"></h6>
        </div>

        @foreach ($expenses as $heading => $categories)
        <div class="flex items-center space-x-4 py-2">
            <h4 class="text-lg">{{ $heading }}</h4>
        </div>
        @foreach ($categories as $category)
        <div class="flex items-center py-2 px-4 category-rows">
            @if ($category->infrequent)
            <h6 class="flex-1 text-sm text-nowrap">
                <a href="{{ route('categories.show', $category) }}" class="text-blue-500">{{ Str::limit($category->name, 13) }}<sup>*</sup></a>
            </h6>
            <h6 class="text-xs text-{{ $category->status($month) }}-500">
                ${{ $category->remainingForYear($month) }}<small> ({{ $category->yearlyPercentRemaining($month) }}% rem)</small>
            </h6>
            <h6 class="w-16 text-center">
                @if ($category->status($month) == 'warning')
                <span class="text-warning glyphicon glyphicon-warning-sign" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @elseif ($category->status($month) == 'danger')
                <span class="text-danger glyphicon glyphicon-alert" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @endif
            </h6>
            <h6 class="text-xs text-gray-500">
                ${{ $category->budgetToEom($month) - $category->spentToEom($month) }}<small> saved</small>
            </h6>
            @else
            <h6 class="flex-1 text-sm">
                <a href="{{ route('categories.show', $category) }}" class="text-blue-500">{{ $category->name }}</a>
            </h6>
            <h6 class="text-xs text-{{ $category->status($month) }}-500">
                ${{ $category->budgetToSom($month) - $category->ytdSpent($month) }}
            </h6>
            <h6 class="w-16 text-center">
                @if ($category->status($month) == 'warning')
                <span class="text-warning glyphicon glyphicon-warning-sign" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @elseif ($category->status($month) == 'danger')
                <span class="text-danger glyphicon glyphicon-alert" data-toggle="tooltip" title="{{ $category->statusReason($month) }}"></span>
                @endif
            </h6>
            <h6 class="text-xs text-gray-500">
                ${{ $category->remaining($month) }}<small>/{{ $category->budget }}</small>
            </h6>
            @endif
            <div class="w-16 text-center">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="bg-green-500 text-white px-2 py-1 rounded-full hover:bg-green-600">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

</x-app-layout>
