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
    <div>
            <label for="role-select" class="block text-sm font-medium text-gray-700">Rol</label>
            <select 
                name="ROL" 
                id="role-select"
                class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
            <option value="{{$user->ROL}}">@switch($user->ROL)
                @case('A')
                    Alumno
                    @break
                @case('M')
                    Maestro
                    @break
                @case('G')
                    Administrador
                    @break
                @default
                    Rol no definido
                @endswitch
            </option>
            <option value="A" {{ $user->ROL == 'A' ? 'selected' : '' }}>Alumno</option>
            <option value="M" {{ $user->ROL == 'M' ? 'selected' : '' }}>Maestro</option>
            <option value="G" {{ $user->ROL == 'G' ? 'selected' : '' }}>Administrador</option>
           </select>
        </div>

    <!-- Campos condicionales -->
    <div id="role-dependent-section">
    <!-- Maestro -->
    <div id="maestro-section" class="hidden">
                <label for="maestro-select" class="block text-sm font-medium text-gray-700">Maestro</label>
                <select 
                    name="id_maestro" 
                    id="maestro-select"
                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >
                    <option value="">-- Seleccione maestro --</option>
                    @foreach($maestros as $maestro)
                        <option value="{{ $maestro->id }}">{{ $maestro->Nombre }}</option>
                    @endforeach
                </select>
    </div>

    <!-- Alumno -->
    <div id="alumno-section" class="hidden">
    <label for="alumno-select" class="block text-sm font-medium text-gray-700">Alumno</label>
                <select 
                    name="id_alumno" 
                    id="alumno-select"
                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >
                    <option value="">-- Seleccione alumno --</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}">{{ $alumno->Nombre }}</option>
                    @endforeach
                </select>

                <label for="grupo-select" class="block mt-4 text-sm font-medium text-gray-700">Grupo</label>
                <select 
                    name="id_grupo" 
                    id="grupo-select"
                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >
                    <option value="">-- Seleccione grupo --</option>
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}">{{ $grupo->Nombre }}</option>
                    @endforeach
                </select>
    </div>
</div>

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
                :label="('New password')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="('Confirm Password')"
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
    <script>
        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }
      function validate() {
            const role = document.getElementById('role-select').value;
            const texto = document.getElementById('texto');
            const notification = document.getElementById('notification');
            if (!role) {
                texto.innerText = 'Por favor selecciona un rol.';
                notification.classList.remove('hidden');
                notification.classList.add('flex');
                return false;
            }

            if (role === 'A') {
                const alumno = document.getElementById('alumno-select').value;
                const grupo = document.getElementById('grupo-select').value;
                
                if (!alumno) {
                    texto.innerText = 'Por favor selecciona un alumno.';
                    notification.classList.remove('hidden');
                    notification.classList.add('flex');
                    return false;
                }
                if (!grupo) {
                    texto.innerText = 'Por favor selecciona un grupo.';
                    notification.classList.remove('hidden');
                    notification.classList.add('flex'); 
                    return false;
                }
            } 
            else if (role === 'M') {
                const maestro = document.getElementById('maestro-select').value;
                if (!maestro) {
                    texto.innerText = 'Por favor selecciona un maestro.';
                    notification.classList.remove('hidden');
                    notification.classList.add('flex');
                    return false;
                }
            }

            return true;
        }
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role-select');
        const alumnoSection = document.getElementById('alumno-section');
        const maestroSection = document.getElementById('maestro-section');

        function toggleRoleSections(role) {
            alumnoSection.classList.add('hidden');
            maestroSection.classList.add('hidden');

            if (role === 'A') {
                alumnoSection.classList.remove('hidden');
            } else if (role === 'M') {
                maestroSection.classList.remove('hidden');
            }
        }

        // Lógica para actualización inicial
        toggleRoleSections(roleSelect.value);

        // Evento cuando se cambia el rol
        roleSelect.addEventListener('change', function () {
            toggleRoleSections(this.value);
        });
    });
</script>

</x-layouts.app>