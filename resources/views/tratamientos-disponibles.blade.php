<x-layouts.app :title="__('Tratamientos disponibles')">
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-zinc-800 shadow-lg rounded-xl mt-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-light-primary dark:text-dark-primary">Listado de Médicos</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($tratamientos as $tratamiento)
           <div class="mb-4 p-4 bg-white dark:bg-zinc-700 border rounded-md shadow">
                <h2 class="text-xl font-semibold text-light-text dark:text-dark-text mb-2">{{ $tratamiento->nombre }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Descripción: {{ $tratamiento->descripcion ?? 'Sin descripción' }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Fecha Inicio: {{ \Carbon\Carbon::parse($tratamiento->fecha_inicio)->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Fecha Fin: {{ \Carbon\Carbon::parse($tratamiento->fecha_fin)->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Hora Inicio: {{ \Carbon\Carbon::parse($tratamiento->hora_inicio)->format('H:i') }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">Hora Fin: {{ \Carbon\Carbon::parse($tratamiento->hora_fin)->format('H:i') }}</p>
            </div>
        @empty
            <p class="text-gray-600">No hay tratamientos registrados.</p>
        @endforelse
    </div>
</x-layouts.app>
