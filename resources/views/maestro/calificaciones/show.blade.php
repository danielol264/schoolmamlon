<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">     
            <span>{{$grupo->Nombre}}</span>
            {{$examen->Nombre}}
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Calificación
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupo->alumnos as $alumno)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$alumno->alumno->Nombre}} {{$alumno->alumno->AP}} {{$alumno->alumno->AM}}
                        </td>
                        <td>
                            <form action="{{ route('calificaciones.examen')}}" method="get">
                                @csrf
                                <input type="hidden" name="examen_id" value="{{$examen->id}}">
                                <input type="hidden" name="alumno_id" value="{{$alumno->alumno->id}}">
                                <input type="hidden" name="grupo_id" value="{{$grupo->id}}">
                                <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Ver Examen de Alumno
                                </button>
                            </form>
                        </td>
                    @endforeach
                </tbody>
            </table>
        </div>
        </
    </div>
</x-layouts.app>