<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-600">
                    <div class="">
                        <form  action="{{ route('user.update', $user->id) }}" method="post" class="w-full">
                            @csrf

                            @method('PUT')

                            <fieldset class="border-2 rounded p-6 border border-blue-800">
                                <legend class="text-blue-800 ">
                                    <strong>
                                        {{ $user->name }} -
                                        @if ($user->level == 'admin')
                                            Administrador
                                        @else
                                            Usuário
                                        @endif
                                    </strong>
                                </legend>

                                <div class="flex justify-around">

                                    <!-- Primeira Coluna -->
                                    <div class="w-1/2">
                                        <label for="level" class="block text-sm font-medium text-blue-600">Informações atuais</label>
                                        <p class="p-2"><i class="fa-solid fa-user"></i> <b>{{ $user->name }}</b></p>
                                        <p class="p-2"><i class="fa-solid fa-envelope"></i> <b>{{ $user->email }}</b></p>
                                        <p class="p-2"><i class="fa-solid fa-unlock-keyhole"></i> <b> @if ($user->level == 'admin')
                                            Administrador
                                        @else
                                            Usuário
                                        @endif</b></p>
                                    </div>

                                    <!-- Segunda Coluna -->
                                    <div class="w-1/2">
                                        <label for="level" class="block text-sm font-medium text-blue-600">Informações atualizadas</label>
                                        <p class="p-2"><input type="text" name="name" value="{{ $user->name }}" class="rounded-lg w-full"></p>
                                        <p class="p-2"><input type="text" name="email" value="{{ $user->email }}" class="rounded-lg w-full"></p>
                                        <p class="p-2">
                                            <select name="level" id="" required class="text-sm rounded-lg focus:ring-blue-300 focus:border-blue-500 block p-1 w-full">
                                                <option value="" selected disabled></option>
                                                <option value="user">Usuário</option>
                                                <option value="admin">Administrador</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>


                                <div class="p-2 rounded overflow-hidden flex items-center justify-center">
                                    <button type="submit" class="bg-emerald-500 border border-emerald-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                        {{-- <i class="fa-solid fa-floppy-disk"></i> --}}
                                        Atualizar
                                    </button>
                                    <a href="{{ route('user.index')}}" class="bg-red-500 border border-red-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                        {{-- <i class="fa-solid fa-ban"></i> --}}
                                        Cancelar
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
