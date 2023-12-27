<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todos os usuários cadastrados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-600">
                    <table class="table-auto w-full rounded-t-lg mx-auto bg-blue-100">
                        <thead class="bg-blue-600 text-white text-center">
                            <tr class="text-center border-b-2 border border-white">
                                <th class="px-4 py-3 border border-white">Nível</th>
                                <th class="p-2 px-4 py-3 border border-white">Nome</th>
                                <th class="px-4 py-3 border border-white">E-mail</th>
                                <th class="px-4 py-3 border border-white">Data de cadastro</th>
                                <th class="px-4 py-3 border border-white">Data de atualização</th>
                                @can('level')
                                    <th class="px-4 py-3">Ações</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center border-b-2 border-white">

                                    @if ($user->level == 'admin')
                                        <td class="px-4 py-3 border border-white">
                                            {{-- <i class="fa-solid fa-user-gear text-orange-500"></i> --}}
                                            <span class="bg-orange-500 text-white me-2 px-3 py-1 rounded-full dark:bg-orange-500 dark:text-white">Administrador</span>
                                        </td>
                                        <td class="text-orange-500 px-4 py-3 border border-white">{{ $user->name }}</td>
                                        <td class="text-orange-500 px-4 py-3 border border-white">{{ $user->email }}</td>
                                        <td class="text-orange-500 px-4 py-3 border border-white">{{ $user->updated_at }}</td>
                                        <td class="text-orange-500 px-4 py-3 border border-white">{{ $user->updated_at }}</td>
                                    @else
                                        <td class="px-4 py-3 border border-white">
                                            {{-- <i class="fa-solid fa-user text-blue-500"></i> --}}
                                            <span class="bg-blue-500 text-white me-2 px-3 py-1 rounded-full dark:bg-blue-500 dark:text-white">Usuário</span>
                                        </td>
                                        <td class="px-4 py-3 border border-white">{{ $user->name }}</td>
                                        <td class="px-4 py-3 border border-white">{{ $user->email }}</td>
                                        <td class="px-4 py-3 border border-white">{{ $user->created_at }}</td>
                                        <td class="px-4 py-3 border border-white">{{ $user->updated_at }}</td>
                                    @endif

                                    @can('level')
                                        <td class="text-center px-4 py-3">
                                            <a href="{{ route('user.edit', $user->id)}}" class="text-blue-400 hover:text-blue-600"><i class="fa-solid fa-pen-to-square"></i></a>
                                            {{-- <a href="{{ route('user.confirm_delete', $user->id)}}" class="text-red-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></a> --}}
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (count($users) >= 20 || $users->currentPage() > 1)
                    <div class="p-2 rounded-lg">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
