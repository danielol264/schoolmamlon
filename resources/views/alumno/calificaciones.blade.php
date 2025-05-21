@php
    $alumno_id = Auth()->user()->id_alumno;
    use App\Models\calificaciones;
    $calificaciones = calificaciones::with(['examen', 'alumno'])
        ->where('id_alumno', $alumno_id)
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<x-layouts.app :title="__('Mis Calificaciones')">
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-10">📚 Mis Calificaciones</h1>

        @if($calificaciones->isEmpty())
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8 text-center">
                <p class="text-lg text-gray-600 dark:text-gray-300">Aún no tienes calificaciones disponibles.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-2xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Examen</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Calificación</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($calificaciones as $calificacion)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-base text-gray-800 dark:text-gray-200">
                                {{ $calificacion->examen->Nombre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ $calificacion->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $calificacion->calificacion >= 70 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $calificacion->calificacion }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="inline-flex items-center gap-1 
                                    {{ $calificacion->calificacion >= 70 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    @if($calificacion->calificacion >= 70)
                                        ✅ Aprobado
                                    @else
                                        ❌ Reprobado
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
