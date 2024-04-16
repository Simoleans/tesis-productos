<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Usuarios') }}
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
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- table --}}
                    <div class="flex justify-between mb-5">
                        <a href="{{ route('users.create') }}" class="px-4 py-1 flex items-center text-white bg-blue-500 rounded-md dark:bg-blue-600">{{ __('Crear Usuario') }}</a>
                        <div class="mt-4">
                            <form action="{{ route('users.index') }}" method="get" class="flex gap-3 items-center">
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
                                    {{ __('Email') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Estatus') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Rol') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ __('Accion') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800">
                            {{-- Loop through the products --}}
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $user->status == 1 ? 'Activo' : 'Inactivo' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $user->rol == 1 ? 'Administrador' : 'Usuario' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">{{ __('Editar') }}</a>
                                        @if(auth()->user()->rol == 1)
                                            {{-- <button x-data="{ userId: {{ $user->id }} }" @click="confirmDisable" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">{{ __('Suspender') }}</button> --}}
                                            @if ($user->status == 1)
                                                <form method="POST" action="{{ route('users.disabled', $user->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                    <button onclick="return confirm('¿Estás seguro de que quieres suspender a este usuario?')" type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">{{ __('Suspender') }}</button>
                                                </form>

                                            @else
                                                <form method="POST" action="{{ route('users.enabled', $user->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                    <button onclick="return confirm('¿Estás seguro de que quieres habilitar a este usuario?')" type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600">{{ __('Habilitar') }}</button>
                                                </form>
                                            @endif



                                                <form method="POST" action="{{ route('users.passUpdate', $user->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{$user->id}}">

                                                    <button onclick="return confirm('¿Estás seguro de que quieres reiniciar la clave de este usuario?')" type="submit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-red-600">{{ __('Cambiar Clave') }}</button>

                                                </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>


@if (isset($user))


<script>
    function confirmUpdatePass() {
      if (confirm('¿Estás seguro de que quieres reiniciar la clave de este usuario?')) {

        const form = document.querySelector(`form[action="{{ route('users.passUpdate', $user?->id) }}"]`);

        form.submit();
      }
    }

    function confirmDisable() {
      if (confirm('¿Estás seguro de que quieres suspender este usuario?')) {

        const form = document.querySelector(`form[action="{{ route('users.disabled', $user?->id) }}"]`);

        form.submit();
      }
    }
  </script>
  @endif

