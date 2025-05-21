<x-layouts.app :title="('Alumno')">
    <div class="flex flex-col gap-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-white">Bienvenido, {{ Auth()->user()->Alumno->Nombre }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Foto de perfil + actualización -->
            <div class="flex flex-col items-center bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-md">
                <img src="{{ asset('storage/' . (Auth::user()->fotoperfil ?? 'default.jpg')) }}" 
                     alt="Foto de Perfil" 
                     class="w-40 h-40 rounded-full object-cover shadow-lg mb-4 border-4 border-blue-500">

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @method('PUT')
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Actualizar Foto</label>
                    <input type="file" name="fotoperfil" id="fotoperfil" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('fotoperfil')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button type="submit" 
                            class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition ease-in-out duration-150">
                        Guardar Cambios
                    </button>
                </form>
            </div>

            <!-- Datos del alumno -->
            <div class="md:col-span-2 bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white text-center">Datos del Alumno</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <strong>Nombre:</strong><br>
                        {{ Auth()->user()->Alumno->Nombre }} {{ Auth()->user()->Alumno->AP }} {{ Auth()->user()->Alumno->AM }}
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <strong>CURP:</strong><br>
                        {{ Auth::user()->Alumno->CURP }}
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <strong>Correo Electrónico:</strong><br>
                        {{ Auth::user()->email }}
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <strong>Grupo:</strong><br>
                        {{ Auth::user()->grupo->Nombre }}
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-sm col-span-full">
                        <strong>Fecha de Ingreso:</strong><br>
                        {{ Auth::user()->Alumno->FIG }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Espacio para otras funcionalidades futuras -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-md mt-6">
            <h3 class="text-xl font-medium text-gray-800 dark:text-white">Próximamente</h3>
            <p class="text-gray-600 dark:text-gray-400">Aquí podrás ver tus exámenes, actividades o estadísticas.</p>
        </div>
    </div>
</x-layouts.app>
