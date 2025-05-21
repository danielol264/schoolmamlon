
<x-layouts.app :title="__('Menu Del Maestro')">
@if (session('success'))
        <div class="flex rounded-4xl bg-green-100 text-green-800 p-4 mb-4" id="notification">
             <p class="flex-9">{{ session('success') }}</p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
@endif
@if (session('erorr'))
        <div class="flex rounded-4xl bg-red-100 text-red-800 p-4 mb-4" id="notification">
             <p class="flex-9">{{ session('success') }}</p>
             <flux:button variant="primary" onclick="closeNotification()" class="felx-1" icon="x-mark"></flux:button>
        </div>
@endif
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex auto-rows-min gap-4 md:felx">
            <div class="felx-1 h-40 relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1>joto el que se llame {{auth()->user()->maestro->Nombre}}</h1>
            </div>
            <div class="flex-1 h-40 relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <br>
                <form action="{{ route('examenes.create')}}" method="GET">
                    @csrf
                    @method('GET')
                    <input class="hidden" name="maestro" value="{{ Auth()->User()->id_maestro}}" />
                <flux:button type="sumit" variant="primary" class="object-center inline-block">Crear Examen</flux:button>
                </form>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
         @if(!$examenes->isEmpty())
                <table id="search-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            Id
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Nombre del examen
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Grupo 
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Creador
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Acciones
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examenes as $examen)
                    <tr>
                        <td> {{$examen->id}}</td>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$examen->Nombre}}</td>
                        <td>{{$examen->grupos->first()->Nombre}}</td>
                        <td>{{$examen->maestro->Nombre}}</td>
                        <td></td>
                        <td class="flex gap-2">
                            <flux:button method="GET" href="{{ route('examenes.show',$examen->id) }}" icon="eye" variant="primary">ver</flux:button>
                            <flux:button method="GET" href="{{ route('examenes.edit',$examen->id) }}" icon="pencil" variant="primary">Editar</flux:button>
                            <form action="{{ route('examenes.destroy', $examen->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="confirmarEliminar()" >Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                    
            </tbody>
        </table>
        @else
            <div colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                No hay alumnos registrados
            </div>
        @endif

        </div>
    </div>
    <script> 

        function confirmarEliminar(){
            return confirm('¿Estás seguro de que deseas eliminar este examen? Esta acción no se puede deshacer.');
        }
        function closeNotification() {
            document.getElementById('notification').style.display = 'none';
        }
    </script>
</x-layouts.app>