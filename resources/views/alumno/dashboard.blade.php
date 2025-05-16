<x-layouts.app :title="('Alumno')">
    <h1 class="text-3xl font-bold mb-6">Bienvenido, Alumno</h1>

<div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="mb-4">
            <img src="{{ asset('storage/' . (Auth::user()->fotoperfil ?? 'default.jpg')) }}" alt="Foto de Perfil" class="w-78 h-78 rounded-lg object-cover mr-4">
    
            <div class="mb-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">  
                    <input type="file" name="fotoperfil" id="fotoperfil" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                    @error('fotoperfil')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Actualizar Foto
                </button>
                </form>   
            </div>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <table class="table-auto w-full text-big text-left text-white-500 dark:text-gray-400"> 
                <tr>
                    <th colspan="1" class="text-center">Datos del Alumno</th>
                </tr>
                <tr>
                    <th class="border">Nombre: {{Auth()->user()->Alumno->Nombre}} {{Auth()->user()->Alumno->AP}} {{Auth()->user()->Alumno->AM}}</th>
                </tr>
                <tr>
                    <th class="border">CURP: {{ Auth::user()->Alumno->CURP}}</th>
                </tr>
                <tr>
                    <th class="border">Correo: {{ Auth::user()->email }}</th>
                </tr>
                <tr>
                    <th class="border">Grupo: {{ Auth::user()->grupo->Nombre }} </th>
                </tr>
                <tr>
                    <th class="border">Fecha de Ingreso: {{ Auth::user()->Alumno->FIG }}</th>
                </tr>        
            </table>
        </div>
            
    </div>
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    
    </div>
</div>
</x-layouts.app>