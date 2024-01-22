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

                    <form action="{{ route('type.store')}}" method="post">
                        @csrf

                        <fieldset class="border-2 rounded p-6 border border-blue-800">
                            <legend class="text-blue-800">Cadastro de categorias</legend>
                            {{-- User ID hidden to update --}}
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="flex justify-around">
                                <div class="w-1/2">
                                    <div class="max-w-sm p-6 bg-amber-400 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <label for="level" class="block text-sm font-medium text-white text-center mb-2"><i class="fa-solid fa-triangle-exclamation"></i> Informações para cadastro</label>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Nome</b> - Este campo é para identificar a origem de suas entradas ou saidas, por exemplo:
                                            'Nubank', 'Caixa', 'Cofre', 'Carteira' etc...
                                        </p>
                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Descrição</b> - Este é para identificação interna, sendo possivel o usuário fazer um comentario pessoal por cada item cadastrado.
                                        </p>
                                    </div>
                                </div>

                                <div class="w-1/2">
                                    <label for="level" class="block text-sm font-medium text-blue-600 text-center"><i class="fa-solid fa-layer-group"></i> Dados de cadastro</label>
                                    <p class="p-2"><i class="fa-solid fa-list"></i> Nome<input type="text" name="name"  id="name" class="rounded-lg w-full" required></p>
                                    <p class="p-2"><i class="fa-regular fa-message"></i> Descrição<input type="text" name="description" id="description" class="rounded-lg w-full"></p>
                                </div>
                            </div>

                            <div class="p-2 rounded overflow-hidden flex items-center justify-center">
                                <button type="submit" class="bg-emerald-500 border border-emerald-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                    Cadastrar
                                </button>
                                <a href="{{ route('type.create')}}" class="bg-red-500 border border-red-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                    Limpar
                                </a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</x-app-layout>
