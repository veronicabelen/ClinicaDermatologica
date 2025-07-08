<x-layouts.app :title="__('Mis Turnos')">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Mis Turnos</h1>
        @if($turnos->isEmpty())
        <div class="mb-2 p-4 bg-blue-100 text-blue-800 rounded-lg shadow-sm">
            No tienes ningún turno reservado en este momento.
        </div>
        @else
        <div class="space-y-4">
            @foreach($turnos as $turno)
            <div class="p-6 border rounded-xl bg-white dark:bg-zinc-800 shadow-md flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex-1 w-full md:w-auto">
                    <div class="font-semibold text-xl text-pink-600 dark:text-pink-400 mb-2">
                        {{ \Carbon\Carbon::parse($turno->fecha)->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </div>
                    <div class="text-lg text-gray-700 dark:text-gray-300">
                        <span class="font-medium">Hora:</span> {{ \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($turno->hora_fin)->format('H:i') }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 mt-1">
                        <span class="font-medium">Estado:</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                    @if($turno->estado === 'reservado') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                    @elseif($turno->estado === 'libre') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                    @endif">
                            {{ ucfirst($turno->estado) }}
                        </span>
                    </div>
                    @if($turno->tratamiento)
                    <div class="text-gray-600 dark:text-gray-400 mt-1">
                        <span class="font-medium">Tratamiento:</span> {{ $turno->tratamiento->nombre ?? 'N/A' }}
                    </div>
                    @endif
                    @if($turno->medico)
                    <div class="text-gray-600 dark:text-gray-400 mt-1">
                        <span class="font-medium">Médico:</span> {{ $turno->medico->name ?? 'N/A' }}
                        <span class="font-medium"> </span> {{ $turno->medico->last_name ?? '' }}
                    </div>
                    @endif
                    @if($turno->comentario)
                    <div class="text-gray-600 dark:text-gray-400 mt-1">
                        <span class="font-medium">Comentario:</span> {{ $turno->comentario }}
                    </div>
                    @endif
                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        Reservado el: {{ \Carbon\Carbon::parse($turno->created_at)->isoFormat('D [de] MMMM [de] YYYY, H:mm') }}
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <form method="POST" action="{{ route('turno-eliminar', $turno->id) }}" onsubmit="return confirm('¿Seguro que deseas eliminar tu inscripción a este turno?')">
                        @csrf
                        @method('DELETE')
                        <x-flux-button type="submit" color="danger">Eliminar</x-flux-button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</x-layouts.app>