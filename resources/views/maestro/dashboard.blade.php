<x-layouts.app :title="__('Menú del Maestro')">
    @php
        $gruposConExamenes = auth()->user()->maestro->grupos()->with('examenes')->get();
    @endphp

    <div class="px-4 py-8 space-y-6">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white text-center mb-6">📚 Bienvenido, {{ auth()->user()->maestro->Nombre }}</h1>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Información del maestro --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold text-blue-600 dark:text-blue-400 mb-4">👨‍🏫 Información del Maestro</h2>
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Nombre</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->maestro->Nombre }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Apellidos</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->maestro->AP }} {{ auth()->user()->maestro->AM }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Fecha de Ingreso</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->maestro->FI }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Cédula</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ auth()->user()->maestro->CEDULA }}</p>
                    </div>
                </div>
            </div>

            {{-- Panel dinámico de grupos --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold text-blue-600 dark:text-blue-400 mb-4">🧑‍💼 Grupos y Exámenes</h2>
                @foreach ($gruposConExamenes as $grupo)
                    <div class="mb-4">
                        <button id="dropdown-button-{{ $grupo->id }}" data-dropdown-toggle="dropdown-{{ $grupo->id }}" type="button"
                            class="w-full text-left px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition-all flex justify-between items-center">
                            {{ $grupo->Nombre }}
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="dropdown-{{ $grupo->id }}" class="hidden mt-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
                            <ul class="text-sm text-gray-700 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($grupo->examenes as $examen)
                                    <li>
                                        <a href="{{ route('examenes.show', $examen->id) }}"
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                            📄 {{ $examen->Nombre }}
                                        </a>
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-gray-400 italic">No hay exámenes registrados</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Flowbite Script --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-layouts.app>
