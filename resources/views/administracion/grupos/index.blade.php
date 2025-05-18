<x-layouts.app title="Grupos">
    @if (session('mensaje'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <!-- Encabezado -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Listado de Grupos</h1>
            <a href="{{ route('administracion.grupos.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Crear Nuevo Grupo
            </a>
        </div>

        <!-- Búsqueda -->
        <form action="{{ route('administracion.grupos.buscar') }}" method="POST" class="mb-4">
            @csrf
            <div class="flex">
                <input type="text" name="grupo" placeholder="Buscar por grupo o maestro..." 
                       class="border border-gray-300 rounded-l px-4 py-2 w-full">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Tabla de grupos -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 border border-gray-200">
                <thead class="bg-gray-250">
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Maestro</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupos as $grupo)
                        <td class="py-2 px-4 border-b text-center">{{ $grupo->id }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('administracion.grupos.show', $grupo) }}" class="text-blue-500 hover:underline">
                                {{ $grupo->Nombre }}
                            </a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            @if($grupo->maestro)
                                {{ $grupo->maestro->nombre }} {{ $grupo->maestro->AP }}
                            @else
                                <span class="text-red-500">Sin asignar</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('administracion.grupos.edit', $grupo) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Editar
                                </a>
                                <form action="{{ route('administracion.grupos.destroy', $grupo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                            onclick="return confirm('¿Eliminar este grupo?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mostrar mensaje si no hay grupos -->
        @if($grupos->isEmpty())
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            No se encontraron grupos registrados.
        </div>
        @endif
    </div>
</x-layouts.app>