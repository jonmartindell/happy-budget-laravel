<x-app-layout>
    <style>
        .category-rows:nth-child(even) {
            background-color: rgb(228 228 231);
        }

        svg {
            display: inline;
        }
    </style>

    <p id="notice" class="text-center text-lg text-blue-600">{{ session('notice') }}</p>

    <div class="container mx-auto px-4">
        <div class="flex justify-center py-4">
            <h3 class="text-center text-2xl">
                <a href="{{ route('dashboard.index', ['month' => $prior_month]) }}" class="text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>

                </a>
                {{ $month }}
                <a href="{{ route('dashboard.index', ['month' => $next_month]) }}" class="text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>

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

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" color="rgb(138, 109, 59)" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                @elseif ($category->status($month) == 'danger')
                <svg xmlns="http://www.w3.org/2000/svg" color="rgb(169, 68, 66)" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" color="rgb(138, 109, 59)" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                @elseif ($category->status($month) == 'danger')
                <svg xmlns="http://www.w3.org/2000/svg" color="rgb(169, 68, 66)" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                @endif
            </h6>
            <h6 class="text-xs text-gray-500">
                ${{ $category->remaining($month) }}<small>/{{ $category->budget }}</small>
            </h6>
            @endif
            <div class="w-16 text-center">
                <a href="{{ route('transactions.create', ['category' => $category->id]) }}" class="bg-green-500 text-white px-2 py-1 rounded-full hover:bg-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
</x-app-layout>
