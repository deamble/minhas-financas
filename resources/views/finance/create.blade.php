<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova entrada de fluxo financeiro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('finance.store') }}" method="post">
                        @csrf
                        <fieldset class="border-2 rounded p-6 border border-blue-800">
                            <legend class="text-blue-800 col-span-8">
                                Cadastrar Movimentação
                            </legend>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="flex justify-around">
                                <div class="w-1/2">
                                    <div class="max-w-sm p-6 bg-amber-400 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <label for="level" class="block text-sm font-medium text-white text-center mb-2"><i class="fa-solid fa-triangle-exclamation"></i> Informações para cadastro.</label>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Tipo de movimentação</b> - Este campo define se o valor será de entrada ou de saida dentro de uma movimentação realizada.
                                        </p>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Categoria para transação</b> - Seleciona a categoria cadastrada para a movimentação ser realizada.
                                        </p>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Valor</b> - Valor da movimentação, ex: 50,00.
                                        </p>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Descrição</b> - Identifica o que foi feito na movimentação, por exemplo: salário.
                                        </p>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            <b>Descrição curta</b> - Controle interno para saber o motivo da movimentação.
                                        </p>
                                    </div>
                                </div>

                                <div class="w-1/2">
                                    <label for="level" class="block text-sm font-medium text-blue-600 text-center"><i class="fa-solid fa-chart-line"></i> Dados para cadastro de movimentação</label>
                                    <p class="p-2">
                                        <i class="fa-solid fa-magnifying-glass-chart"></i> Tipo de movimentação
                                        <select name="transaction_type" id="transaction_type" class="w-full rounded" required>
                                            <option value="" disabled selected>Selecione o tipo de movimentação</option>
                                            <option value="entrada">Entrada</option>
                                            <option value="saida">Saida</option>
                                        </select>
                                    </p>

                                    <p class="p-2">
                                        <i class="fa-solid fa-list"></i> Categoria para transação
                                        <select name="type_id" id="type_id" class="w-full rounded" required>
                                            <option value="" disabled selected>Selecione uma categoria já cadastrada</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>

                                    <p class="p-2">
                                        <i class="fa-solid fa-money-bill-trend-up"></i></i> Valor
                                        <input type="number" name="value_transaction" id="value_transaction" step="0.01" class="w-full rounded" required>
                                    </p>

                                    <p class="p-2">
                                        <i class="fa-regular fa-message"></i> Descrição
                                        <input type="text" name="description" id="description" class="w-full rounded" required>
                                    </p>

                                    <p class="p-2">
                                        <i class="fa-regular fa-comments"></i> Descrição curta
                                        <input type="text" name="short_description" id="short_description" class="w-full rounded">
                                    </p>
                                </div>
                            </div>

                            <div class="p-2 rounded overflow-hidden flex items-center justify-between">
                                <div class="flex items-center">
                                    <button type="submit" class="bg-emerald-500 border border-emerald-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                        Cadastrar
                                    </button>

                                    <button type="reset" class="bg-orange-500 border border-orange-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                        <i class="fa-solid fa-rotate-left"></i> Limpar
                                    </button>
                                </div>

                                <a href="{{ route('finance.index', Auth::user()->id) }}" class="bg-blue-500 border border-blue-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                    <i class="fa-solid fa-arrow-left-long"></i> Voltar
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
    </script>
</x-app-layout>
