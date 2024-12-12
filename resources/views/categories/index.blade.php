<x-app-layout>
    <div class="max-w-screen-xl mx-auto p-4 sm:p-6 lg:p-8">

        <h1 class="text-2xl font-semibold my-4">Income</h1>

        <table class="min-w-full table-auto border-separate border-spacing-0.5">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b text-left">Name</th>
                    <th class="px-4 py-2 border-b text-left">Who</th>
                    <th class="px-4 py-2 border-b text-left">Avg Monthly</th>
                    <th class="px-4 py-2 border-b text-left">Infrequent</th>
                    <th class="px-4 py-2 border-b text-left">Sort</th>
                    <th class="px-4 py-2 border-b"></th>
                    <th class="px-4 py-2 border-b"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories->where('expense', false)->sortBy(['sort']) as $category)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2">{{ $category->heading }}</td>
                    <td class="px-4 py-2">
                        {{ '$' . number_format($category->budget, 0) }}
                        @if ($category->infrequent)
                        ({{ '$' . number_format($category->budget * 12, 0) }}/yr)
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $category->infrequent ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-2">{{ $category->sort }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('categories.edit', $category) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">Edit</a>
                    </td>
                    <td class="px-4 py-2">
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600" onclick="return confirm('Are you sure?')">Destroy</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="font-bold">
                    <td class="px-4 py-2"><b>Total Income</b></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"><b>{{ '$' . number_format($categories->where('expense', false)->sum('budget'), 0) }}</b></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"></td>
                </tr>
            </tbody>
        </table>

        <h1 class="text-2xl font-semibold my-4">Expenses</h1>

        <table class="min-w-full table-auto border-separate border-spacing-0.5">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b text-left">Name</th>
                    <th class="px-4 py-2 border-b text-left">Heading</th>
                    <th class="px-4 py-2 border-b text-left">Budget</th>
                    <th class="px-4 py-2 border-b text-left">Infrequent</th>
                    <th class="px-4 py-2 border-b text-left">Sort</th>
                    <th class="px-4 py-2 border-b"></th>
                    <th class="px-4 py-2 border-b"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories->where('expense', true)->sortBy(['sort']) as $category)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2">{{ $category->heading }}</td>
                    <td class="px-4 py-2">
                        {{ '$' . number_format($category->budget, 0) }}
                        @if ($category->infrequent)
                        ({{ '$' . number_format($category->budget * 12, 0) }}/yr)
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $category->infrequent ? 'Yes' : 'No' }}</td>
                    <td class="px-4 py-2">{{ $category->sort }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('categories.edit', $category) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">Edit</a>
                    </td>
                    <td class="px-4 py-2">
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600" onclick="return confirm('Are you sure?')">Destroy</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr class="font-bold">
                    <td class="px-4 py-2"><b>Total Expenses</b></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"><b>{{ '$' . number_format($categories->where('expense', true)->sum('budget'), 0) }}</b></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2"></td>
                </tr>
            </tbody>
        </table>

        <hr class="my-4">

        <h1 class="text-xl font-semibold">Average Income - Expenses: {{ '$' . number_format($categories->where('expense', false)->sum('budget') - $categories->where('expense', true)->sum('budget'), 0) }}</h1>

        <br>

        <a href="{{ route('categories.create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">New Category</a>
    </div>
</x-app-layout>
