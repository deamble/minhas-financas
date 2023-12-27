<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movimentações') }}
        </h2>
    </x-slot>

    <div class="py-12">

        @if (session('success'))
            <div class="max-w-7xl mb-2 mx-auto sm:px-6 lg:px-8 p-2">
                <div class="bg-green-500 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center text-white">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if ($allFinances->isEmpty())
            {{-- Cadastrar uma movimentação quando não há nenhuma --}}
            <p class="text-center text-gray-600 mb-4">Ainda não há nenhuma movimentação.</p>
            <p class="text-center text-gray-600">
                <a href="{{ route('finance.create')}}">
                    <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-full">
                        <i class="fa-solid fa-chart-line mr-2"></i>
                        Adicionar Movimentação
                    </button>
                </a>
            </p>
        @else
        {{-- Exibe apenas se já tiver alguma movimentação cadastrada --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="col-span-1 col-span-1 bg-emerald-400 p-4 rounded text-green-700 border border-emerald-500 flex items-center">
                <i class="fa-solid fa-arrow-trend-up mr-2"></i>
                <div class="mx-auto">{{ $allEntries }} R$</div>
            </div>
            <div class="col-span-1 bg-red-400 p-4 rounded text-red-700 border border-red-500 flex items-center">
                <i class="fa-solid fa-arrow-trend-down mr-2"></i>
                <div class="mx-auto">{{ $allExpenses }} R$</div>
            </div>
            <div class="col-span-1 bg-amber-400 p-4 rounded text-amber-700 border border-amber-500 flex items-center">
                <i class="fa-solid fa-coins mr-2"></i>
                <div class="mx-auto">{{ $total }} R$</div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="col-span-1">
                <div class="rounded flex items-center gap-1">
                    <div class="flex items-center w-full relative">
                        <input type="date" id="data_entrada" name="data_entrada" class="w-full rounded-lg border border-emerald-400 text-emerald-500 focus:border-emerald-500 focus:ring focus:ring-emerald-200 pl-8" title="Data de Entrada">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-emerald-500">
                            <!-- Ícone de calendário do Tailwind -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="flex items-center w-full relative">
                        <i class="fa-solid fa-calendar-invert text-lg mr-2 text-amber-500" title="Data de Saída"></i>
                        <input type="date" id="data_saida" name="data_saida" class="w-full rounded-lg border border-amber-400 text-amber-500 focus:border-amber-500 focus:ring focus:ring-amber-200 pl-8" title="Data de Saída">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-amber-500">
                            <!-- Ícone de calendário do Tailwind -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="col-span-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="table-auto w-full rounded-t-lg mx-auto">
                        @foreach($allFinances as $finance)
                        <tbody class="">
                            @if ($finance->transaction_type == 'entrada')
                            <tr class="text-center font-bold bg-emerald-200">
                                <td class="px-4 py-3 text-emerald-700"><i class="fa-solid fa-arrow-trend-up"></i></td>
                                <td class="px-4 py-3 text-emerald-700">{{ $finance->value_transaction}} R$</td>
                                <td class="px-4 py-3 text-emerald-700">{{ $finance->description}}</td>
                                <td class="px-4 py-3 text-emerald-700">{{ $finance->created_at}}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('finance.show', $finance->id)}}" class="text-emerald-500 hover:text-emerald-700 p-1"><i class="fa-solid fa-eye"></i></a>
                                    {{-- <a href="{{ route('finance.confirm_delete', $finance->id)}}" class="text-red-400 hover:text-red-600 p-1"><i class="fa-solid fa-trash"></i></a> --}}
                                </td>
                            </tr>
                            @else
                            <tr class="text-center font-bold bg-amber-200">
                                <td class="px-4 py-3 text-amber-700"><i class="fa-solid fa-arrow-trend-down"></i></td>
                                <td class="px-4 py-3 text-amber-700">{{ $finance->value_transaction}} R$</td>
                                <td class="px-4 py-3 text-amber-700">{{ $finance->description}}</td>
                                <td class="px-4 py-3 text-amber-700">{{ $finance->created_at}}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('finance.show', $finance->id)}}" class="text-amber-500 hover:text-amber-700 p-1"><i class="fa-solid fa-eye"></i></a>
                                    {{-- <a href="{{ route('finance.confirm_delete', $finance->id)}}" class="text-red-400 hover:text-red-600 p-1"><i class="fa-solid fa-trash"></i></a> --}}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="col-span-1">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-full text-gray-900">
                        <div class="bg-emerald-400 hover:bg-emerald-600 text-white font-bold py-1 px-5 rounded-m flex items-center">
                            <i class="fa-solid fa-chart-line mr-2"></i>
                            <a href="{{ route('finance.create')}}">
                                <button>Adicionar Movimentação</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif


    </div>

</x-app-layout>
