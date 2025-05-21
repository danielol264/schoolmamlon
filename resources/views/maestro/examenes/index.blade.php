<x-layouts.app :title="__('Menú del Maestro')">
    {{-- Notificaciones --}}
    @if (session('success'))
        <div id="notification" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex justify-between items-center">
            <p>{{ session('success') }}</p>
            <button onclick="closeNotification()" class="text-green-700 hover:text-green-500">✖</button>
        </div>
    @endif

    @if (session('error'))
        <div id="notification" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex justify-between items-center">
            <p>{{ session('error') }}</p>
            <button onclick="closeNotification()" class="text-red-700 hover:text-red-500">✖</button>
        </div>
    @endif

    {{-- Cabecera --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Exámenes creados</h1>
            <p class="text-sm text-gray-500">Bienvenido, {{ auth()->user()->maestro->Nombre }}</p>
        </div>
        <form action="{{ route('examenes.create') }}" method="GET">
            @csrf
            <input type="hidden" name="maestro" value="{{ Auth()->User()->id_maestro }}" />
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                + Crear Examen
            </button>
        </form>
    </div>

    {{-- Tabla de exámenes --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-xl">
        @if(!$examenes->isEmpty())
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">ID</th>
                        <th class="px-6 py-3 text-left font-medium">Nombre del examen</th>
                        <th class="px-6 py-3 text-left font-medium">Grupo</th>
                        <th class="px-6 py-3 text-left font-medium">Creador</th>
                        <th class="px-6 py-3 text-left font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($examenes as $examen)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-4">{{ $examen->id }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $examen->Nombre }}</td>
                            <td class="px-6 py-4">{{ $examen->grupos->first()->Nombre ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $examen->maestro->Nombre }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('examenes.show',$examen->id) }}" class="text-blue-600 hover:underline">Ver</a>
                                    <a href="{{ route('examenes.edit',$examen->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                                    <form action="{{ route('examenes.destroy', $examen->id) }}" method="POST" onsubmit="return confirmarEliminar();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                No hay exámenes registrados actualmente.
            </div>
        @endif
    </div>

    <script>
        function confirmarEliminar() {
            return confirm('¿Estás seguro de que deseas eliminar este examen? Esta acción no se puede deshacer.');
        }
        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }
    </script>
</x-layouts.app>
