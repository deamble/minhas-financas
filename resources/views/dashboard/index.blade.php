<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Olá <strong class="text-amber-500">{{ Auth::user()->name }},</strong> {{ __('visão geral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @php
            $meses = [
                1 => 'Janeiro',
                2 => 'Fevereiro',
                3 => 'Março',
                4 => 'Abril',
                5 => 'Maio',
                6 => 'Junho',
                7 => 'Julho',
                8 => 'Agosto',
                9 => 'Setembro',
                10 => 'Outubro',
                11 => 'Novembro',
                12 => 'Dezembro'
            ];
            $mesAtual = $meses[now()->format('n')];
        @endphp

        <h2 class="grid grid-cols-1 sm:grid-cols-3 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4"><strong>Resumo mensal - {{ $mesAtual }}</strong></h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="col-span-1 col-span-1 bg-emerald-400 p-4 rounded text-green-700 border border-emerald-500 flex items-center">
                <i class="fa-solid fa-arrow-trend-up mr-2"></i>
                <div class="mx-auto">{{ $totalValuesEntries }} R$</div>
            </div>
            <div class="col-span-1 bg-red-400 p-4 rounded text-red-700 border border-red-500 flex items-center">
                <i class="fa-solid fa-arrow-trend-down mr-2"></i>
                <div class="mx-auto"> {{ $totalValuesExpenses }} R$</div>
            </div>
            <div class="col-span-1 bg-amber-400 p-4 rounded text-amber-700 border border-amber-500 flex items-center">
                <i class="fa-solid fa-coins mr-2"></i>
                <div class="mx-auto">{{ $totalBalancePerMonthly }} R$</div>
            </div>
        </div>
        {{-- Metricas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-indigo-200 border border-indigo-400 text-indigo-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <header class="text-center mb-4"><strong>Numeros de movimentação para {{ $mesAtual }}</strong></header>

                    {{-- Quantidade de entrdas --}}
                    @if ($entriesPerMonth->isNotEmpty())
                        <strong>
                            <i class="fa-solid fa-arrow-trend-up mr-2 text-emerald-700"></i>
                            Quantidade até o momento de entrdas: <b class="text-emerald-700">{{ $entriesPerMonth->first()->entry_count }}</b>
                        </strong>
                    @else

                        <strong class="text-red-700">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Até o momento não há entradas
                        </strong>
                    @endif

                    <br>
                    {{-- Quantidade de saidas --}}
                    @if ($expensesPerMonth->isNotEmpty())
                        <strong>
                            <i class="fa-solid fa-arrow-trend-down mr-2 text-red-700"></i>
                            Quantidade até o momento de saidas: <b class="text-red-700">{{ $expensesPerMonth->first()->expenses_count }}</b>
                        </strong>
                    @else
                        <strong class="text-red-700">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Até o momento não há saidas
                        </strong>
                    @endif

                    <br>
                    {{-- Quantidade de movimentações realizadas --}}
                    @if ($balancePerMonthly->isNotEmpty())
                        <strong>
                            <i class="fa-solid fa-file-signature mr-2 text-cyan-700"></i>
                            O total de movimentações realizadas é de: <b class="text-red-700">{{ $balancePerMonthly->first()->balance_count }}</b>
                        </strong>
                    @else
                        <strong class="text-red-700">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Até o momento não há registros
                        </strong>
                    @endif
                </div>
            </div>

            <div class="bg-red-400 overflow-hidden shadow-sm sm:rounded-lg bg-rose-200 border border-rose-400 text-rose-900">
                <div class="p-6">
                    <header class="text-center mb-4"><strong>Métricas por categoria para {{ $mesAtual }}</strong></header>

                    @if ($balancePerMonthly->isNotEmpty())
                        @foreach ($transactionsByType as $typeName => $transactions)
                            <div class="ml-2">
                                {{ $transactions->count() }} Movimentações para a categoria <strong>{{ $typeName }}</strong><br>
                            </div>
                        @endforeach
                    @else
                        <strong class="text-red-700">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Até o momento não há registros
                        </strong>
                    @endif

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        @if ($entriesPerMonth->isNotEmpty() && $expensesPerMonth->isNotEmpty())

            <div class="overflow-hidden shadow-sm sm:rounded-lg bg-orange-100 border border-orange-500">
                <div class="p-6">
                    <canvas id="monthlyEntriesChart" width="400" height="200"></canvas>
                </div>
            </div>

        @else
            <strong class="text-red-700 text-center">
                Não há registros suficientes para gerar gráficos.
            </strong>
        @endif

        @if ($totalValuesEntries !== 0 && $totalValuesExpenses !== 0 && $totalBalancePerMonthly !== 0)

            {{-- grafico de valores --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg bg-lime-100 border border-lime-500">
                <div class="p-6 text-gray-900">
                    <canvas id="financeValues" width="400" height="200"></canvas>
                </div>
            </div>

        @else
            <strong class="text-red-700 text-center">
                Não há registros suficientes para gerar gráficos.
            </strong>
        @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('monthlyEntriesChart').getContext('2d');
            var monthlyEntriesChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Entradas', 'Saídas'],
                    datasets: [{
                        data: [
                            {!! $entriesPerMonth->sum('entry_count') !!},
                            {!! $expensesPerMonth->sum('expenses_count') !!}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            display: false,
                        },
                        x: {
                            display: false,
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 20,
                                padding: 10,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('financeValues').getContext('2d');
            var monthlyEntriesChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Entradas R$', 'Saídas R$', 'Total R$'],
                    datasets: [{
                        data: [
                            {!! $totalValuesEntries !!},
                            {!! $totalValuesExpenses !!},
                            {!! $totalBalancePerMonthly !!}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 193, 7, 0.2)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 193, 7, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            display: false,
                        },
                        x: {
                            display: false,
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 20,
                                padding: 10,
                                usePointStyle: true,
                                generateLabels: function(chart) {
                                    var data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map(function(label, i) {
                                            var dataset = data.datasets[0];
                                            var value = dataset.data[i];
                                            return {
                                                text: label + ' ' + value + ' R$',
                                                fillStyle: dataset.backgroundColor[i],
                                                hidden: isNaN(dataset.data[i]),
                                                lineCap: 'butt',
                                                lineDash: [],
                                                lineDashOffset: 0,
                                                lineJoin: 'miter',
                                                lineWidth: 1,
                                                strokeStyle: dataset.borderColor[i],
                                                pointStyle: 'circle',
                                                rotation: 0
                                            };
                                        });
                                    } else {
                                        return [];
                                    }
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

</x-app-layout>
