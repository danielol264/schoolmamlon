<x-layouts.app title="Detalle de Maestro">
    @if (session()->has('mensaje'))
        <script>
            alert("{{ session()->get('mensaje') }}");
        </script>
    @endif
    
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-cols-3">
            <div class="relative object-center content-center">
                <h1 class="text-xl">Detalles del Maestro</h1>
            </div>
            <div class="col-span-2 flex justify-end gap-4">
                <flux:button 
                    href="{{ route('administracion.maestros.edit', $maestro) }}" 
                    variant="filled" 
                    class="inline-block"
                >
                    Editar Maestro
                </flux:button>
                <form action="{{ route('administracion.maestros.destroy', $maestro) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <flux:button 
                        variant="danger" 
                        type="submit" 
                        class="inline-block"
                        onclick="return confirm('¿Estás seguro de eliminar este maestro?')"
                    >
                        Eliminar Maestro
                    </flux:button>
                </form>
                <flux:button 
                    href="{{ route('administracion.maestros.index') }}" 
                    variant="primary" 
                    class="inline-block"
                >
                    Volver a la lista
                </flux:button>
            </div>
        </div>

            <div class="relative flex rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">

                <div class="space-y-4">
                    <h2 class="text-lg font-semibold">Datos Personales</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Nombre completo:</p>
                        <p class="text-lg">{{ $maestro->Nombre }} {{ $maestro->AP }} {{ $maestro->AM }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Cédula profesional:</p>
                        <p class="font-mono">{{ $maestro->CEDULA }}</p>
                    </div>
                </div>


                <div class="space-y-4">
                    <h2 class="text-lg font-semibold">Información Profesional</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Fecha de Ingreso:</p>
                        <p>{{ \Carbon\Carbon::parse($maestro->FI)->format('d/m/Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Grupos Asignados:</p>
                        <div class="mt-2 space-y-2">
                            @forelse($maestro->grupos as $grupo)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded mr-2">
                                    {{ $grupo->Nombre }}
                                </span>
                            @empty
                                <span class="text-gray-500">Sin grupos asignados</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>