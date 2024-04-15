<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Crear Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('products.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        {{-- category_id --}}
                        <div>
                            <x-input-label for="category_id" :value="__('Categoria')" />
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md dark:border-gray-700" required>
                                <option value="">Seleccione una categoria</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Descripcion')" />
                            <textarea id="description" name="description" class="mt-1 block w-full rounded-md dark:border-gray-700" required></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="mt-5 flex">
                            <div x-data="{ imagePreview: null }">
                                <input type="file" name="photo" class="px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700"
                                        x-on:change="imagePreview = URL.createObjectURL($event.target.files[0])">
                                <x-input-error class="mt-2" :messages="$errors->get('photo')" />

                                <div x-show="imagePreview">
                                    <img :src="imagePreview" alt="Image Preview" class="mt-4 max-w-xs">
                                </div>
                            </div>
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
