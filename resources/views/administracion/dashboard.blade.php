@php
    use App\Models\User;
    $users = User::all();
@endphp

<x-layouts.app :title="__('Dashboard')">
    @if (session('success'))
        <div class="flex rounded-4xl bg-green-100 text-green-800 p-4 mb-4" id="notification">
             <p class="flex-9">{{ session('success') }}</p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
    @endif
    @if (session('error'))
        <div class="flex rounded-4xl bg-red-100 text-red-800 p-4 mb-4" id="notification">
             <p class="flex-9">{{ session('error') }}</p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
    @endif
    
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-20 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="p-4">
                <input type="text" id="searchInput" placeholder="Buscar por nombre..." 
                       class="w-full md:w-64 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       onkeyup="filterTable()">
                <a href="{{ route('administracion.register') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Register
                </a>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="ov
                
                
                
                erflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="usersTable">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">ROL</th>
                                <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="tableBody">
                            @foreach($users as $user)
                                <tr class="bg-white hover:bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4 font-mono">{{ $user->ROL }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{route('user.edit',$user)}}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{route('user.destroy',$user)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('usersTable');
            const tr = table.getElementsByTagName('tr');

            // Recorrer todas las filas de la tabla, empezando desde el índice 1 para omitir los encabezados
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[0]; // Columna del nombre
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }       
            }
        }

        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }
    </script>
</x-layouts.app>