<div>
    <div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Exámenes disponibles</h2>

    @forelse($examenes as $examen)
        <div class="p-4 border rounded shadow mb-2">
            <h3 class="text-lg font-semibold">{{ $examen->titulo }}</h3>
            <p>{{ $examen->descripcion }}</p>
            <a href="{{ route('alumno.examen', $examen->id) }}" class="text-blue-600 underline">Presentar examen</a>
        </div>
    @empty
        <p>No tienes exámenes disponibles actualmente.</p>
    @endforelse
</div>
</div>
