<x-layouts.app :title="__('Editar Examen')">
    @if (session('erorr'))
        <div class="flex rounded-4xl bg-red-100 text-red-800 p-4 mb-4" id="notification">
             <p class="flex-9">{{ session('success') }}</p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
@endif
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg p-6">
            <form action="{{ route('examenes.update', $examen->id) }}" method="POST" class="w-full">
                @csrf
                @method('PUT')
                
                <div class="mb-8">
                    <h1 class="text-2xl font-bold mb-2">Editar Examen</h1>
                    <p class="text-gray-600">Modifique los campos necesarios</p>
                </div>
                
                <input type="hidden" name="maestro" value="{{ Auth()->user()->id_maestro }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="relative z-0 w-full group">
                        <input type="text" name="nombre" id="nombre" 
                               value="{{ $examen->Nombre }}"
                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                               required />
                        <label for="nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Nombre del examen
                        </label>
                    </div>
                    
                    <div class="relative z-0 w-full group">
                        <select name="grupo" id="grupo" 
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                                required>
                            <option value="{{ $grupo }}" selected>{{ $grupo }}</option>
                            @foreach ($grupos as $grupoex)
                                @if($grupoex->id != $grupo->id)
                                    <option value="{{ $grupoex->id }}">{{ $grupoex->Nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="grupo" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Grupo
                        </label>
                    </div>
                </div>
                
                <div id="contenedor-preguntas" class="mb-8">
    @foreach ($preguntas as $index => $pregunta)
        <div class="pregunta-group bg-gray-50 p-4 rounded-lg mb-4 border border-gray-200" data-id="{{ $pregunta->id }}">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg">Pregunta #{{ $index + 1 }}</h3>
                <a href="{{route('preguntas.destroy',$pregunta)}}" type="button" onclick="eliminarPregunta(this)" 
                        class="text-red-600 hover:text-red-800">
                        @method('DELETE')
                        @csrf
                    ✕ Eliminar
                </a>
            </div>
            
            <input type="hidden" name="preguntas[{{ $index }}][id]" value="{{ $pregunta->id }}">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Texto de la pregunta</label>
                <input type="text" name="preguntas[{{ $index }}][texto]" 
                       value="{{ $pregunta->pregunta }}"
                       class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500" 
                       required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de pregunta</label>
                <select name="preguntas[{{ $index }}][tipo]" 
                        class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500"
                        onchange="mostrarCamposAdicionales(this, '{{ $index }}')">
                    <option value="o" {{ $pregunta->tipo == 'o' ? 'selected' : '' }}>Opción múltiple</option>
                    <option value="t" {{ $pregunta->tipo == 't' ? 'selected' : '' }}>Verdadero/Falso</option>
                    <option value="a" {{ $pregunta->tipo == 'a' ? 'selected' : '' }}>Respuesta abierta</option>
                </select>
            </div>
            
            <!-- Campos para opción múltiple -->
            <div id="campos-o-{{ $index }}" style="display: {{ $pregunta->tipo == 'o' ? 'block' : 'none' }};">
                <label class="block text-sm font-medium text-gray-700 mb-2">Opciones (marque la correcta)</label>
                <div id="respuestas-container-{{ $index }}">
                    @if($pregunta->tipo == 'o')
                        @foreach($respuestas[$pregunta->id] as $respuestaIndex => $respuesta)
                            <div class="flex items-center mb-2">
                                <input type="radio" name="preguntas[{{ $index }}][correcta]" 
                                       value="{{ $respuestaIndex }}"
                                       class="mr-2"
                                       {{ $pregunta->respuestacrt == $respuesta->respuesta ? 'checked' : '' }}>
                                <input type="text" name="preguntas[{{ $index }}][respuestas][{{ $respuestaIndex }}]" 
                                       value="{{ $respuesta->respuesta }}"
                                       class="w-full p-2 border rounded">
                                <button type="button" onclick="eliminarRespuesta(this)" 
                                        class="ml-2 text-red-600 hover:text-red-800">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    @else
                        <!-- Opciones por defecto para nueva conversión a opción múltiple -->
                        <div class="flex items-center mb-2">
                            <input type="radio" name="preguntas[{{ $index }}][correcta]" 
                                   value="0" class="mr-2">
                            <input type="text" name="preguntas[{{ $index }}][respuestas][0]" 
                                   placeholder="Opción 1" class="w-full p-2 border rounded">
                        </div>
                        <div class="flex items-center mb-2">
                            <input type="radio" name="preguntas[{{ $index }}][correcta]" 
                                   value="1" class="mr-2">
                            <input type="text" name="preguntas[{{ $index }}][respuestas][1]" 
                                   placeholder="Opción 2" class="w-full p-2 border rounded">
                        </div>
                    @endif
                </div>
                <button type="button" onclick="agregarOpcion('{{ $index }}')" 
                        class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                    ＋ Agregar otra opción
                </button>
            </div>
            
            <!-- Campos para verdadero/falso -->
            <div id="campos-t-{{ $index }}" style="display: {{ $pregunta->tipo == 't' ? 'block' : 'none' }};">
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccione la respuesta correcta</label>
                <div class="flex items-center mb-2">
                    <input type="radio" name="preguntas[{{ $index }}][correcta]" 
                           value="verdadero" class="mr-2"
                           {{ $pregunta->respuestacrt == 'true' ? 'checked' : '' }}>
                    <span>Verdadero</span>
                </div>
                <div class="flex items-center mb-2">
                    <input type="radio" name="preguntas[{{ $index }}][correcta]" 
                           value="falso" class="mr-2"
                           {{ $pregunta->respuestacrt == 'false' ? 'checked' : '' }}>
                    <span>Falso</span>
                </div>
            </div>
            
            <!-- Campos para respuesta abierta -->
            <div id="campos-a-{{ $index }}" style="display: {{ $pregunta->tipo == 'a' ? 'block' : 'none' }};">
                <label class="block text-sm font-medium text-gray-700 mb-1">Respuesta modelo (opcional)</label>
                <textarea name="preguntas[{{ $index }}][respuestas][0]" 
                          class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500">{{ $pregunta->respuestacrt }}</textarea>
            </div>
        </div>
    @endforeach
</div>
                
                <div class="flex justify-between items-center">
                    <button type="button" onclick="agregarPregunta()" 
                            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        ＋ Agregar Pregunta
                    </button>
                    <div class="flex gap-2">           
                        <button type="submit" 
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar campos según tipo de pregunta
        function mostrarCamposAdicionales(selectElement, idUnico) {

            document.getElementById(`campos-o-${idUnico}`).style.display = 'none';
            document.getElementById(`campos-t-${idUnico}`).style.display = 'none';
            document.getElementById(`campos-a-${idUnico}`).style.display = 'none';
            
            if (selectElement.value === 'o') {
                document.getElementById(`campos-o-${idUnico}`).style.display = 'block';
            } else if (selectElement.value === 't') {
                document.getElementById(`campos-t-${idUnico}`).style.display = 'block';
            } else if (selectElement.value === 'a') {
                document.getElementById(`campos-a-${idUnico}`).style.display = 'block';
            }
        }
        let contadorPreguntas = {{ count($preguntas) }};
        const contenedor = document.getElementById('contenedor-preguntas');

        function agregarPregunta() {
            contadorPreguntas++;
            const idUnico = contadorPreguntas;
            
            const divPregunta = document.createElement('div');
            divPregunta.className = 'pregunta-group bg-gray-900 text-white p-4 rounded-lg mb-4';
            divPregunta.dataset.id = idUnico;
            
            // Usamos comillas simples para el string interno para evitar conflictos
            divPregunta.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold">Pregunta #${idUnico}</h3>
                    <button type="button" onclick="eliminarPregunta(this)" class="text-red-500">
                        ✕ Eliminar
                    </button>
                </div>
                
                <input type="text" name="preguntas[${idUnico}][texto]" 
                    placeholder="Texto de la pregunta" 
                    class="w-full p-2 border rounded mb-2" required>
                    
                <select name="preguntas[${idUnico}][tipo]" 
                        class="w-full p-2 border rounded mb-2"
                        onchange="mostrarCamposAdicionales(this, ${idUnico})">
                    <option disabled selected>Selecciona el tipo de pregunta</option>
                    <option value="o">Opción múltiple</option>
                    <option value="t">Verdadero/Falso</option>
                    <option value="a">Abierto</option>
                </select>
                
                <div id="campos-o-${idUnico}" style="display: none;">
                    <div id="respuestas-container-${idUnico}">
                        <!-- Opciones iniciales -->
                        <div class="flex items-center mb-2">
                            <input checked type="radio" name="preguntas[${idUnico}][correcta]" value="1" class="mr-2">
                            <input type="text" name="preguntas[${idUnico}][respuestas][1]" 
                                placeholder="Respuesta 1" class="w-full p-2 border rounded required:true">
                        </div>
                        <div class="flex items-center mb-2">
                            <input type="radio" name="preguntas[${idUnico}][correcta]" value="2" class="mr-2">
                            <input type="text" name="preguntas[${idUnico}][respuestas][2]" 
                                placeholder="Respuesta 2" class="w-full p-2 border rounded required:true">
                        </div>
                    </div>
                    <button type="button" onclick="agregarOpcion(${idUnico})" 
                            class="mt-2 px-3 py-1 bg-blue-600 text-white rounded text-sm">
                        ＋ Agregar otra opción
                    </button>
                </div>
                <div id="campos-t-${idUnico}" style="display: none;">
                    <div class="flex items-center mb-2">
                        <input checked type="radio" name="preguntas[${idUnico}][correcta]" value="verdadero" class="mr-2" required>
                        <span>Verdadero</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="radio" name="preguntas[${idUnico}][correcta]" value="falso" class="mr-2">
                        <span>Falso</span>
                    </div>
                </div>
                <div id="campos-a-${idUnico}" style="display: none;">
                    <textarea name="preguntas[${idUnico}][respuestas][0]" class="w-full p-2 border rounded" placeholder="Respuesta en caso de tener"></textarea>
                </div>
            `;

            contenedor.appendChild(divPregunta);
        }
        
        // Función para eliminar pregunta
        function eliminarPregunta(boton) {
            const preguntaDiv = boton.closest('.pregunta-group');
            const idEliminado = parseInt(preguntaDiv.dataset.id);
        
        // Eliminar el div de la pregunta
            preguntaDiv.remove();
        
        // Reorganizar los números de las preguntas restantes
            const preguntasRestantes = contenedor.querySelectorAll('.pregunta-group');
            preguntasRestantes.forEach((pregunta, index) => {
                const nuevoNumero = index + 1;
                pregunta.dataset.id = nuevoNumero;
                pregunta.querySelector('h3').textContent = `Pregunta #${nuevoNumero}`;
            
                // Actualizar los 'name' de los inputs
                const inputs = pregunta.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const oldName = input.name;
                    input.name = oldName.replace(/\[\d+\]/, `[${nuevoNumero}]`);
                });
            });
        
        // Actualizar el contador
            contadorPreguntas = preguntasRestantes.length;
        }
        
        // Función para agregar opción a pregunta de opción múltiple
        function agregarOpcion(preguntaId) {
            const contenedor = document.getElementById(`respuestas-container-${preguntaId}`);
            const contadorOpciones = contenedor.children.length;
            
            const nuevaOpcion = document.createElement('div');
            nuevaOpcion.className = 'flex items-center mb-2';
            nuevaOpcion.innerHTML = ` 
                <input type="radio" name="preguntas[${preguntaId}][correcta]" 
                    value="${contadorOpciones}" class="mr-2">
                <input type="text" name="preguntas[${preguntaId}][respuestas][${contadorOpciones+1}]" 
                    placeholder="Respuesta ${contadorOpciones + 1}" class="w-full p-2 border rounded">
            `;
            
            contenedor.appendChild(nuevaOpcion);
        }
        
        // Función para eliminar respuesta
        function eliminarRespuesta(boton) {
            if (confirm('¿Está seguro de eliminar esta opción?')) {
                const respuestaDiv = boton.closest('div');
                respuestaDiv.remove();
            }
        }
    </script>
</x-layouts.app>