<div class="p-8">

    <h1 class="text-3xl font-bold text-green-700 mb-6">
        Gestión de Actuadores
    </h1>

    <button wire:click="abrirCrear"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow mb-5 transition">
        Nuevo Actuador
    </button>

    <div class="bg-white rounded-2xl shadow p-4 border border-gray-200">

        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-green-100 text-green-800">
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Tipo</th>
                    <th class="p-3">Ubicación</th>
                    <th class="p-3">Activo</th>
                    <th class="p-3">Cultivos asociados</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($actuadores as $a)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $a->nombre }}</td>
                    <td class="p-3">{{ $a->tipo }}</td>
                    <td class="p-3">{{ $a->ubicacion }}</td>

                    <td class="p-3">
                        @if($a->activo)
                            <span class="text-green-600 font-bold">Sí</span>
                        @else
                            <span class="text-red-600 font-bold">No</span>
                        @endif
                    </td>

                    <!-- Múltiples cultivos -->
                    <td class="p-3">
                        @forelse($a->cultivos as $c)
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs mr-1">
                                {{ $c->nombre_cultivo }}
                            </span>
                        @empty
                            <span class="text-gray-400">—</span>
                        @endforelse
                    </td>

                    <td class="p-3">
                        <button wire:click="abrirEditar({{ $a->id }})"
                                class="text-blue-600 hover:underline mr-3">
                            Editar
                        </button>

                        <button wire:click="eliminar({{ $a->id }})"
                                class="text-red-600 hover:underline">
                            Eliminar
                        </button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    {{-- MODAL --}}
    @if($modal)
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white w-full max-w-xl p-6 rounded-2xl shadow-xl">

            <h2 class="text-2xl font-semibold text-green-700 mb-4">
                {{ $actuador_id ? 'Editar Actuador' : 'Nuevo Actuador' }}
            </h2>

            <form wire:submit.prevent="guardar" class="space-y-4">

                <div>
                    <label class="block text-sm font-medium">Nombre</label>
                    <input type="text" wire:model="nombre"
                           class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Tipo</label>
                    <input type="text" wire:model="tipo"
                           class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Ubicación</label>
                    <input type="text" wire:model="ubicacion"
                           class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium">Activo</label>
                    <select wire:model="activo"
                            class="w-full p-2 border rounded-lg">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <!-- SELECT MULTIPLE -->
                <div>
                    <label class="block text-sm font-medium">Cultivos asociados</label>

                    <select wire:model="cultivos_ids" multiple
                        class="w-full p-2 border rounded-lg h-32">
                        @foreach($cultivos as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre_cultivo }}</option>
                        @endforeach
                    </select>

                    <p class="text-xs text-gray-500 mt-1">
                        Mantener Ctrl (Windows) o Cmd (Mac) para seleccionar varios.
                    </p>
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
