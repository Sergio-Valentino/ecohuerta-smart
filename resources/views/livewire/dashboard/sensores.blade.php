<div class="p-8">

    <h1 class="text-3xl font-bold text-green-700 mb-6">
        Gestión de Sensores
    </h1>

    <button wire:click="abrirCrear"
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow mb-5 transition">
        Nuevo Sensor
    </button>

    <div class="bg-white rounded-2xl shadow p-4 border border-gray-200">

        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-green-100 text-green-800">
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Tipo</th>
                    <th class="p-3">Ubicación</th>
                    <th class="p-3">Modelo</th>
                    <th class="p-3">Cultivo</th>
                    <th class="p-3">Activo</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sensores as $s)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $s->nombre }}</td>
                    <td class="p-3">{{ $s->tipo }}</td>
                    <td class="p-3">{{ $s->ubicacion }}</td>
                    <td class="p-3">{{ $s->modelo }}</td>
                    <td class="p-3">{{ $s->cultivo->nombre_cultivo ?? '—' }}</td>
                    <td class="p-3">
                        @if($s->activo)
                            <span class="text-green-600 font-semibold">Sí</span>
                        @else
                            <span class="text-red-600 font-semibold">No</span>
                        @endif
                    </td>

                    <td class="p-3">
                        <button wire:click="abrirEditar({{ $s->id }})"
                            class="text-blue-600 hover:underline mr-3">Editar</button>

                        <button wire:click="eliminar({{ $s->id }})"
                            class="text-red-600 hover:underline">Eliminar</button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    {{-- MODAL --}}
    @if($modal)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">

        <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-xl">

            <h2 class="text-2xl font-semibold text-green-700 mb-4">
                {{ $sensor_id ? 'Editar Sensor' : 'Nuevo Sensor' }}
            </h2>

            <form wire:submit.prevent="guardar" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium">Nombre</label>
                    <input type="text" wire:model="nombre" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Tipo</label>
                    <input type="text" wire:model="tipo" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Ubicación</label>
                    <input type="text" wire:model="ubicacion" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Modelo</label>
                    <input type="text" wire:model="modelo" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Usuario</label>
                    <select wire:model="usuario_id" class="w-full p-2 border rounded-lg">
                        <option value="">Seleccione...</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Cultivo</label>
                    <select wire:model="cultivo_id" class="w-full p-2 border rounded-lg">
                        <option value="">Seleccione...</option>
                        @foreach($cultivos as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre_cultivo }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Activo</label>
                    <select wire:model="activo" class="w-full p-2 border rounded-lg">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button wire:click="$set('modal', false)" type="button"
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
