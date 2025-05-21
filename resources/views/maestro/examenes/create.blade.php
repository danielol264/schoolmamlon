<x-layouts.app title="Crear Examen">
    @if (session()->has("mensaje"))
        <script>
            alert("{{ session()->get('mensaje') }}");
        </script> 
    @endif
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-cols-3">
            <div class="relative object-center content-center">    
            </div>
            <div class="relative items-center content-center">
            </div>
            <div class="fixed top-5 right-10">
            </div>
        </div>
        <div class="relative h-full flex rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">
            <h1>Bienvenidos a crear examen</h1>
            <h5>Sigue las indicaciones papu</h5>
            <form  action="{{ route('examenes.store') }}" method="POST" class="max-w-md mx-auto">
                @csrf
                @method('POST')
                <div class="relative z-0 w-full mb-5 group">
                    <input class="hidden" name="maestro" value="{{ Auth()->User()->id_maestro }}"></input>
                    <input type="text" name="nombre" id="nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                    <label for="nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre del examen</label>
                    <label for="underline_select" class="sr-only">Underline select</label>
                    <select id="underline_select" name="grupo" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                        <option selected>Selecciona un grupo</option>
                        @foreach ($grupos as $grupo)
                            <flux:select.option value="{{ $grupo->id }}">{{$grupo->Nombre}}</flux:select.option>
                        @endforeach
                    </select>
                    <div>
                       <button type="button" onclick="agregarPregunta()" class="btn-agregar">
    ＋ Agregar Pregunta
</button>

<div id="contenedor-preguntas" class="overflow-x-auto">
    <!-- Aquí se agregarán los inputs dinámicos -->
</div>
                                                
                    </div>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Continuar</button>
            </form>
            
        </div>
        <script>
            let contadorPreguntas = 0;
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
                    <input type="radio" name="preguntas[${idUnico}][correcta]" value="1" class="mr-2">
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
    // Validación del formulario antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    if (!validarFormulario()) {
        e.preventDefault(); // Evita el envío si la validación falla
    }
});

function validarFormulario() {
    // Validar nombre del examen
    const nombreExamen = document.getElementById('nombre').value.trim();
    if (!nombreExamen) {
        alert('Por favor ingresa un nombre para el examen');
        return false;
    }

    // Validar selección de grupo
    const grupoSeleccionado = document.getElementById('underline_select').value;
    if (grupoSeleccionado === 'Selecciona un grupo') {
        alert('Por favor selecciona un grupo');
        return false;
    }

    // Validar preguntas
    const preguntas = document.querySelectorAll('.pregunta-group');
    if (preguntas.length === 0) {
        alert('Debes agregar al menos una pregunta');
        return false;
    }

    // Validar cada pregunta
    for (const pregunta of preguntas) {
        const id = pregunta.dataset.id;
        const textoPregunta = document.querySelector(`input[name="preguntas[${id}][texto]`).value.trim();
        const tipoPregunta = document.querySelector(`select[name="preguntas[${id}][tipo]"]`).value;
        
        // Validar texto de pregunta
        if (!textoPregunta) {
            alert(`La pregunta #${id} no tiene texto`);
            return false;
        }

        // Validar tipo de pregunta
        if (!tipoPregunta) {
            alert(`La pregunta #${id} no tiene tipo seleccionado`);
            return false;
        }

        // Validaciones específicas por tipo
        if (tipoPregunta === 'o') { // Opción múltiple
            const opciones = document.querySelectorAll(`input[name="preguntas[${id}][respuestas][]"]`);
            let tieneTexto = true;
            let tieneCorrecta = false;

            opciones.forEach(opcion => {
                if (!opcion.value.trim()) {
                    tieneTexto = false;
                }
                if (document.querySelector(`input[name="preguntas[${id}][correcta]"]:checked`)) {
                    tieneCorrecta = true;
                }
            });

            if (!tieneTexto) {
                alert(`La pregunta #${id} (opción múltiple) tiene opciones sin texto`);
                return false;
            }

            if (!tieneCorrecta) {
                alert(`La pregunta #${id} (opción múltiple) no tiene respuesta correcta seleccionada`);
                return false;
            }
        }
    }

    return true;
}
        </script>
    </div>
</x-layouts.app>
                