<x-layouts.app title="Crear Examen">
    @if (session()->has("mensaje"))
        <script>
            alert("{{ session()->get('mensaje') }}");
        </script> 
    @endif

    <div class="flex flex-col gap-6 p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-4xl mx-auto mt-6">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Crear Nuevo Examen</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300">Llena los datos y agrega tus preguntas</p>
        </div>

        <form action="{{ route('examenes.store') }}" method="POST" class="space-y-6">
            @csrf
            @method('POST')
            <input type="hidden" name="maestro" value="{{ Auth()->User()->id_maestro }}">

            <div>
                <label for="nombre" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Nombre del examen</label>
                <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 dark:bg-gray-800 dark:text-white" required>
            </div>

            <div>
                <label for="underline_select" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Grupo</label>
                <select id="underline_select" name="grupo" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 dark:text-white focus:outline-none focus:ring focus:ring-blue-500" required>
                    <option selected disabled>Selecciona un grupo</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo->id }}">{{ $grupo->Nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="border-t pt-4 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Preguntas</h2>
                <button type="button" onclick="agregarPregunta()" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 mb-4">
                    ＋ Agregar Pregunta
                </button>
                <div id="contenedor-preguntas" class="space-y-4">
                    <!-- Preguntas se agregan aquí -->
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg">
                    Continuar
                </button>
            </div>
        </form>
    </div>

    <script>
        let contadorPreguntas = 0;
        const contenedor = document.getElementById('contenedor-preguntas');

        function agregarPregunta() {
            contadorPreguntas++;
            const idUnico = contadorPreguntas;

            const divPregunta = document.createElement('div');
            divPregunta.className = 'pregunta-group bg-gray-100 dark:bg-gray-800 text-black dark:text-white p-4 rounded-lg shadow';
            divPregunta.dataset.id = idUnico;

            divPregunta.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold">Pregunta #${idUnico}</h3>
                    <button type="button" onclick="eliminarPregunta(this)" class="text-red-600 hover:underline">
                        ✕ Eliminar
                    </button>
                </div>

                <input type="text" name="preguntas[${idUnico}][texto]" placeholder="Texto de la pregunta" class="w-full p-2 border rounded mb-2" required>

                <select name="preguntas[${idUnico}][tipo]" class="w-full p-2 border rounded mb-2" onchange="mostrarCamposAdicionales(this, ${idUnico})">
                    <option disabled selected>Selecciona el tipo de pregunta</option>
                    <option value="o">Opción múltiple</option>
                    <option value="t">Verdadero/Falso</option>
                    <option value="a">Abierto</option>
                </select>

                <div id="campos-o-${idUnico}" style="display: none;">
                    <div id="respuestas-container-${idUnico}">
                        <div class="flex items-center mb-2">
                            <input type="radio" name="preguntas[${idUnico}][correcta]" value="1" class="mr-2">
                            <input type="text" name="preguntas[${idUnico}][respuestas][1]" placeholder="Respuesta 1" class="w-full p-2 border rounded">
                        </div>
                        <div class="flex items-center mb-2">
                            <input type="radio" name="preguntas[${idUnico}][correcta]" value="2" class="mr-2">
                            <input type="text" name="preguntas[${idUnico}][respuestas][2]" placeholder="Respuesta 2" class="w-full p-2 border rounded">
                        </div>
                    </div>
                    <button type="button" onclick="agregarOpcion(${idUnico})" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded text-sm">
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
            preguntaDiv.remove();

            const preguntasRestantes = contenedor.querySelectorAll('.pregunta-group');
            preguntasRestantes.forEach((pregunta, index) => {
                const nuevoNumero = index + 1;
                pregunta.dataset.id = nuevoNumero;
                pregunta.querySelector('h3').textContent = `Pregunta #${nuevoNumero}`;

                const inputs = pregunta.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    const oldName = input.name;
                    input.name = oldName.replace(/\[\d+\]/, `[${nuevoNumero}]`);
                });
            });

            contadorPreguntas = preguntasRestantes.length;
        }

        function agregarOpcion(preguntaId) {
            const contenedor = document.getElementById(`respuestas-container-${preguntaId}`);
            const contadorOpciones = contenedor.children.length;

            const nuevaOpcion = document.createElement('div');
            nuevaOpcion.className = 'flex items-center mb-2';
            nuevaOpcion.innerHTML = ` 
                <input type="radio" name="preguntas[${preguntaId}][correcta]" value="${contadorOpciones}" class="mr-2">
                <input type="text" name="preguntas[${preguntaId}][respuestas][${contadorOpciones + 1}]" placeholder="Respuesta ${contadorOpciones + 1}" class="w-full p-2 border rounded">
            `;

            contenedor.appendChild(nuevaOpcion);
        }

        // Validación del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validarFormulario()) {
                e.preventDefault();
            }
        });

        function validarFormulario() {
            const nombreExamen = document.getElementById('nombre').value.trim();
            if (!nombreExamen) {
                alert('Por favor ingresa un nombre para el examen');
                return false;
            }

            const grupoSeleccionado = document.getElementById('underline_select').value;
            if (grupoSeleccionado === 'Selecciona un grupo' || grupoSeleccionado === '') {
                alert('Por favor selecciona un grupo');
                return false;
            }

            const preguntas = document.querySelectorAll('.pregunta-group');
            if (preguntas.length === 0) {
                alert('Debes agregar al menos una pregunta');
                return false;
            }

            for (const pregunta of preguntas) {
                const id = pregunta.dataset.id;
                const textoPregunta = pregunta.querySelector(`input[name="preguntas[${id}][texto]"]`).value.trim();
                const tipoPregunta = pregunta.querySelector(`select[name="preguntas[${id}][tipo]"]`).value;

                if (!textoPregunta) {
                    alert(`La pregunta #${id} no tiene texto`);
                    return false;
                }

                if (!tipoPregunta) {
                    alert(`La pregunta #${id} no tiene tipo seleccionado`);
                    return false;
                }

                if (tipoPregunta === 'o') {
                    const opcionesTexto = pregunta.querySelectorAll(`input[name^="preguntas[${id}][respuestas]"]`);
                    let tieneTexto = true;
                    opcionesTexto.forEach(op => {
                        if (!op.value.trim()) tieneTexto = false;
                    });

                    const correcta = pregunta.querySelector(`input[name="preguntas[${id}][correcta]"]:checked`);
                    if (!tieneTexto) {
                        alert(`La pregunta #${id} tiene opciones sin texto`);
                        return false;
                    }
                    if (!correcta) {
                        alert(`La pregunta #${id} no tiene una opción correcta seleccionada`);
                        return false;
                    }
                }
            }

            return true;
        }
    </script>
</x-layouts.app>
