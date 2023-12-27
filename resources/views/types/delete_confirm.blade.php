<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-500 leading-tight">
            {{ __('Confirmação') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-red-300 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-red-900 dark:text-red-900 text-center">
                    <p class="mb-4">
                        Tem certeza que deseja excluir o regristro <strong></strong>?
                    </p>

                    <p>
                        <form action="{{ route('type.destroy', $id->id)}}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-red-500">DELETAR</button>
                            <a href="{{ route('type.byuser', Auth::user()->id) }}">cancelar</a>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
