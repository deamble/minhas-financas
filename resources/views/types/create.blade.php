<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar nova categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-300 text-green-800 p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="bg-yellow-300 text-yellow-800 p-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('type.store')}}" method="post">
                        @csrf

                        <fieldset class="border-2 rounded p-6 text-blue-800 border border-blue-300">
                            <legend>Preencha todos os campos</legend>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="name">Nome</label>
                                <input type="text" name="name" id="name" class="w-full rounded text-blue-800 border border-blue-300" placeholder="Nome da categoria, Ex: 'nubank', 'carteira', 'cofre'" required autofocus>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="description">Descrição</label>
                                <input type="text" name="description" id="description" class="w-full rounded text-blue-800 border border-blue-300" placeholder="Descreva a categoria">
                            </div>

                            <div class="p-4 flex justify-between mb-4">
                                <div class="ml-auto">
                                    <button type="submit" class="bg-emerald-400 hover:bg-emerald-600 text-white font-bold py-1 px-3 rounded-full">
                                        <i class="fa-regular fa-floppy-disk"></i>
                                    </button>

                                    <a href="{{ route('type.create')}}">
                                        <button type="reset" class="bg-orange-400 hover:bg-orange-600 text-white font-bold py-1 px-3 rounded-full">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
