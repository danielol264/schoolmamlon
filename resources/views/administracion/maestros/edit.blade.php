<x-layouts.app title="Editar Maestro">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Edición de Maestro</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <form action="{{ route('administracion.maestros.update', $maestro) }}" method="post">
                @csrf
                @method('PUT')
                
                <flux:input type="hidden" name="id" value="{{ $maestro->id }}" />
                
                <flux:input 
                    type="text" 
                    label="Nombre del Maestro" 
                    name="nombre" 
                    placeholder="Ej. Carlos Méndez" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('nombre', $maestro->nombre) }}"
                />
                
                <flux:input 
                    type="text" 
                    label="Apellido Paterno" 
                    name="AP" 
                    placeholder="Ej. González" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('AP', $maestro->AP) }}"
                />
                
                <flux:input 
                    type="text" 
                    label="Apellido Materno" 
                    name="AM" 
                    placeholder="Ej. López" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('AM', $maestro->AM) }}"
                />
                
                <flux:input 
                    type="text" 
                    label="Cédula Profesional" 
                    name="CEDULA" 
                    placeholder="Ej. 12345678" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('CEDULA', $maestro->CEDULA) }}"
                />
                
                <flux:input 
                    type="date" 
                    label="Fecha de Ingreso" 
                    name="FI" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('FI', $maestro->FI) }}"
                />
                
                <flux:input 
                    type="submit" 
                    value="Guardar Cambios" 
                    class="w-xl mb-4 bg-cyan-500 hover:bg-cyan-600"
                />
            </form>
        </div>
    </div>
</x-layouts.app>