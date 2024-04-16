<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Bitacora') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
        <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="alert('{{ session('success') }}'); setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400"
            ></div>
        @endif

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- table --}}
                    <div class="flex justify-between mb-5">
                        <form action="{{ route('logs') }}" method="get" class="flex gap-3 items-center">
                            {{-- input search form --}}
                            <label for="searchTerm" class="sr-only">{{ __('Buscar') }}</label>
                            <input type="text" name="searchTerm" placeholder="{{ __('Buscar') }}" class="px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700">
                            {{-- button search form submit--}}
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md dark:bg-blue-600">{{ __('Buscar') }}</button>
                        </form>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Nombre') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Accion') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                            {{-- Loop through the category --}}
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $log->message }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

