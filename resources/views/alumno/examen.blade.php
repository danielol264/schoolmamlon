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
        <div class="flex items-center justify-between rounded-xl bg-green-100 text-green-800 p-4 mb-6 shadow">
            <p class="text-sm font-medium">{{ session('success') }}</p>
            <button onclick="document.getElementById('notification').remove()" class="text-green-700 hover:text-green-900">✖</button>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center justify-between rounded-xl bg-red-100 text-red-800 p-4 mb-6 shadow">
            <p class="text-sm font-medium">{{ session('error') }}</p>
            <button onclick="document.getElementById('notification').remove()" class="text-red-700 hover:text-red-900">✖</button>
        </div>
    @endif

    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800 dark:text-white">📝 Exámenes Disponibles</h1>

    @if($examenesActivos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($examenesActivos as $examen)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg p-6 transition transform hover:scale-[1.02]">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $examen->examen->Nombre }}</h2>
                        <span class="text-sm px-3 py-1 rounded-full font-semibold 
                            {{ $examen->examen->ya_calificado ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $examen->examen->ya_calificado ? '✔ Completado' : '⏳ Pendiente' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        @if($examen->examen->ya_calificado)
                            <form action="{{ route('calificaciones.examen')}}" method="GET">
                                @csrf
                                <input type="hidden" name="examen_id" value="{{ $examen->id }}">
                                <input type="hidden" name="alumno_id" value="{{ $alumno_id }}">
                                <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    📊 Ver Resultados
                                </button>
                            </form>
                        @else
                            <a href="{{ route('examenes.reponder', $examen->examen) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                🖊 Realizar Examen
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 text-center shadow-lg mt-8">
            <p class="text-gray-600 dark:text-gray-300 text-lg">🎉 No tienes exámenes pendientes. ¡Disfruta tu tiempo libre!</p>
        </div>
    @endif
</x-layouts.app>
