<x-layouts.app :title="__('Reservar Turno')">
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-zinc-800 shadow-lg rounded-xl mt-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-light-primary dark:text-dark-primary">Reservar Nuevo Turno</h1>

        {{-- Mensajes de éxito y error --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-light-success/10 text-light-success rounded-md border border-light-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-light-error/10 text-light-error rounded-md border border-light-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('turnos.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Campo para seleccionar Médico --}}
            <div>
                <label for="medico_id" class="block text-sm font-medium text-light-text dark:text-dark-text mb-1">Médico</label>
                <select name="medico_id" id="medico_id" required
                        class="mt-1 block w-full p-3 border border-light-secondary rounded-md shadow-sm focus:ring-light-primary focus:border-light-primary dark:bg-zinc-700 dark:border-zinc-600 dark:text-dark-text">
                    <option value="">Selecciona un médico</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}" {{ old('medico_id') == $medico->id ? 'selected' : '' }}>
                            {{ $medico->name }} {{ $medico->last_name }} ({{ $medico->title }})
                        </option>
                    @endforeach
                </select>
                @error('medico_id')
                    <p class="mt-1 text-sm text-light-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo para seleccionar Tratamiento --}}
            <div>
                <label for="tratamientos_id" class="block text-sm font-medium text-light-text dark:text-dark-text mb-1">Tratamiento</label>
                <select name="tratamientos_id" id="tratamientos_id" required
                        class="mt-1 block w-full p-3 border border-light-secondary rounded-md shadow-sm focus:ring-light-primary focus:border-light-primary dark:bg-zinc-700 dark:border-zinc-600 dark:text-dark-text">
                    <option value="">Selecciona un tratamiento</option>
                    @foreach($tratamientos as $tratamiento)
                        <option value="{{ $tratamiento->id }}" {{ old('tratamientos_id') == $tratamiento->id ? 'selected' : '' }}>
                            {{ $tratamiento->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('tratamientos_id')
                    <p class="mt-1 text-sm text-light-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo para la Fecha --}}
            <div>
                <label for="fecha" class="block text-sm font-medium text-light-text dark:text-dark-text mb-1">Fecha del Turno</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}" required
                       class="mt-1 block w-full p-3 border border-light-secondary rounded-md shadow-sm focus:ring-light-primary focus:border-light-primary dark:bg-zinc-700 dark:border-zinc-600 dark:text-dark-text">
                @error('fecha')
                    <p class="mt-1 text-sm text-light-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo para la Hora de Inicio --}}
            <div>
                <label for="hora_inicio" class="block text-sm font-medium text-light-text dark:text-dark-text mb-1">Hora de Inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required
                       class="mt-1 block w-full p-3 border border-light-secondary rounded-md shadow-sm focus:ring-light-primary focus:border-light-primary dark:bg-zinc-700 dark:border-zinc-600 dark:text-dark-text">
                @error('hora_inicio')
                    <p class="mt-1 text-sm text-light-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo para la Hora de Fin --}}
            <div>
                <label for="hora_fin" class="block text-sm font-medium text-light-text dark:text-dark-text mb-1">Hora de Fin</label>
                <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}" required
                       class="mt-1 block w-full p-3 border border-light-secondary rounded-md shadow-sm focus:ring-light-primary focus:border-light-primary dark:bg-zinc-700 dark:border-zinc-600 dark:text-dark-text">
                @error('hora_fin')
                    <p class="mt-1 text-sm text-light-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo para Comentario --}}
            <div>
                <label for="comentario" class="block text-sm font-medium text-light-text dark:text-dark-text mb-1">Comentario (Opcional)</label>
                <textarea name="comentario" id="comentario" rows="3"
                          class="mt-1 block w-full p-3 border border-light-secondary rounded-md shadow-sm focus:ring-light-primary focus:border-light-primary dark:bg-zinc-700 dark:border-zinc-600 dark:text-dark-text">{{ old('comentario') }}</textarea>
                @error('comentario')
                    <p class="mt-1 text-sm text-light-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón de Enviar --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-light-primary text-white font-semibold rounded-md shadow-md hover:bg-[#5A7AB5] dark:bg-dark-primary dark:hover:bg-[#7D9FDB] transition-colors duration-200">
                    Reservar Turno
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>