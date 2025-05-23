<?php
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $ROL = '';
    public ?int $id_grupo = null;
    public ?int $id_maestro = null;
    public ?int $id_alumno = null;
    /**
     * Handle an incoming registration request.
     */
    protected function rules()
    {
        $baseRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ROL' => ['required', 'in:A,M,G'], 
        ];
        if ($this->ROL === 'A') { 
            $baseRules['id_grupo'] = ['required', 'integer'];
            $baseRules['id_alumno'] = ['required', 'integer'];
        } elseif ($this->ROL === 'M') { 
            $baseRules['id_maestro'] = ['required', 'integer'];
        }
        return $baseRules;
    }
     public function register()
{
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);
    
    $rolTexto = match($validated['ROL']) {
        'A' => 'Alumno',
        'M' => 'Maestro',
        'G' => 'Administrador',
    };

    try {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'ROL' => $validated['ROL'],
            'id_grupo' => $validated['id_grupo'] ?? null,
            'id_alumno' => $validated['id_alumno'] ?? null,
            'id_maestro' => $validated['id_maestro'] ?? null,
        ]);

        session()->flash('success', "Registro exitoso! (Rol: $rolTexto). Por favor inicia sesión.");
        return redirect()->route('administracion.dashboard');
    } catch (\Exception $e) {
        session()->flash('error', "Error al registrar el $rolTexto ");
        return redirect()->route('register');
    }
}
}
 ?>
<x-layouts.app title="Registrar">
    
<div class="flex flex-col gap-6">
    @if (session('error'))
        <div class="flex rounded-4xl bg-red-100 text-red-800 p-4 mb-4" id="notification">
             <p class="flex-9">{{ session('success') }}</p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
    @endif
        <div class="hidden rounded-4xl bg-red-100 text-red-800 p-4 mb-4" id="notification">
             <p class="flex-9" id="texto"></p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
    <x-auth-header :title="('Create an account')" :description="('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register"  onsubmit="return validate()" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="('Password')"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="('Confirm password')"
        />

        <!-- Role -->
        <div>
            <label for="role-select" class="block text-sm font-medium text-gray-700">Rol</label>
            <select 
                name="ROL" 
                id="role-select"
                class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
                <option value="">Selecciona un rol</option>
                <option value="A">Alumno</option>
                <option value="M">Maestro</option>
                <option value="G">Administrador</option>
            </select>
        </div>
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

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
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

</div>
</x-layouts.app>