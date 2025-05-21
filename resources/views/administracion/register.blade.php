<x-layouts.app title="Registro de Alumno">
    <div class="min-h-screen flex items-center justify-center  from-gray-900 via-gray-800 to-gray-900 p-4">
        <div class="w-full max-w-2xl bg-white dark:bg-gray-950 rounded-3xl shadow-lg p-8 text-gray-800 dark:text-gray-100 transition-all">

            {{-- Título y descripción --}}
            <div class="text-center mb-6">
                <h2 class="text-3xl font-semibold">Crea una cuenta</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                    Escribe todos los detalles de la cuenta y proporciona las credenciales al usuario.
                </p>
            </div>

            {{-- Notificaciones de error --}}
            @if (session('error'))
                <div class="flex items-center justify-between bg-red-100 text-red-800 rounded-lg p-4 mb-4" id="notification">
                    <p>{{ session('error') }}</p>
                    <button onclick="closeNotification()" class="text-red-700 hover:text-red-900">✕</button>
                </div>
            @endif
            <div class="hidden items-center justify-between bg-red-100 text-red-800 rounded-lg p-4 mb-4" id="notification">
                <p id="texto" class="text-sm"></p>
                <button onclick="closeNotification()" class="text-red-700 hover:text-red-900">✕</button>
            </div>

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form action="{{ route('user.store') }}" onsubmit="return validate()" method="POST" class="flex flex-col gap-5">
                @csrf
                @method('POST')

                {{-- Nombre --}}
                <flux:input
                    wire:model="name"
                    :label="('Nombre completo')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nombre completo"
                />

                {{-- Correo --}}
                <flux:input
                    wire:model="email"
                    :label="('Correo electrónico')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="correo@ejemplo.com"
                />

                {{-- Contraseña --}}
                <flux:input
                    wire:model="password"
                    :label="('Contraseña')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />

                {{-- Confirmar contraseña --}}
                <flux:input
                    wire:model="password_confirmation"
                    :label="('Confirmar contraseña')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />

                {{-- ROL --}}
                <div>
                    <label for="role-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                    <select 
                        name="ROL" 
                        id="role-select"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">Selecciona un rol</option>
                        <option value="A">Alumno</option>
                        <option value="M">Maestro</option>
                        <option value="G">Administrador</option>
                    </select>
                </div>

                {{-- Sección dinámica según rol --}}
                <div id="role-dependent-section" class="flex flex-col gap-5">

                    {{-- Maestro --}}
                    <div id="maestro-section" class="hidden">
                        <label for="maestro-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona maestro</label>
                        <select 
                            name="id_maestro" 
                            id="maestro-select"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm"
                        >
                            <option value="">-- Selecciona maestro --</option>
                            @foreach($maestros as $maestro)
                                <option value="{{ $maestro->id }}">{{ $maestro->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Alumno --}}
                    <div id="alumno-section" class="hidden">
                        <label for="alumno-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona alumno</label>
                        <select 
                            name="id_alumno" 
                            id="alumno-select"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm"
                        >
                            <option value="">-- Selecciona alumno --</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">{{ $alumno->Nombre }}</option>
                            @endforeach
                        </select>

                        <label for="grupo-select" class="block mt-4 text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona grupo</label>
                        <select 
                            name="id_grupo" 
                            id="grupo-select"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm"
                        >
                            <option value="">-- Selecciona grupo --</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Botón --}}
                <flux:button type="submit" variant="primary" class="w-full py-3">
                    {{ __('Crear cuenta') }}
                </flux:button>
            </form>

            <p class="mt-8 text-center text-xs text-gray-500 dark:text-gray-600">
                © {{ date('Y') }} Universidad capitanaso. Todos los derechos reservados.
            </p>

            <script>
                function closeNotification() {
                    document.getElementById('notification').classList.add('hidden');
                }

                function validate() {
                    const role = document.getElementById('role-select').value;
                    const texto = document.getElementById('texto');
                    const notification = document.getElementById('notification');

                    if (!role) {
                        texto.innerText = 'Por favor selecciona un rol.';
                        notification.classList.remove('hidden');
                        return false;
                    }

                    if (role === 'A') {
                        const alumno = document.getElementById('alumno-select').value;
                        const grupo = document.getElementById('grupo-select').value;

                        if (!alumno) {
                            texto.innerText = 'Por favor selecciona un alumno.';
                            notification.classList.remove('hidden');
                            return false;
                        }
                        if (!grupo) {
                            texto.innerText = 'Por favor selecciona un grupo.';
                            notification.classList.remove('hidden');
                            return false;
                        }
                    } else if (role === 'M') {
                        const maestro = document.getElementById('maestro-select').value;
                        if (!maestro) {
                            texto.innerText = 'Por favor selecciona un maestro.';
                            notification.classList.remove('hidden');
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

                    toggleRoleSections(roleSelect.value);

                    roleSelect.addEventListener('change', function () {
                        toggleRoleSections(this.value);
                    });
                });
            </script>
        </div>
    </div>
</x-layouts.app>
