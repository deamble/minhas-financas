<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas categorias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="">
                    @if($types->isEmpty())
                        <p class="text-center text-gray-600 mb-4">Ainda não há categorias cadastradas.</p>
                        <p class="text-center text-gray-600">
                            <a href="{{ route('type.create')}}">
                                <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-full">
                                Cadastrar <i class="fa-solid fa-plus px-1"></i>
                                </button>
                            </a>
                        </p>
                    @else
                        <div class="flex justify-between mb-4">
                            <div class="ml-auto">
                                <a href="{{ route('type.create')}}">
                                    <button class="bg-emerald-400 hover:bg-emerald-600 text-white font-bold py-1 px-3 rounded-full">
                                        Cadastrar <i class="fa-solid fa-plus px-1"></i>
                                    </button>
                                </a>
                            </div>
                        </div>

                        <table class="table-auto w-full rounded-t-lg mx-auto bg-blue-100">
                            <thead class="bg-blue-600 text-white text-center">
                                <tr class="text-center border-b-2 border border-white">
                                    <th class="text-center px-4 py-3 border border-white">Nome</th>
                                    <th class="border border-white px-4 py-3 ">Descrição</th>
                                    {{-- <th class="border border-white px-4 py-3 ">Data de criação</th> --}}
                                    <th class="border border-white px-4 py-3 ">Data de atualização</th>
                                    <th class="text-center border border-white px-4 py-3">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($types as $type)
                                    <tr class="text-center border-b-2 border border-white">
                                        <td class="text-center px-4 py-3 border border-white">{{ $type->name }}</td>
                                        <td class="border border-white px-4 py-3 ">{{ $type->description }}</td>
                                        {{-- <td class="border border-white px-4 py-3 ">{{ $type->created_at }}</td> --}}
                                        <td class="border border-white px-4 py-3 ">{{ $type->updated_at }}</td>
                                        <td class="text-center border border-white px-4 py-3 ">
                                            <a href="{{ route('type.edit', $type->id)}}" class="text-blue-400 hover:text-blue-600"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="{{ route('type.confirm_delete', $type->id)}}" class="text-red-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if (count($types) >= 20 || $types->currentPage() > 1)
                            <div class="p-3 bg-gray-100 rounded-lg mb-4">
                                {{ $types->links() }}
                            </div>
                        @endif
                    @endif
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

        @if (session('delete'))
            toastr.error("{{ session('delete') }}");
        @endif
    </script>
</x-app-layout>
