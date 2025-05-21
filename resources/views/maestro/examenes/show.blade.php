<x-layouts.app :title="__('Examen')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <!-- Header del examen -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Vista Previa del Examen</h1>
                
                @if($grupo->activo != 1)
                <form action="{{route('examenes.activar',$grupo)}}" method="post">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        <i class="fas fa-toggle-on mr-2"></i>Activar examen
                    </button>
                </form>
                @else
                <form action="{{route('examenes.desactivar',$grupo)}}" method="post">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        <i class="fas fa-toggle-off mr-2"></i>Desactivar examen
                    </button>
                </form>
                @endif
            </div>
            
            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <flux:input label="Nombre del examen" value="{{ $examen->Nombre }}" disabled/>
            </div>
        </div>

        <!-- Contenedor de preguntas -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md overflow-hidden flex-1">
            <div class="p-6 space-y-8">
                @foreach ($preguntas as $index => $pregunta)
                <div class="question-container bg-gray-50 dark:bg-neutral-700/50 rounded-lg p-5 border border-gray-200 dark:border-neutral-600">
                    <div class="flex items-start mb-4">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-semibold mr-3">
                            {{ $index + 1 }}
                        </span>
                        <flux:input label="Pregunta" disabled value="{{ $pregunta->pregunta }}" class="flex-1"/>
                    </div>

                    <div class="ml-11 space-y-3">
                        @switch($pregunta->tipo)
                            @case('o') <!-- Opción múltiple -->
                                @foreach($respuestas[$pregunta->id] as $respuesta)
                                    <div class="flex items-center p-3 rounded hover:bg-gray-100 dark:hover:bg-neutral-600/50">
                                        <input disabled type="radio" 
                                            name="pregunta_{{ $pregunta->id }}"
                                            id="respuesta_{{ $respuesta->id }}"
                                            value="{{ $respuesta->id }}"
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 dark:bg-neutral-700 dark:border-neutral-600"
                                            @if($pregunta->respuestacrt) checked @endif>
                                        <input type="text" disabled value=" {{$respuesta->respuesta }}" 
                                            class="ml-3 bg-transparent border-none w-full text-gray-700 dark:text-gray-200 focus:ring-0">
                                    </div>
                                @endforeach
                                @break
                                
                            @case('t') <!-- Verdadero/Falso -->
                                <div class="flex items-center p-3 rounded hover:bg-gray-100 dark:hover:bg-neutral-600/50">
                                    <input disabled 
                                        type="radio"
                                        name="pregunta_{{ $pregunta->id }}_disabled"
                                        id="pregunta_{{ $pregunta->id }}_verdadero"
                                        value="verdadero"
                                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 dark:bg-neutral-700 dark:border-neutral-600"
                                        @if($pregunta->respuestacrt) checked @endif> 
                                    <label for="pregunta_{{ $pregunta->id }}_verdadero" class="ml-3 text-gray-700 dark:text-gray-200">Verdadero</label>
                                </div>
                                <div class="flex items-center p-3 rounded hover:bg-gray-100 dark:hover:bg-neutral-600/50">
                                    <input disabled
                                        type="radio"
                                        name="pregunta_{{ $pregunta->id }}_disabled" 
                                        id="pregunta_{{ $pregunta->id }}_falso"
                                        value="falso"
                                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 dark:bg-neutral-700 dark:border-neutral-600"
                                        @if($pregunta->respuestacrt) checked @endif>
                                    <label for="pregunta_{{ $pregunta->id }}_falso" class="ml-3 text-gray-700 dark:text-gray-200">Falso</label>
                                </div>
                                @break
                                
                            @case('a') <!-- Respuesta abierta -->
                                <textarea disabled name="pregunta_{{ $pregunta->id }}" 
                                    class="w-full p-3 border border-gray-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-gray-700 dark:text-gray-200" 
                                    rows="4"
                                    placeholder="Escribe tu respuesta">@if(isset($pregunta->respuestacrt)){{$pregunta->respuestacrt}}@endif</textarea>
                                @break
                        @endswitch
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>