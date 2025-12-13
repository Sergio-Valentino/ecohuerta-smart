<div class="p-8">

    <h1 class="text-3xl font-bold text-green-700 mb-6">
        Gestión de Horarios
    </h1>

    <button wire:click="abrirCrear"
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow mb-5 transition">
        Nuevo Horario
    </button>

    <div class="bg-white rounded-2xl shadow p-4 border border-gray-200">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-green-100 text-green-800">
                    <th class="p-3">Cultivo</th>
                    <th class="p-3">Sensor</th>
                    <th class="p-3">Actuador</th>
                    <th class="p-3">Inicio</th>
                    <th class="p-3">Fin</th>
                    <th class="p-3">Frecuencia</th>
                    <th class="p-3">Días</th>
                    <th class="p-3">Activo</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($horarios as $h)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">{{ $h->cultivo->nombre_cultivo ?? '—' }}</td>
                        <td class="p-3">{{ $h->sensor->nombre ?? '—' }}</td>
                        <td class="p-3">{{ $h->actuador->nombre ?? '—' }}</td>

                        <td class="p-3">{{ $h->hora_inicio }}</td>
                        <td class="p-3">{{ $h->hora_fin }}</td>
                        <td class="p-3">{{ $h->frecuencia ?? '—' }}</td>
                        <td class="p-3">{{ $h->dias_semana ?? '—' }}</td>

                        <td class="p-3">
                            @if ($h->activo)
                                <span class="text-green-600 font-semibold">Sí</span>
                            @else
                                <span class="text-red-600 font-semibold">No</span>
                            @endif
                        </td>

                        <td class="p-3 flex space-x-3">
                            <button wire:click="abrirEditar({{ $h->id }})" class="text-blue-600 hover:underline">
                                Editar
                            </button>

                            <button wire:click="eliminar({{ $h->id }})" class="text-red-600 hover:underline">
                                Eliminar
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MODAL --}}
    @if ($modal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">
            <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-xl">

                <h2 class="text-2xl font-semibold text-green-700 mb-4">
                    {{ $horario_id ? 'Editar Horario' : 'Nuevo Horario' }}
                </h2>

                <form wire:submit.prevent="guardar" class="space-y-4">

                    {{-- CULTIVO --}}
                    <div>
                        <label class="block text-sm font-medium">Cultivo</label>
                        <select wire:model="cultivos_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach ($cultivos as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_cultivo }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SENSOR --}}
                    <div>
                        <label class="block text-sm font-medium">Sensor</label>
                        <select wire:model="sensores_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach ($sensores as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ACTUADOR --}}
                    <div>
                        <label class="block text-sm font-medium">Actuador</label>
                        <select wire:model="actuadores_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach ($actuadores as $a)
                                <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- HORA INICIO / FIN --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Hora Inicio</label>
                            <input type="time" wire:model="hora_inicio" class="w-full p-2 border rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Hora Fin</label>
                            <input type="time" wire:model="hora_fin" class="w-full p-2 border rounded-lg">
                        </div>
                    </div>

                    {{-- FRECUENCIA --}}
                    <div>
                        <label class="block text-sm font-medium">Frecuencia (minutos)</label>
                        <input type="number" wire:model="frecuencia" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- DIAS --}}
                    <div>
                        <label class="block text-sm font-medium">Días de la semana</label>
                        <input type="text" wire:model="dias_semana" class="w-full p-2 border rounded-lg"
                               placeholder="Ej: Lunes, Miércoles, Viernes">
                    </div>

                    {{-- ACTIVO --}}
                    <div class="flex items-center space-x-3">
                        <label class="text-sm font-medium">Activo</label>
                        <input type="checkbox" wire:model="activo" class="w-5 h-5">
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" wire:click="$set('modal', false)"
                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                            Cancelar
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Guardar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif
</div>