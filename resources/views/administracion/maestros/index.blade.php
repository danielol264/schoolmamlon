<x-layouts.app title="Maestros">
    @if (session()->has('mensaje'))
        <div class="fixed top-4 right-4 z-50">
            <div class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg animate-fade-in">
                {{ session()->get('mensaje') }}
            </div>
        </div>
    @endif

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 border border-gray-100 dark:border-gray-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Gestión de Maestros</h1>
                    <p class="text-gray-500 dark:text-gray-400">Listado completo de docentes registrados</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Search Form - CORRECCIÓN: método GET -->
                    <form action="{{ route('administracion.maestros.buscar') }}" method="POST" class="flex-1 min-w-[250px]">
                        @csrf

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="maestro" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                placeholder="Buscar por nombre, apellido o cédula"
                                value="{{ request('maestro') }}"
                                required
                            >
                        </div>
                    </form>
                    
                    <!-- Add Button -->
                    <a href="{{ route('administracion.maestros.create')}}" 
                       class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nuevo Maestro
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-4">ID</th>
                            <th scope="col" class="px-6 py-4">Apellidos</th>
                            <th scope="col" class="px-6 py-4">Cédula</th>
                            <th scope="col" class="px-6 py-4">Grupos</th>
                            <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($maestros as $maestro)
                        <tr class="bg-white hover:bg-gray-50 dark:hover:bg-gray-700 dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $maestro->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $maestro->AP }} {{ $maestro->AM }}</div>
                                <div class="text-sm text-gray-500">{{ $maestro->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 font-mono">
                                <a href="{{ route('administracion.maestros.show', $maestro) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                    {{ $maestro->CEDULA }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if($maestro->grupos_count > 0)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-200">
                                        {{ $maestro->grupos_count }} grupos
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                        Sin grupos
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('administracion.maestros.edit', $maestro) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('administracion.maestros.destroy', $maestro) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                onclick="return confirm('¿Estás seguro de eliminar este maestro?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                @if(request()->has('maestro'))
                                    No se encontraron maestros con "{{ request('maestro') }}"
                                @else
                                    No hay maestros registrados
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (session()->has('mensaje'))
        <script>
            setTimeout(() => {
                document.querySelector('.fixed.top-4.right-4').remove();
            }, 3000);
        </script>
    @endif
</x-layouts.app>