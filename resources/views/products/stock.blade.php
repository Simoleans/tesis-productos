<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Movimientos del Producto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('stock.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$product->id}}">
                        <div>
                            <x-input-label for="type" :value="__('Tipo')" />
                            <select name="type" id="type" class="mt-1 block w-full rounded-md dark:border-gray-700" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="1">Entrada</option>
                                <option value="2">Salida</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>
                        <div>
                            <x-input-label for="quantity" :value="__('Cantidad')" />
                            <x-text-input id="quantity" name="quantity"  type="text" class="mt-1 block w-full" required autofocus autocomplete="quantity" />
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Descripcion')" />
                            <textarea id="description" name="description" class="mt-1 block w-full rounded-md dark:border-gray-700" required></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                            @if (session('status') === 'product-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Guardado.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
