    <x-layouts.app :title="__('Examen')">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid auto-rows-min h-40 gap-4 ">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <flux:input label="Nombre del examen" value="{{ $examen->Nombre }}" disabled/>
                    <flux:select disabled>
                        <flux:select.option >{{$grupo->Nombre}}</flux:select.option>
                    </flux:select>
                    <flux:input label="Calificacion" value="{{$calificaciones ? $calificaciones->calificacion:'este alumno no tiene calificacion registrada' }}" disabled/>

                </div>
            </div>
            <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    @foreach ($preguntas as $pregunta)
                        <div class="mb-6">
                            <flux:input label="Pregunta" disabled value="{{ $pregunta->pregunta }}"/>
                            
                            @php
                                $respuestaAlumno = $respuestasAlumno ? $respuestasAlumno[$pregunta->id]->first() : '';
                                $color = '';
                                if ($pregunta->respuestacrt) {
                                    $color = ($respuestaAlumno && $respuestaAlumno->respuesta == $pregunta->respuestacrt) 
                                        ? 'border-green-800' 
                                        : 'border-red-800';
                                } else {
                                    $color = 'border-yellow-800';
                                }
                            @endphp
                            
                            <div class="p-4 rounded border {{ $color }}">
                                @switch($pregunta->tipo)
                                    @case('o') <!-- Opción múltiple -->
                                        @foreach($respuestas[$pregunta->id] as $respuesta)
                                            <div class="flex items-center mb-2">
                                                <input disabled type="radio" 
                                                    name="pregunta_{{ $pregunta->id }}"
                                                    id="respuesta_{{ $respuesta->id }}"
                                                    value="{{ $respuesta->id }}"
                                                    class="mr-2"
                                                    @if($respuestaAlumno && $respuestaAlumno->respuesta == $respuesta->respuesta) checked @endif>
                                                <label for="respuesta_{{ $respuesta->id }}">{{ $respuesta->respuesta }}</label>

                                            </div>
                                        @endforeach
                                        @break
                                        
                                    @case('t') 
                                        <div class="flex items-center mb-2">
                                            <input disabled 
                                                type="radio"
                                                name="pregunta_{{ $pregunta->id }}_disabled"
                                                id="pregunta_{{ $pregunta->id }}_verdadero"
                                                value="verdadero"
                                                class="mr-2"
                                                @if($respuestaAlumno ? $respuestaAlumno->respuesta : '' == 'true') checked @endif>
                                            <label for="pregunta_{{ $pregunta->id }}_verdadero">Verdadero</label>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <input disabled
                                                type="radio"
                                                name="pregunta_{{ $pregunta->id }}_disabled" 
                                                id="pregunta_{{ $pregunta->id }}_falso"
                                                value="falso"
                                                class="mr-2"
                                                @if($respuestaAlumno ? $respuestaAlumno->respuesta : ''  == 'false') checked @endif>
                                            <label for="pregunta_{{ $pregunta->id }}_falso">Falso</label>
                                        </div>
                                        @break
                                        
                                    @case('a')
                                        <textarea disabled 
                                            class="w-full p-2 border rounded" 
                                            placeholder="El alumno no respondió"
                                            >{{ $respuestaAlumno ? $respuestaAlumno->respuesta : 'El alumno no respondio' }}
                                        </textarea>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </x-layouts.app>