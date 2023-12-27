<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edição de categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-amber-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-amber-800 ">
                    <fieldset class="border-2 border-amber-800 rounded p-6">
                        <legend>Movimentação {{ $finance->type->name }} - {{ $finance->value_transaction }} R$</legend>

                        <form action="{{ route('finance.update', $finance->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="description" class="block text-sm font-medium">Descrição</label>
                                <input type="text" name="description" id="description" value="{{ $finance->description }}" class="w-full rounded bg-amber-200 border border-amber-500" required autofocus>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="short_description" class="block text-sm font-medium">Descrição curta</label>
                                <input type="text" name="short_description" id="short_description" value="{{ $finance->short_description }}" class="w-full rounded bg-amber-200 border border-amber-500">
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="value_transaction" class="block text-sm font-medium">Valor</label>
                                <input type="number" name="value_transaction" id="value_transaction" step="0.01" value="{{ $finance->value_transaction }}" class="w-full rounded bg-amber-200 border border-amber-500" required >
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="transaction_type" class="block text-sm font-medium">Tipo de transação</label>
                                <select name="transaction_type" id="transaction_type" class="w-full rounded bg-amber-200 border border-amber-500" required>
                                    <option value="" disabled>Selecione o tipo de movimentação</option>
                                    <option value="entrada" @if($finance->transaction_type === 'entrada') selected @endif>Entrada</option>
                                    <option value="saida" @if($finance->transaction_type === 'saida') selected @endif>Saída</option>
                                </select>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="type_id" class="block text-sm font-medium text-amber-700">Categoria para transação</label>
                                <select name="type_id" id="type_id" class="w-full rounded bg-amber-200 border border-amber-500" required>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" @if($finance->type->id === $type->id) selected @endif>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="p-4 flex justify-between mb-4">
                                <div class="ml-auto">
                                    <button type="submit" class="bg-emerald-400 hover:bg-emerald-600 text-white font-bold py-1 px-3
                                    rounded-full">
                                        <i class="fa-regular fa-floppy-disk"></i> Gravar
                                    </button>

                                    <a href="{{ route('finance.index') }}" class="inline-block bg-orange-400 hover:bg-orange-600 text-white font-bold py-1 px-3 rounded-full">
                                        <i class="fa-solid fa-xmark"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
