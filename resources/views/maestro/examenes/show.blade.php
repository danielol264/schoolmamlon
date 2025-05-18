    <x-layouts.app :title="__('Dashboard')">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            
            <div class="grid auto-rows-min h-40 gap-4 ">
                @if($grupo->activo != 1)
                <form action="{{route('examenes.activar',$grupo)}}" method="post">
                    @csrf
                <button type="submit">Activar examen</button>
                </form>
                @else
                <form action="{{route('examenes.desactivar',$grupo)}}" method="post">
                    @csrf
                <button type="submit">Desactivar examen</button>
                </form>
                @endif
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <flux:input label="Nombre del examen" value="{{ $examen->Nombre }}" disabled/>
                    <flux:select disabled>
                        <flux:select.option >{{$grupo->grupo}}</flux:select.option>
                        @foreach ($grupos as $grupo)
                            <flux:select.option value="{{ $grupo->id }}">{{$grupo->Nombre}}</flux:select.option>
                        @endforeach
                    </flux:select>

                </div>
            </div>
            <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    @foreach ($preguntas as $pregunta)
                        <flux:input label="Pregunta " disabled  value="{{ $pregunta->pregunta }}"/>
                        @switch($pregunta->tipo)
                            @case('o') <!-- Opción múltiple -->
                                @foreach($respuestas[$pregunta->id] as $respuesta)
                                    <div class="flex items-center mb-2">
                                        <input disabled type="radio" 
                                            name="pregunta_{{ $pregunta->id }}"
                                            id="respuesta_{{ $respuesta->id }}"
                                            value="{{ $respuesta->id }}"
                                            class="mr-2"
                                            @if($pregunta->respuestacrt) checked @endif>
                                        <input type="text" disabled value=" {{$respuesta->respuesta }}"></input>
                                    </div>
                                @endforeach
                                @break
                                
                            @case('t') <!-- Verdadero/Falso -->
                                <div class="flex items-center mb-2">
                                    <!-- Opción Verdadero -->
                                    <input disabled 
                                        type="radio"
                                        name="pregunta_{{ $pregunta->id }}_disabled"
                                        id="pregunta_{{ $pregunta->id }}_verdadero"
                                        value="verdadero"
                                        class="mr-2"
                                        @if($pregunta->respuestacrt) checked @endif> 
                                    <label for="pregunta_{{ $pregunta->id }}_verdadero">Verdadero</label>
                                </div>
                                <div class="flex items-center mb-2">
                                    
                                    <input disabled
                                        type="radio"
                                        name="pregunta_{{ $pregunta->id }}_disabled" 
                                        id="pregunta_{{ $pregunta->id }}_falso"
                                        value="falso"
                                        class="mr-2"
                                        @if($pregunta->respuestacrt) checked @endif>
                                    <label for="pregunta_{{ $pregunta->id }}_falso">Falso</label>
                                </div>
                                @break
                                
                            @case('a') <!-- Respuesta abierta -->
                                <textarea disabled name="pregunta_{{ $pregunta->id }}" 
                                        class="w-full p-2 border rounded" 
                                        placeholder="Escribe tu respuesta">@if(isset($pregunta->respuestacrt)){{$pregunta->respuestacrt}}
                                    @endif
                                </textarea>
                                @break
                        @endswitch
                        
                    @endforeach
                    
            </div>
            
        </div>
    </x-layouts.app>