<x-layouts.app title="Edición de Alumno">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Edición de Alumno</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <form action="{{ route('administracion.alumnos.update', $alumno) }}" method="post">
                @csrf
                @method('PUT')
                
                <flux:input type="hidden" name="id" value="{{ $alumno->id }}" />
                
                <flux:input 
                    type="text" 
                    label="Nombre del Alumno" 
                    name="nombre" 
                    placeholder="Ej. Juan Pérez" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('nombre', $alumno->Nombre) }}"
                />
                
                <flux:input 
                    type="text" 
                    label="Apellido Paterno" 
                    name="AP" 
                    placeholder="Ej. González" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('AP', $alumno->AP) }}"
                />
                
                <flux:input 
                    type="text" 
                    label="Apellido Materno" 
                    name="AM" 
                    placeholder="Ej. López" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('AM', $alumno->AM) }}"
                />
                
                <flux:input 
                    type="text" 
                    label="CURP" 
                    name="CURP" 
                    placeholder="Ej. XXXX000000HDFXXX00" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('CURP', $alumno->CURP) }}"
                />
                
                <flux:input 
                    type="date" 
                    label="Fecha de Ingreso" 
                    name="FIG" 
                    required  
                    class="w-xl mb-2"
                    value="{{ old('FIG', $alumno->FIG) }}"
                />
                
               <flux:input type="date" label="Fecha de Terminación (Opcional)" name="FTG" class="w-xl mb-2" value="{{ old('FTG', $alumno->FTG) }}"
                max="{{ now()->format('Y-m-d') }}"/>
                
                <flux:input 
                    type="submit" 
                    value="Guardar cambios" 
                    class="w-xl mb-4 bg-cyan-500 hover:bg-cyan-600"
                />
            </form>
        </div>
    </div>
</x-layouts.app>