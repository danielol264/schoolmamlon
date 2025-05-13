<x-layouts.app :title="'Mis Exámenes'">
    <h2 class="text-2xl font-bold mb-4">Exámenes disponibles</h2>

    @forelse($examenes as $examen)
        <div class="p-4 border rounded shadow mb-2">
            <h3 class="text-lg font-semibold">{{ $examen->Nombre }}</h3>
            <p class="text-sm text-gray-500">Grupo: {{ $examen->grupo->Nombre ?? 'Sin grupo' }}</p>
            <a href="{{ route('alumno.examen', $examen->id) }}" class="text-blue-600 underline">Ver examen</a>
        </div>
    @empty
        <p>No tienes exámenes disponibles actualmente.</p>
    @endforelse
</x-layouts.app>