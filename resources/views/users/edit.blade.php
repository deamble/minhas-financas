<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-md shadow-md w-96 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 overflow-hidden shadow-sm sm:rounded-lg">
                <form  action="{{ route('user.update', $user->id) }}" method="post" class="w-full">
                    @csrf

                    @method('PUT')
                    <fieldset class="border-2 rounded p-6 border border-yellow-200">
                        <legend class="text-yellow-600 "> <strong>{{ $user->name }} - {{ $user->level }}</legend>

                        <div class="mb-4 w-full">
                            <label for="level" class="block text-sm font-medium text-yellow-600">Alterar nível</label>
                            <select name="level" id="" required class="text-sm rounded-lg focus:ring-blue-300 focus:border-blue-500 block w-full p-2.5">
                                <option value="" selected disabled></option>
                                <option value="user">Usuário</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                        <div class="p-2 rounded overflow-hidden flex items-center justify-center">
                            <button type="submit" class="bg-emerald-500 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                            <a href="{{ route('user.index')}}" class="bg-red-500 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                <i class="fa-solid fa-ban"></i>
                            </a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
