<x-layouts.app title="Detalle de Alumno">
    @if (session()->has('mensaje'))
        <script>
            alert("{{ session()->get('mensaje') }}");
        </script>
    @endif
    
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Encabezado con botones -->
        <div class="grid grid-cols-3">
            <div class="relative object-center content-center">
                <h1 class="text-xl">Detalles del Alumno</h1>
            </div>
            <div class="col-span-2 flex justify-end gap-4">
                <flux:button 
                    href="{{ route('administracion.alumnos.edit', $alumno) }}" 
                    variant="filled" 
                    class="inline-block"
                >
                    Editar Alumno
                </flux:button>
                <form action="{{ route('administracion.alumnos.destroy', $alumno) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <flux:button 
                        variant="danger" 
                        type="submit" 
                        class="inline-block"
                        onclick="return confirm('¿Estás seguro de eliminar este alumno?')"
                    >
                        Eliminar Alumno
                    </flux:button>
                </form>
                <flux:button 
                    href="{{ route('administracion.alumnos.index') }}" 
                    variant="primary" 
                    class="inline-block"
                >
                    Volver a la lista
                </flux:button>
            </div>
        </div>

        <!-- Información del Alumno -->
        <div class="relative flex rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                <!-- Columna 1: Datos Personales -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold">Datos Personales</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Nombre completo:</p>
                        <p class="text-lg">{{ $alumno->Nombre }} {{ $alumno->AP }} {{ $alumno->AM }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">CURP:</p>
                        <p class="font-mono">{{ $alumno->CURP }}</p>
                    </div>
                </div>

                <!-- Columna 2: Información Académica -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold">Información Académica</h2>
                    
                    <div>
                        <p class="text-sm text-gray-500">Fecha de Ingreso (FIG):</p>
                        <p>{{ \Carbon\Carbon::parse($alumno->FIG)->format('d/m/Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Fecha de Terminación (FTG):</p>
                        <p>
                            @if($alumno->FTG)
                                {{ \Carbon\Carbon::parse($alumno->FTG)->format('d/m/Y') }}
                            @else
                                <span class="text-green-600 font-semibold">EN CURSO</span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Grupo:</p>
                        <p>{{ $alumno->grupo->Nombre ?? 'Sin grupo asignado' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>