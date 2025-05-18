<x-layouts.app title="Edición de Grupo">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Edición de Grupo</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <form action="{{ route('administracion.grupos.update', $grupo) }}" method="post">
                @csrf
                @method('PUT')
                
                <flux:input type="hidden" name="id" value="{{ $grupo->id }}" />

                
                <flux:input 
                    type="text" 
                    label="Nombre del Grupo" 
                    name="nombre" 
                    placeholder="Ej. Grupo 101" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('nombre', $grupo->Nombre) }}"
                />
                
                <div class="w-xl mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Maestro asignado</label>
                    <select name="maestro_id" required
                        class="block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 py-2 px-3 shadow-sm focus:outline-none focus:ring-cyan-500 focus:border-cyan-500">
                        <option value="">Seleccione un maestro</option>
                        @foreach($maestros as $maestro)
                        <option value="{{ $maestro->id }}" {{ old('maestro_id', $grupo->maestro_id) == $maestro->id ? 'selected' : '' }}>
                                {{ $maestro->Nombre }} {{ $maestro->AP }} {{ $maestro->AM }}
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <flux:input 
                    type="submit" 
                    value="Guardar cambios" 
                    class="w-xl mb-4 bg-cyan-500 hover:bg-cyan-600"
                />
            </form>
        </div>
    </div>
</x-layouts.app>