<div class="p-6">

    <h1 class="text-3xl font-bold text-green-700 mb-6">Gestión de Alertas</h1>

    <button wire:click="abrirCrear"
        class="mb-4 px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
        Registrar nueva alerta
    </button>

    <div class="bg-green-50 p-4 rounded shadow">
        <table class="w-full">
            <thead>
                <tr class="bg-green-200 text-green-900">
                    <th class="p-2">Cultivo</th>
                    <th class="p-2">Sensor</th>
                    <th class="p-2">Parámetro</th>
                    <th class="p-2">Valor</th>
                    <th class="p-2">Rango</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Mensaje</th>
                    <th class="p-2">Fecha / hora</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($alertas as $a)
                    <tr class="border-b">
                        <td class="p-2">{{ $a->cultivo?->nombre }}</td>
                        <td class="p-2">{{ $a->sensor?->nombre }}</td>
                        <td class="p-2">{{ $a->parametro }}</td>
                        <td class="p-2">{{ $a->valor }}</td>
                        <td class="p-2">{{ $a->valor_min }} — {{ $a->valor_max }}</td>
                        <td class="p-2">{{ ucfirst($a->estado) }}</td>
                        <td class="p-2">{{ $a->mensaje }}</td>
                        <td class="p-2">{{ $a->fecha_hora }}</td>
                        <td class="p-2">
                            <button wire:click="abrirEditar({{ $a->id }})"
                                class="px-2 py-1 bg-blue-500 text-white rounded">Editar</button>
                            <button wire:click="eliminar({{ $a->id }})"
                                class="px-2 py-1 bg-red-500 text-white rounded">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-4 text-center text-gray-500" colspan="9">No hay alertas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    {{-- MODAL --}}
    @if($modal)
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded shadow-lg">

            <h2 class="text-xl font-bold text-green-700 mb-4">
                {{ $alerta_id ? 'Editar Alerta' : 'Registrar Alerta' }}
            </h2>

            <div class="grid grid-cols-2 gap-4">

                <!-- Cultivo -->
                <div>
                    <label class="font-semibold">Cultivo</label>
                    <select wire:model="cultivo_id" class="w-full border rounded p-2">
                        <option value="">Seleccione</option>
                        @foreach($cultivos as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sensor -->
                <div>
                    <label class="font-semibold">Sensor</label>
                    <select wire:model="sensor_id" class="w-full border rounded p-2">
                        <option value="">Seleccione</option>
                        @foreach($sensores as $s)
                            <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Parámetro -->
                <div>
                    <label class="font-semibold">Parámetro</label>
                    <input type="text" wire:model="parametro" class="w-full border rounded p-2">
                </div>

                <!-- Valor -->
                <div>
                    <label class="font-semibold">Valor</label>
                    <input type="number" wire:model="valor" class="w-full border rounded p-2">
                </div>

                <!-- Valor mínimo -->
                <div>
                    <label class="font-semibold">Valor mínimo</label>
                    <input type="number" wire:model="valor_min" class="w-full border rounded p-2">
                </div>

                <!-- Valor máximo -->
                <div>
                    <label class="font-semibold">Valor máximo</label>
                    <input type="number" wire:model="valor_max" class="w-full border rounded p-2">
                </div>

                <!-- Estado -->
                <div>
                    <label class="font-semibold">Estado</label>
                    <select wire:model="estado" class="w-full border rounded p-2">
                        <option value="advertencia">Advertencia</option>
                        <option value="critico">Crítico</option>
                    </select>
                </div>

                <!-- Fecha y hora -->
                <div>
                    <label class="font-semibold">Fecha y hora</label>
                    <input type="datetime-local" wire:model="fecha_hora" class="w-full border rounded p-2">
                </div>

                <!-- Mensaje -->
                <div class="col-span-2">
                    <label class="font-semibold">Mensaje</label>
                    <textarea wire:model="mensaje" class="w-full border rounded p-2"></textarea>
                </div>

            </div>

            <div class="flex justify-end mt-4">
                <button wire:click="$set('modal', false)"
                        class="px-4 py-2 bg-gray-500 text-white rounded mr-2">
                    Cancelar
                </button>

                <button wire:click="guardar"
                        class="px-4 py-2 bg-green-600 text-white rounded">
                    Guardar
                </button>
            </div>

        </div>
    </div>
    @endif

</div>