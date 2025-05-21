<x-layouts.app title="Edición de Alumno">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative">
                <h1 class="text-xl">Edición de Alumno</h1>
            </div>
        </div>
        
        <div class="relative flex rounded-xl border shadow-lg items-center border-neutral-200 dark:border-neutral-700 px-4">
            <div>
            <form action="{{ route('user.update', $user) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Campos básicos -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Nombre del usuario
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
               id="name" name="name" type="text" placeholder="Ej. Juan Pérez" 
               value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
            Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
               id="email" name="email" type="email" placeholder="Ej. usuario@dominio.com" 
               value="{{ old('email', $user->email) }}" required>
    </div>

    <!-- Selector de Rol -->
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="ROL">
            Rol
        </label>
        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                id="ROL" name="ROL">
            <option value="A" {{ $user->ROL == 'A' ? 'selected' : '' }}>Alumno</option>
            <option value="M" {{ $user->ROL == 'M' ? 'selected' : '' }}>Maestro</option>
            <option value="G" {{ $user->ROL == 'G' ? 'selected' : '' }}>Administrador</option>
        </select>
    </div>

    <!-- Campos condicionales -->
    @if($user->ROL == 'M')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_maestro">
                Maestro
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="id_maestro" name="id_maestro">
                    <option value="{{ $user->id_maestro }}" >
                        {{ $user->maestro->Nombre }} {{ $user->maestro->AP }} {{ $user->maestro->AM }}
                    </option>
                @foreach($maestros as $maestro)
                    <option value="{{ $maestro->id }}" >
                        {{ $maestro->Nombre }} {{ $maestro->AP }} {{ $maestro->AM }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    @if($user->ROL == 'A')
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_alumno">
                Alumno
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="id_alumno" name="id_alumno">
                    <option value="{{ $user->id_alumno }}" >
                        {{ $user->alumno->Nombre }} {{ $user->alumno->AP }} {{ $user->alumno->AM }}
                    </option>
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">
                        {{ $alumno->Nombre }} {{ $alumno->AP }} {{ $alumno->AM }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_grupo">
                Grupo
            </label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="id_grupo" name="id_grupo">
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id }}" {{ $user->id_grupo == $grupo->id ? 'selected' : '' }}>
                        {{ $grupo->Nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    <!-- Botón de envío -->
    <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                type="submit">
            Actualizar Usuario
        </button>
    </div>
</form>
            </div>
            <div>
                
            <form action="{{route('administracion.actualizarContraseña',$user)}}" class="mt-6 space-y-6">
            <flux:input
                wire:model="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                
            </div>
        </form>
            </div>
        </div>
    </div>
</x-layouts.app>