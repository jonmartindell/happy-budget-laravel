<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            @if ($errors->any())
            <div id="error_explanation" class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
                <h2 class="font-semibold">{{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} prohibited this category from being saved:</h2>

                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-4">
                <label for="heading" class="block text-sm font-medium text-gray-700">{{ __('Heading') }}</label>
                <input type="text" name="heading" id="heading" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('heading', $category->heading ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('name', $category->name ?? '') }}">
            </div>

            <div class="mb-4">
                <label for="sort" class="block text-sm font-medium text-gray-700">{{ __('Sort') }}</label>
                <input type="number" name="sort" id="sort" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('sort', $category->sort ?? '') }}" step="0.01">
            </div>

            <div class="mb-4">
                <label for="budget" class="block text-sm font-medium text-gray-700">{{ __('Budget') }}</label>
                <input type="number" name="budget" id="budget" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('budget', $category->budget ?? '') }}">
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="infrequent" id="infrequent" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" {{ old('infrequent', $category->infrequent ?? false) ? 'checked' : '' }}>
                <label for="infrequent" class="ml-2 text-sm font-medium text-gray-700">{{ __('Infrequent') }}</label>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="expense" id="expense" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" {{ old('expense', $category->expense ?? false) ? 'checked' : '' }}>
                <label for="expense" class="ml-2 text-sm font-medium text-gray-700">{{ __('Expense') }}</label>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Create') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
