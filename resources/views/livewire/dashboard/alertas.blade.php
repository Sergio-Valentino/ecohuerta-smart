<div class="p-4">

    {{-- TÍTULO --}}
    <h1 class="text-2xl font-bold text-green-700 mb-4">
        Gestión de Alertas
    </h1>

    {{-- BOTÓN --}}
    <button
        wire:click="abrirCrear"
        class="mb-3 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
        Registrar nueva alerta
    </button>

    {{-- TABLA --}}
    <div class="bg-green-50 p-4 rounded-xl shadow">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-green-200 text-green-900">
                    <th class="p-2">Cultivo</th>
                    <th class="p-2">Sensor</th>
                    <th class="p-2">Parámetro</th>
                    <th class="p-2">Valor</th>
                    <th class="p-2">Valor mín.</th>
                    <th class="p-2">Valor máx.</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Mensaje</th>
                    <th class="p-2">Fecha / Hora</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($alertas as $a)
                    <tr class="border-b">
                        <td class="p-2">{{ $a->cultivo->nombre_cultivo ?? '-' }}</td>
                        <td class="p-2">{{ $a->sensor->nombre ?? '-' }}</td>
                        <td class="p-2">{{ $a->parametro }}</td>
                        <td class="p-2 text-center">{{ $a->valor }}</td>
                        <td class="p-2 text-center">{{ $a->valor_min }}</td>
                        <td class="p-2 text-center">{{ $a->valor_max }}</td>

                        {{-- ESTADO --}}
                        <td class="p-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($a->estado === 'critico') bg-red-100 text-red-700
                                @elseif($a->estado === 'advertencia') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700
                                @endif">
                                {{ ucfirst($a->estado) }}
                            </span>
                        </td>

                        <td class="p-2">{{ $a->mensaje }}</td>
                        <td class="p-2 whitespace-nowrap">
                            {{ $a->fecha_hora?->format('d/m/Y H:i') }}
                        </td>

                        {{-- ACCIONES --}}
                        <td class="p-2 whitespace-nowrap">
                            <button
                                wire:click="abrirEditar({{ $a->id }})"
                                class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-xs">
                                Editar
                            </button>

                            <button
                                wire:click="eliminar({{ $a->id }})"
                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-xs ml-1">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-4 text-center text-gray-500">
                            No hay alertas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL --}}
    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white w-1/2 p-6 rounded-xl shadow-lg">

                <h2 class="text-xl font-bold text-green-700 mb-4">
                    {{ $alerta_id ? 'Editar Alerta' : 'Registrar Alerta' }}
                </h2>

                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <label class="font-semibold">Cultivo</label>
                        <select wire:model="cultivo_id" class="w-full border rounded p-2">
                            <option value="">Seleccione</option>
                            @foreach ($cultivos as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_cultivo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Sensor</label>
                        <select wire:model="sensor_id" class="w-full border rounded p-2">
                            <option value="">Seleccione</option>
                            @foreach ($sensores as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Parámetro</label>
                        <input type="text" wire:model="parametro" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="font-semibold">Valor</label>
                        <input type="number" wire:model="valor" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="font-semibold">Valor mínimo</label>
                        <input type="number" wire:model="valor_min" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="font-semibold">Valor máximo</label>
                        <input type="number" wire:model="valor_max" class="w-full border rounded p-2">
                    </div>

                    {{-- ESTADO (NUEVO) --}}
                    <div>
                        <label class="font-semibold">Estado</label>
                        <select wire:model="estado" class="w-full border rounded p-2">
                            <option value="normal">Normal</option>
                            <option value="advertencia">Advertencia</option>
                            <option value="critico">Crítico</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Fecha y hora</label>
                        <input type="datetime-local" wire:model="fecha_hora" class="w-full border rounded p-2">
                    </div>

                    <div class="col-span-2">
                        <label class="font-semibold">Mensaje</label>
                        <textarea wire:model="mensaje" class="w-full border rounded p-2"></textarea>
                    </div>

                </div>

                <div class="flex justify-end mt-4">
                    <button
                        wire:click="$set('modal', false)"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2 hover:bg-gray-600">
                        Cancelar
                    </button>

                    <button
                        wire:click="guardar"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Guardar
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>