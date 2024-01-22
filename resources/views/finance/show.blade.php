<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edição de categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <fieldset class="border-2 rounded p-6 border border-blue-800">
                        <legend class="text-blue-800">Movimentação {{ $finance->type->name }} - {{ $finance->value_transaction }} R$</legend>

                        <form action="{{ route('finance.update', $finance->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="flex justify-around">
                                <div class="w-1/2">
                                    <div class="max-w-sm p-6 bg-amber-400 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <label for="level" class="block text-sm font-medium text-white text-center mb-2"><i class="fa-solid fa-triangle-exclamation"></i> Informações para atualização.</label>

                                        <p class="mb-3 text-sm font-medium text-white">
                                            Após atualizar os dados, todos os registros vinculados a categoria editada serão afetados.

                                        </p>
                                    </div>
                                </div>

                                <div class="w-1/2">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                    <label for="level" class="block text-sm font-medium text-blue-600 text-center"><i class="fa-solid fa-layer-group"></i> Dados da movintação</label>
                                    <p class="p-2"><i class="fa-solid fa-file-pen"></i> Descrição
                                        <input type="text" name="description" id="description" value="{{ $finance->description }}"  class="rounded-lg w-full" required>
                                    </p>

                                    <p class="p-2"><i class="fa-solid fa-file-pen"></i> Descrição curta
                                        <input type="text" name="short_description" id="short_description" value="{{ $finance->short_description }}"  class="rounded-lg w-full" required>
                                    </p>

                                    <p class="p-2"><i class="fa-regular fa-money-bill-1"></i> Valor
                                        <input type="number" name="value_transaction" id="value_transaction" step="0.01" value="{{ $finance->value_transaction }}"  class="rounded-lg w-full" required>
                                    </p>

                                    <p class="p-2"><i class="fa-solid fa-magnifying-glass-chart"></i> Tipo de transação
                                        <select name="transaction_type" id="transaction_type" class="w-full rounded" required>
                                            <option value="" disabled>Selecione o tipo de movimentação</option>
                                            <option value="entrada" @if($finance->transaction_type === 'entrada') selected @endif>Entrada</option>
                                            <option value="saida" @if($finance->transaction_type === 'saida') selected @endif>Saída</option>
                                        </select>
                                    </p>

                                    <p class="p-2"><i class="fa-solid fa-diagram-project"></i> Categoria para transação
                                        <select name="type_id" id="type_id" class="w-full rounded" required>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}" @if($finance->type->id === $type->id) selected @endif>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                </div>
                            </div>

                            <div class="p-2 rounded overflow-hidden flex items-center justify-center">
                                <button type="submit" class="bg-emerald-500 border border-emerald-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                    Atualizar
                                </button>
                                <a href="{{ route('finance.index', Auth::user()->id) }}" class="bg-red-500 border border-red-600 text-white rounded p-1 px-3 mr-2 focus:outline-none">
                                    Cancelar
                                </a>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
