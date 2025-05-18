@php
use App\Models\GrupoExamen;
use App\Models\Calificaciones;

$grupo = Auth()->user()->grupo;
$alumno_id = Auth()->user()->id_alumno; // Obtener ID del alumno autenticado

// 1. Obtener todos los exámenes activos del grupo
$examenesActivos = GrupoExamen::with('examen')
    ->where('id_grupo', $grupo->id)
    ->where('activo', 1)
    ->get();

// 2. Verificar calificaciones existentes para cada examen
foreach ($examenesActivos as $examenGrupo) {
    $examenGrupo->examen->ya_calificado = Calificaciones::where('id_examen', $examenGrupo->examen->id)
        ->where('id_alumno', $alumno_id)
        ->exists();
}
@endphp

<x-layouts.app :title="__('Exámenes Disponibles')">
    @if (session('success'))
        <div class="flex rounded-4xl bg-green-100 text-green-800 p-4 mb-4" id="notification">
            <p class="flex-9">{{ session('success') }}</p>
            <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
    @endif
    @if (session('error')) {{-- Corregí 'erorr' a 'error' --}}
        <div class="flex rounded-4xl bg-red-100 text-red-800 p-4 mb-4" id="notification">
            <p class="flex-9">{{ session('error') }}</p> {{-- Corregí para mostrar 'error' en lugar de 'success' --}}
            <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
    @endif

    <div class="space-y-4">
        @if($examenesActivos->count() > 0)
            @foreach($examenesActivos as $examen)
                <div class="p-4 border rounded-lg shadow-sm bg-gray-800">
                    <h3 class="text-lg font-semibold">{{ $examen->examen->Nombre }}</h3>
                    
                    <div class="mt-4 flex justify-between items-center">
                        @if($examen->examen->ya_calificado)
                            <span class="text-green-400">
                                ✔ Ya completaste este examen
                            </span>
                            <form action="{{ route('calificaciones.examen')}}" method="get">
                                @csrf
                                <input type="hidden" name="examen_id" value="{{$examen->id}}">
                                <input type="hidden" name="alumno_id" value="{{$alumno_id}}">
                                <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                                <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Ver Resultados
                                </button>
                            </form>
                        @else
                            <span class="text-yellow-400">
                                 Examen pendiente
                            </span>
                            <a href="{{route('examenes.reponder',$examen->examen)}}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                               Realizar examen
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-4 border rounded-lg bg-gray-50 text-center">
                <p class="text-gray-500">No tienes exámenes disponibles actualmente</p>
            </div>
        @endif
    </div>
</x-layouts.app>