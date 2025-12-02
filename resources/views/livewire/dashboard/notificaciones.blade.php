<div class="p-6">

    <h2 class="text-2xl font-bold text-green-700 mb-4">Gestión de Notificaciones</h2>

    <button wire:click="abrirCrear"
        class="px-4 py-2 mb-4 bg-green-600 text-white rounded hover:bg-green-700">
        Nueva Notificación
    </button>

    <div class="bg-green-100 rounded-lg border border-green-300 overflow-x-auto">
        <table class="w-full text-sm text-gray-700">
            <thead class="bg-green-200">
                <tr>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Cultivo</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Título</th>
                    <th class="px-4 py-2">Mensaje</th>
                    <th class="px-4 py-2">Leída</th>
                    <th class="px-4 py-2">Fecha envío</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($notificaciones as $n)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $n->usuario->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $n->cultivo->nombre ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $n->tipo }}</td>
                    <td class="px-4 py-2">{{ $n->titulo }}</td>
                    <td class="px-4 py-2">{{ $n->mensaje }}</td>
                    <td class="px-4 py-2">
                        @if($n->leida)
                        <span class="text-green-700 font-bold">Sí</span>
                        @else
                        <span class="text-red-700 font-bold">No</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $n->fecha_envio }}</td>

                    <td class="px-4 py-2 space-x-2">
                        <button wire:click="abrirEditar({{ $n->id }})"
                            class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Editar
                        </button>

                        <button wire:click="eliminar({{ $n->id }})"
                            class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-700">
                        No hay notificaciones registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    @if($modal)
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">

        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg">
            <h2 class="text-xl font-bold mb-3 text-green-700">
                {{ $notificacion_id ? 'Editar Notificación' : 'Nueva Notificación' }}
            </h2>

            <div class="space-y-3">

                <div>
                    <label class="font-semibold">Usuario</label>
                    <select wire:model="usuario_id" class="w-full border rounded px-3 py-2">
                        <option value="">Seleccione</option>
                        @foreach($usuarios as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Cultivo</label>
                    <select wire:model="cultivo_id" class="w-full border rounded px-3 py-2">
                        <option value="">Seleccione</option>
                        @foreach($cultivos as $c)
                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Tipo</label>
                    <input type="text" wire:model="tipo" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="font-semibold">Título</label>
                    <input type="text" wire:model="titulo" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="font-semibold">Mensaje</label>
                    <textarea wire:model="mensaje" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div>
                    <label class="font-semibold">Fecha envío</label>
                    <input type="datetime-local" wire:model="fecha_envio"
                        class="w-full border rounded px-3 py-2">
                </div>

            </div>

            <div class="mt-4 flex justify-end space-x-2">
                <button wire:click="$set('modal', false)"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancelar
                </button>

                <button wire:click="guardar"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Guardar
                </button>
            </div>
        </div>

    </div>
    @endif

</div>