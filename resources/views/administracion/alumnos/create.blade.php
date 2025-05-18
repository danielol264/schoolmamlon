<x-layouts.app title="Alta de Alumnos">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Alta de Alumnos</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <form action="{{ route('administracion.alumnos.store') }}" method="post" class="w-full">
                @csrf
                
                <!-- Nombre -->
                <flux:input type="text" label="Nombre del Alumno" 
                    name="nombre" placeholder="Ej. Juan Pérez" 
                    required class="w-full mb-4"/>
                
                <!-- Apellido Paterno -->
                <flux:input type="text" label="Apellido Paterno" 
                    name="AP" placeholder="Ej. González" 
                    required class="w-full mb-4"/>
                
                <!-- Apellido Materno -->
                <flux:input type="text" label="Apellido Materno" 
                    name="AM" placeholder="Ej. López" 
                    required class="w-full mb-4"/>
                
                <!-- CURP -->
                <flux:input type="text" label="CURP" 
                    name="CURP" placeholder="Ej. XXXX000000HDFXXX00" 
                    required class="w-full mb-4"/>
                
                <!-- Fecha de Ingreso (FIG) -->
                <flux:input type="date" label="Fecha de Ingreso" 
                    name="FIG" required class="w-full mb-4" max="{{ now()->format('Y-m-d') }}"/>
                
                <!-- Fecha de Terminación (FTG) -->
                <flux:input type="date" label="Fecha de Terminación (Opcional)" name="FTG"  
                class="w-full mb-4"
                max="{{ now()->format('Y-m-d') }}"/>
                
                <!-- Botón de envío -->
                <flux:input type="submit" value="Guardar Alumno" 
                    class="w-full mb-4 bg-cyan-500 hover:bg-cyan-600 text-white py-2 px-4 rounded"/>
            </form>
        </div>
    </div>
</x-layouts.app>