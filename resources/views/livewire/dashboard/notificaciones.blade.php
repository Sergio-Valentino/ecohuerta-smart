<div class="p-4">

    <h1 class="text-2xl font-bold text-green-700 mb-4">
        Gestión de Notificaciones
    </h1>

    {{-- BOTÓN NUEVO --}}
    <button
        wire:click="abrirCrear"
        class="mb-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
        Nueva Notificación
    </button>

    {{-- TABLA --}}
    <div class="bg-green-50 p-4 rounded-xl shadow">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-green-200 text-green-900">
                    <th class="p-2">Usuario</th>
                    <th class="p-2">Cultivo</th>
                    <th class="p-2">Tipo</th>
                    <th class="p-2">Título</th>
                    <th class="p-2">Mensaje</th>
                    <th class="p-2">Leída</th>
                    <th class="p-2">Fecha envío</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($notificaciones as $n)
                    <tr class="border-b">
                        <td class="p-2">{{ $n->usuario->name ?? '-' }}</td>
                        <td class="p-2">{{ $n->cultivo->nombre_cultivo ?? '-' }}</td>
                        <td class="p-2">{{ $n->tipo }}</td>
                        <td class="p-2">{{ $n->titulo }}</td>
                        <td class="p-2">{{ $n->mensaje }}</td>
                        <td class="p-2 text-center">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $n->leida ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $n->leida ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="p-2">
                            {{ $n->fecha_envio?->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <button
                                wire:click="abrirEditar({{ $n->id }})"
                                class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-xs mr-1">
                                Editar
                            </button>

                            <button
                                wire:click="eliminar({{ $n->id }})"
                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-4 text-center text-gray-500">
                            No hay notificaciones registradas.
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
                    {{ $notificacion_id ? 'Editar Notificación' : 'Nueva Notificación' }}
                </h2>

                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div>
                        <label class="font-semibold">Usuario</label>
                        <select wire:model="users_id" class="w-full border rounded p-2">
                            <option value="">Seleccione</option>
                            @foreach ($usuarios as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Cultivo</label>
                        <select wire:model="cultivos_id" class="w-full border rounded p-2">
                            <option value="">Seleccione</option>
                            @foreach ($cultivos as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_cultivo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Tipo</label>
                        <input type="text" wire:model="tipo" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="font-semibold">Título</label>
                        <input type="text" wire:model="titulo" class="w-full border rounded p-2">
                    </div>

                    <div class="col-span-2">
                        <label class="font-semibold">Mensaje</label>
                        <textarea wire:model="mensaje" class="w-full border rounded p-2"></textarea>
                    </div>

                    <div>
                        <label class="font-semibold">Fecha envío</label>
                        <input type="datetime-local" wire:model="fecha_envio" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="font-semibold">Leída</label>
                        <select wire:model="leida" class="w-full border rounded p-2">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-end mt-4">
                    <button
                        wire:click="$set('modal', false)"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md mr-2">
                        Cancelar
                    </button>

                    <button
                        wire:click="guardar"
                        class="px-4 py-2 bg-green-600 text-white rounded-md">
                        {{ $notificacion_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>