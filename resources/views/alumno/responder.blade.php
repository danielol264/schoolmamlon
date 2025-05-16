<x-layouts.app :title="__('Examen: ').$examen->Nombre">
    <form action="{{route('examenes.enviar')}}" method="POST">
        @csrf
        <input type="hidden" name="examen_id" value="{{ $examen->id }}">
        <input type="hidden" name="alumno_id" value="{{ Auth::user()->alumno->id }}">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid auto-rows-min h-40 gap-4">
                    <flux:input label="Nombre del examen" value="{{ $examen->Nombre }}" disabled/>      

            </div>
        </div>
        <div class="flex flex-col gap-4">
            @foreach ($preguntas as $pregunta)
                <div class="p-4 border rounded-lg mb-4">
                    <h3 class="font-bold mb-2">Pregunta {{ $loop->iteration }}</h3>
                    <p class="mb-4">{{ $pregunta->pregunta }}</p>

                    @switch($pregunta->tipo)
                        @case('o') <!-- Opción múltiple -->
                            @foreach($respuestas[$pregunta->id] as $respuesta)
                                <div class="flex items-center mb-2">
                                    <input type="radio" 
                                           name="respuestas[{{ $pregunta->id }}]" 
                                           id="resp_{{ $pregunta->id }}_{{ $respuesta->id }}" 
                                           value="{{ $respuesta->id }}" 
                                           class="mr-2">
                                    <label for="resp_{{ $pregunta->id }}_{{ $respuesta->id }}">
                                        {{ $respuesta->respuesta }}
                                    </label>
                                </div>
                            @endforeach
                            @break

                        @case('t') <!-- Verdadero/Falso -->
                            <div class="flex items-center mb-2">
                                <input type="radio" 
                                       name="respuestas[{{ $pregunta->id }}]" 
                                       id="resp_{{ $pregunta->id }}_true" 
                                       value="verdadero" 
                                       class="mr-2">
                                <label for="resp_{{ $pregunta->id }}_true">Verdadero</label>
                            </div>
                            <div class="flex items-center mb-2">
                                <input type="radio" 
                                       name="respuestas[{{ $pregunta->id }}]" 
                                       id="resp_{{ $pregunta->id }}_false" 
                                       value="falso" 
                                       class="mr-2">
                                <label for="resp_{{ $pregunta->id }}_false">Falso</label>
                            </div>
                            @break

                        @case('a') <!-- Respuesta abierta -->
                            <textarea name="respuestas[{{ $pregunta->id }}]" 
                                      class="w-full p-2 border rounded" 
                                      rows="3"></textarea>
                            @break
                    @endswitch
                </div>
            @endforeach

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                Enviar Respuestas
            </button>
        </div>
    </form>
</x-layouts.app>