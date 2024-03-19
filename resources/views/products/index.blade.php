<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Productos") }}
                    {{-- table --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Category') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Photo') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Created At') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                            {{-- Loop through the products --}}
                            @foreach ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->name_category_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ $product->photo }}" alt="{{ $product->name_category_id }}" class="w-10 h-10 rounded-full">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                    <div class="mt-4">
                        <input type="text" name="search" placeholder="{{ __('Search') }}" class="px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
