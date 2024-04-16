<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('users.update',$user->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- category_id --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{$user->name}}" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block
                            w-full" value="{{$user->email}}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Rol')" />
                            <select name="rol" id="role" class="mt-1 block w-full" required>
                                <option value="">Seleccione un rol</option>
                                <option value="1" {{ $user->rol === 1 ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ $user->rol === 2 ? 'selected' : '' }}>Usuario</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />

                        <div class="flex items-center justify-end gap-4 mt-5">
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
