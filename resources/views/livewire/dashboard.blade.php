<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Dashboard EcoHuerta Smart</h2>

    <div class="bg-white shadow rounded p-4">
        <h3 class="font-semibold mb-2">Últimas lecturas recibidas</h3>

        <ul>
            @foreach($lecturas as $lectura)
                <li class="border-b py-1">
                    <strong>Sensor {{ $lectura->sensor_id }}:</strong>
                    {{ $lectura->valor }}
                    <span class="text-gray-500 text-sm">
                        ({{ $lectura->fecha_hora }})
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>