<div class="p-8">

    <h1 class="text-3xl font-bold text-green-700 mb-6">
        Gestión de Productores
    </h1>

    <button wire:click="abrirCrear"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow mb-5 transition">
        Nuevo Productor
    </button>

    <div class="bg-white rounded-2xl shadow p-4 border border-gray-200">

        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-green-100 text-green-800">
                    <th class="p-3">Nombre Finca</th>
                    <th class="p-3">Teléfono</th>
                    <th class="p-3">Región</th>
                    <th class="p-3">Localidad</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($productores as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $p->nombre_finca }}</td>
                    <td class="p-3">{{ $p->telefono }}</td>
                    <td class="p-3">{{ $p->region->nombre ?? '—' }}</td>
                    <td class="p-3">{{ $p->localidad->nombre ?? '—' }}</td>

                    <td class="p-3">
                        <button wire:click="abrirEditar({{ $p->id }})"
                                class="text-blue-600 hover:underline mr-3">
                            Editar
                        </button>

                        <button wire:click="eliminar({{ $p->id }})"
                                class="text-red-600 hover:underline">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    @if($modal)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">

        <div class="bg-white w-full max-w-lg p-8 rounded-2xl shadow-xl">

            <h2 class="text-2xl font-semibold text-green-700 mb-4">
                {{ $productor_id ? 'Editar Productor' : 'Nuevo Productor' }}
            </h2>

            <form wire:submit.prevent="guardar" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium">Nombre de la Finca</label>
                    <input type="text" wire:model="nombre_finca" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Teléfono</label>
                    <input type="text" wire:model="telefono" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Región</label>
                    <select wire:model="region_id" class="w-full p-2 border rounded-lg">
                        <option value="">Seleccione...</option>
                        @foreach($regiones as $r)
                            <option value="{{ $r->id }}">{{ $r->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Localidad</label>
                    <select wire:model="localidad_id" class="w-full p-2 border rounded-lg">
                        <option value="">Seleccione...</option>
                        @foreach($localidades as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button wire:click="$set('modal', false)"
                            type="button"
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