<div class="p-6">
    <h2 class="text-xl font-bold mb-4 text-center">Bienvenidos a la Clínica Dermatologica</h2>

    {{-- Mensajes de sesión (success/error) --}}
    @if(session('success'))
    <div class="mb-2 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="mb-2 p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    {{-- Contenedor principal para todas las imágenes y descripciones --}}
    {{-- Usamos flex-col para apilar las filas de cards verticalmente --}}
    <div class="flex flex-col items-center gap-8 mt-6"> {{-- Aumentado el gap para espacio entre filas --}}

        {{-- Primera fila de tres imágenes --}}
        <div class="flex justify-center gap-12"> {{-- gap-12 para separación horizontal entre cards --}}
            {{-- Card 1 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/HidrataciónProfundaconÁcidoHialurónico.jpg') }}" alt="Hidratación Profunda"
                    class="w-48 h-48 object-cover rounded-lg shadow-md
                    transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg
                    cursor-pointer">
                <p class="mt-2 text-center text-sm text-gray-700">Hidratación Profunda</p>
            </div>

            {{-- Card 2 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/LimpiezaFacialProfunda.jpg') }}" alt="Limpieza Facial Profunda"
                    class="w-48 h-48 object-cover rounded-lg shadow-md
                    transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg
                    cursor-pointer">
                <p class="mt-2 text-center text-sm text-gray-700">Limpieza Facial Profunda</p>
            </div>

            {{-- Card 3 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/aparatologia.jpg') }}" alt="Aparatología"
                    class="w-48 h-48 object-cover rounded-lg shadow-md
                    transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg
                    cursor-pointer">
                <p class="mt-2 text-center text-sm text-gray-700">Aparatología</p>
            </div>
        </div>

        {{-- Segunda fila de tres imágenes --}}
        <div class="flex justify-center gap-12"> {{-- gap-12 para separación horizontal entre cards --}}
            {{-- Card 4 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/cosmetologia.jpg') }}" alt="Cosmetología"
                    class="w-48 h-48 object-cover rounded-lg shadow-md
                    transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg
                    cursor-pointer">
                <p class="mt-2 text-center text-sm text-gray-700">Cosmetología</p>
            </div>

            {{-- Card 5 --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/ventajas.jpg') }}" alt="Ventajas"
                    class="w-48 h-48 object-cover rounded-lg shadow-md
                    transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg
                    cursor-pointer">
                <p class="mt-2 text-center text-sm text-gray-700">Ventajas del Tratamiento</p>
            </div>

            {{-- Card 6 (la última que tenías con object-contain) --}}
            <div class="flex flex-col items-center">
                <img src="{{ asset('images/PeelingQuímicoSuave.jpg') }}" alt="Peeling Químico Suave"
                    class="w-48 h-48 object-contain rounded-lg shadow-md
                    transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg
                    cursor-pointer">
                <p class="mt-2 text-center text-sm text-gray-700">Peeling Químico Suave</p>
            </div>
        </div>

    </div>

</div>