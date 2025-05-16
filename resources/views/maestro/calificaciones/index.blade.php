@php
    use App\Models\Grupo;
    $grupoMaestro=[];
    $grupos = Grupo::with('alumnos','examenes')->get();
    foreach($grupos as $grupo){
        if($grupo->id_maestro==Auth()->user()->id){
            $grupoMaestro[$grupo->id]=$grupo;
        }
            
    }

@endphp
<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Sección de bienvenida -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700"></div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700"></div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center">
                <span class="text-lg font-medium">Bienvenido, {{ Auth()->user()->name }}</span>
            </div>
        </div>

        <!-- Sección principal de grupos -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Lista de exámenes por grupo -->
                <div class="overflow-auto">
                    <h2 class="text-xl font-bold mb-4">Exámenes por Grupo</h2>
                    @foreach($grupoMaestro as $grupo)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-2">{{ $grupo->Nombre }}</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-6 py-3">Examen</th>
                                        <th class="px-6 py-3">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grupo->examenes as $examen)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $examen->Nombre }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('grupo.examen') }}" method="get">
                                                @csrf
                                                <input type="hidden" name="examen_id" value="{{ $examen->id }}">
                                                <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    Ver examen
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Lista de alumnos por grupo (dropdowns) -->
                <div class="overflow-auto">
                    <h2 class="text-xl font-bold mb-4">Alumnos por Grupo</h2>
                    @foreach ($grupoMaestro as $grupo)
                    <div class="mb-6">
                        <button id="dropdownButton-{{ $grupo->id }}" data-dropdown-toggle="dropdown-{{ $grupo->id }}" 
                            class="w-full flex justify-between items-center p-4 text-white bg-blue-700 hover:bg-blue-800 rounded-lg">
                            <span>{{ $grupo->Nombre }}</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div id="dropdown-{{ $grupo->id }}" class="hidden bg-white rounded-lg shadow-md dark:bg-gray-700 mt-2">
                            <ul class="py-2">
                                <li class="px-4 py-2 text-gray-500 dark:text-gray-400 font-semibold">Alumnos:</li>
                                @foreach ($grupo->alumnos as $alumno)
                                <li class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <form action="{{ route('grupo.alumno') }}" method="get" class="w-full">
                                        @csrf
                                        <input type="hidden" name="alumno_id" value="{{ $alumno->alumno->id }}">
                                        <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                        <button type="submit" class="w-full text-left px-4 py-2">
                                            {{ $alumno->alumno->id }} - {{ $alumno->alumno->Nombre }} {{ $alumno->alumno->AP }} {{ $alumno->alumno->AM }}
                                        </button>
                                    </form>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>