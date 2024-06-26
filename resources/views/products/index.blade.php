<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="alert('{{ session('success') }}'); setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400"
            ></div>
        @endif
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex">
                    {{-- select products --}}
                    <form action="{{route('stock.report')}}" method="POST" class="flex w-full">
                        @csrf
                        <div class="p-5 w-full">
                            <x-input-label for="product_id" :value="__('Producto')" />
                            <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md dark:border-gray-700" required>
                                <option value="">Seleccione una categoria</option>
                                @foreach ($products as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="p-5 w-full">
                            <x-input-label for="type" :value="__('Tipo')" />
                            <select name="type" id="type" class="mt-1 block w-full rounded-md dark:border-gray-700" >
                                <option value="3">Todos</option>
                                <option value="1">Entrada</option>
                                <option value="2">Salida</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-end">
                        {{-- select products --}}
                        <div class="p-5">
                            <button type="submit" class="px-4 py-1 flex items-center text-white bg-blue-500 rounded-md dark:bg-blue-600">{{ __('Generar PDF') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- table --}}
                    <div class="flex justify-between mb-5">
                        <a href="{{ route('products.create') }}" class="px-4 py-1 flex items-center text-white bg-blue-500 rounded-md dark:bg-blue-600">{{ __('Crear Producto') }}</a>
                        <div class="mt-4">
                            <form action="{{ route('products.index') }}" method="get" class="flex gap-3 items-center">
                                {{-- input search form --}}
                                <label for="searchTerm" class="sr-only">{{ __('Buscar') }}</label>
                                <input type="text" name="searchTerm" placeholder="{{ __('Buscar Nombre') }}" class="px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700">
                                {{-- button search form submit--}}
                                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md dark:bg-blue-600">{{ __('Buscar') }}</button>
                            </form>

                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Nombre') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Categoria') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Foto') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Stock') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Accion') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                            {{-- Loop through the products --}}
                            @foreach ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/products/' . $product->photo) }}" alt="{{ $product->photo }}" class="w-10 h-10 rounded-full">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-2">



                                        <a href="{{ route('stock', $product->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600">{{ __('Entrada/Salida') }}</a>

                                        @if (auth()->user()->rol == 1)
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">{{ __('Editar') }}</a>

                                            <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')" type="submit"  class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">{{ __('Eliminar') }}</button>

                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

@if (isset($product))

    <script>
        function confirmDelete() {
        if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {

            const form = document.querySelector(`form[action="{{ route('products.destroy', $product?->id) }}"]`);

            form.submit();
        }
        }
    </script>
@endif

