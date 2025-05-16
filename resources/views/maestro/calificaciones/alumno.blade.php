<x-layouts.app :title="__('Dashboard')">
    <div>
        <span class="text-xl font-bold">
            {{ $alumno->Nombre }} {{ $alumno->AP }} {{ $alumno->AM }}
        </span>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Examen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calificación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-700 divide-y divide-gray-800">
                    @foreach($examenes as $examen)
                    @php
                        $calificacion = $calificaciones->where('id_examen', $examen->id)->first();
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $examen->Nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($calificacion)
                                {{ $calificacion->calificacion ?? 'Sin calificar' }}
                            @else
                                Sin calificar
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('calificaciones.examen') }}" method="get">
                                @csrf
                                <input type="hidden" name="examen_id" value="{{ $examen->id }}">
                                <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                                <input type="hidden" name="grupo_id" value="{{ $grupo }}">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
</x-layouts.app>