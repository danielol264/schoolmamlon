@php
use App\Models\GrupoExamen;

    $grupo = Auth()->user()->grupo;
    $examenesActivos = grupoExamen::with('examen')
        ->where('id_grupo', $grupo->id)
        ->where('activo',1)
        ->get();
@endphp

<x-layouts.app :title="__('Exámenes Disponibles')">
    <div class="space-y-4">
        @if($examenesActivos->count() > 0)
            @foreach($examenesActivos as $examen)
                <div class="p-4 border rounded-lg shadow-sm bg-gray-800">
                    <h3 class="text-lg font-semibold">{{ $examen->examen->Nombre }}</h3>
                    <div class="mt-4 flex justify-end">
                        <a href="{{route('examenes.reponder',$examen->examen)}}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                           Acceder al examen
                        </a>
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