<x-layouts.app title="Crear Nuevo Grupo">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Creación de Nuevo Grupo</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <form action="{{ route('administracion.grupos.store') }}" method="post" class="w-full">
                @csrf
                
                <!-- Nombre del Grupo -->
                <flux:input 
                    type="text" 
                    label="Nombre del Grupo" 
                    name="Nombre" 
                    placeholder="Ej. Grupo 3°A" 
                    required  
                    class="w-full mb-4"
                />
                
                <!-- Selección de Maestro -->
                <flux:select 
                    name="id_maestro" 
                    label="Maestro Responsable" 
                    required
                    class="w-full mb-4"
                >
                    <option value="">Seleccione un maestro</option>
                    @foreach($maestros as $maestro)
                        <option value="{{ $maestro->id }}">
                            {{ $maestro->nombre }} {{ $maestro->AP }} {{ $maestro->AM }} - {{ $maestro->CEDULA }}
                        </option>
                    @endforeach
                </flux:select>                

                <flux:input 
                    type="submit" 
                    value="Guardar Grupo" 
                    class="w-full mb-4 bg-cyan-500 hover:bg-cyan-600"
                />
            </form>
        </div>
    </div>
</x-layouts.app>