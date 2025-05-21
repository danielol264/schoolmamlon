<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        
            $this->validate();
        
            $this->ensureIsNotRateLimited();
        
            if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                RateLimiter::hit($this->throttleKey());
        
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
        
            RateLimiter::clear($this->throttleKey());
            Session::regenerate();
        
            $user = Auth::user();
        
            // Redirección según el ROL
            if ($user->ROL === 'M') {
                $this->redirect(route('maestro.dashboard'), navigate: true);
            } elseif ($user->ROL === 'A') {
                $this->redirect(route('alumno.dashboard'), navigate: true);
            } else {
                $this->redirect(route('administracion.dashboard'), navigate: true); // Fallback por si acaso
            }
        
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="min-h-screen flex items-center justify-center from-gray-900 via-gray-800 to-gray-900 p-4">
    <div class="w-full max-w-md bg-white dark:bg-gray-950 rounded-3xl shadow-lg p-8 text-gray-800 dark:text-gray-100 transition-all">


        {{-- Título y descripción --}}
        <div class="text-center mb-6">
            <h2 class="text-3xl font-semibold">Inicia sesión en tu cuenta</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Accede con tus credenciales institucionales</p>
        </div>

        {{-- Notificación de éxito --}}
        @if (session('success'))
            <div class="flex items-center justify-between bg-green-100 text-green-800 rounded-lg p-4 mb-4" id="notification">
                <p>{{ session('success') }}</p>
                <button onclick="closeNotification()" class="text-green-700 hover:text-green-900">
                    ✕
                </button>
            </div>
        @endif

        {{-- Estado de la sesión --}}
        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- Formulario --}}
        <form wire:submit="login" class="flex flex-col gap-5">
            {{-- Email --}}
            <flux:input
                wire:model="email"
                :label="('Correo electrónico')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="correo@ejemplo.com"
            />

            {{-- Contraseña --}}
            <div class="relative">
                <flux:input
                    wire:model="password"
                    :label="('Contraseña')"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                @if (Route::has('password.request'))
                    <flux:link class="absolute end-0 top-0 text-sm mt-2 text-blue-500 hover:underline" :href="route('password.request')" wire:navigate>
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </flux:link>
                @endif
            </div>

            {{-- Recuérdame --}}
            <flux:checkbox wire:model="remember" :label="('Recuérdame')" />

            {{-- Botón --}}
            <flux:button variant="primary" type="submit" class="w-full py-3">
                {{ __('Iniciar sesión') }}
            </flux:button>
        </form>

        {{-- Footer institucional --}}
        <p class="mt-8 text-center text-xs text-gray-500 dark:text-gray-600">
            © {{ date('Y') }} Universidad XYZ. Todos los derechos reservados.
        </p>

        <script>
            function closeNotification() {
                document.getElementById('notification').style.display = 'none';
            }
        </script>
    </div>
</div>
