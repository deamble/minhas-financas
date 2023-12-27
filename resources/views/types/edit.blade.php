<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edição de categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('type.update', ['type' => $type->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        <fieldset class="border-2 rounded p-6">
                            <legend>Preencha todos os campos</legend>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="name">Nome</label>
                                <input type="text" name="name" id="name" value="{{ $type->name }}" class="w-full rounded" required autofocus>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="description">Descrição</label>
                                <input type="text" name="description" id="description" value="{{ $type->description }}" class="w-full rounded">
                            </div>

                            <div class="p-4 rounded overflow-hidden">
                                <button type="submit" class="bg-emerald-500 text-white rounded p-2 focus:outline-none">
                                    <i class="fa-solid fa-floppy-disk"></i> Atualizar
                                </button>
                                <button type="submit" class="bg-red-500 text-white rounded p-2 focus:outline-none">
                                    <i class="fa-solid fa-ban"></i> Cancelar
                                    <a href="{{ route('type.byuser', Auth::user()->id) }}" class="text-white">Cancelar</a>
                                </button>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
