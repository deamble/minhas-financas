<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-500 leading-tight">
            {{ __('Confirmação') }}
        </h2>
    </x-slot>

    <div class="py-12 flex items-center justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 text-red-900 dark:text-red-900 text-center">
                <div class="w-full">
                    <div class="max-w-sm p-6 bg-red-400 border border-red-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-center">
                        <label for="level" class="block text-sm font-medium text-red-900 text-center mb-2"><i class="fa-solid fa-triangle-exclamation "></i> Aviso de exclusão.</label>

                        <p class="mb-3 text-sm font-medium text-red-900">
                            Este procedimento será <b>IRREVERSÍVEL!</b>
                        </p>
                        <p class="mb-4">
                            <strong>Tem certeza que deseja excluir o registro?</strong>
                        </p>
                        <p>
                            <form action="{{ route('type.destroy', $id->id)}}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-white">DELETAR</button>
                                <a href="{{ route('type.byuser', Auth::user()->id) }}">cancelar</a>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
