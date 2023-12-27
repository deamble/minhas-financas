<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova entrada de fluxo financeiro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-200 text-indigo-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-300 text-green-800 p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($types->isEmpty())
                        {{-- Cadastrar uma cadastrada quando não há nenhuma --}}
                        <p class="text-center text-gray-600 mb-4">Ainda não há nenhuma categoria cadastrada.</p>
                        <p class="text-center text-gray-600">
                            <a href="{{ route('type.create')}}">
                                <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-full">
                                    Cadastrar categoria
                                </button>
                            </a>
                        </p>
                    @else

                    <form action="{{ route('finance.store') }}" method="post">
                        @csrf

                        <fieldset class="border-2 rounded p-6 border border-indigo-700">
                            <legend>Movimentação</legend>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="p-4 rounded overflow-hidden">
                                <label for="transaction_type">Tipo de transação</label>
                                <select name="transaction_type" id="transaction_type" class="w-full rounded border border-indigo-300 bg-indigo-200" required>
                                    <option value="" disabled selected>Selecione o tipo de movimentação</option>
                                    <option value="entrada">Entrada</option>
                                    <option value="saida">Saida</option>
                                </select>
                            </div>

                            <div class="p-4 rounded overflow-hidden">
                                <label for="type_id">Categoria para transação</label>
                                <select name="type_id" id="type_id" class="w-full rounded border border-indigo-300 bg-indigo-200" required>
                                    <option value="" disabled selected>Selecione uma categoria já cadastrada</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="value_transaction">Valor</label>
                                <input type="number" name="value_transaction" id="value_transaction" step="0.01" class="w-full rounded text-indigo-800 border border-indigo-300 bg-indigo-200" placeholder="Valor da movimentação, ex: 50,00" required>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="description">Descrição</label>
                                <input type="text" name="description" id="description" class="w-full rounded text-indigo-800 border border-blue-300 bg-indigo-200" placeholder="Descrição para a movimentação" required>
                            </div>

                            <div class="p-4 rounded overflow-hidden mb-4">
                                <label for="short_description">Descrição curta</label>
                                <input type="text" name="short_description" id="short_description" class="w-full rounded text-indigo-800 border border-blue-300 bg-indigo-200" placeholder="Informações adicionais">
                            </div>

                            <div class="p-4 flex justify-between mb-4">
                                <div class="ml-auto">
                                    <button type="submit" class="bg-emerald-400 hover:bg-emerald-600 text-white font-bold py-1 px-3
                                    rounded-full">
                                        <i class="fa-regular fa-floppy-disk"></i> Gravar
                                    </button>

                                    <a href="">
                                        <button type="reset" class="bg-orange-400 hover:bg-orange-600 text-white font-bold py-1 px-3 rounded-full">
                                            <i class="fa-solid fa-rotate-left"></i> Limpar
                                        </button>
                                    </a>
                                </div>
                            </div>

                        </fieldset>
                    </form>

                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
