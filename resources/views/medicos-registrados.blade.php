<x-layouts.app :title="__('Médicos Registrados')">
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-zinc-800 shadow-lg rounded-xl mt-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-light-primary dark:text-dark-primary">Listado de Médicos</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($medicos as $medico)
            <div class="mb-4 p-4 bg-white dark:bg-zinc-700 border rounded-md shadow">
                <h2 class="text-xl font-semibold text-light-text dark:text-dark-text">{{ $medico->name }} {{ $medico->last_name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">Especialidad: {{ $medico->title ?? 'No especificada' }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">Matrícula: {{ $medico->professional_license }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $medico->description ?? 'Sin descripción' }}</p>
            </div>
        @empty
            <p class="text-gray-600">No hay médicos registrados.</p>
        @endforelse
    </div>
</x-layouts.app>
