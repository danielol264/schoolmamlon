<x-layouts.app title="Alta de Maestros">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Alta de Maestros</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <form action="{{ route('administracion.maestros.store') }}" method="post" class="w-full">
                @csrf
        
                <flux:input type="text" label="Nombre del Maestro" 
                    name="nombre" placeholder="Ej. Carlos Méndez" 
                    required class="w-full mb-4"/>
                
                <flux:input type="text" label="Apellido Paterno" 
                    name="AP" placeholder="Ej. González" 
                    required class="w-full mb-4"/>
                
                
                <flux:input type="text" label="Apellido Materno" 
                    name="AM" placeholder="Ej. López" 
                    required class="w-full mb-4"/>
                
                
                <flux:input type="text" label="Cédula Profesional" 
                    name="CEDULA" placeholder="Ej. 12345678" 
                    required class="w-full mb-4"
                    pattern="[0-9]{6,8}"
                    title="La cédula debe contener entre 6 y 8 dígitos"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"/>
                
                
                <flux:input type="date" label="Fecha de Ingreso" 
                    name="FI" 
                    max="{{ now()->toDateString('Y-m-d') }}"
                    required class="w-full mb-4"/>
                
                
                <flux:input type="submit" value="Guardar Maestro" 
                    class="w-full mb-4 bg-cyan-500 hover:bg-cyan-600 text-white py-2 px-4 rounded"/>
            </form>
        </div>
        
        
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        
        @if(session('mensaje'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('mensaje') }}
        </div>
        @endif
    </div>
</x-layouts.app>