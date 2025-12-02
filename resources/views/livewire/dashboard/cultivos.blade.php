<div class="p-8">

    <h1 class="text-3xl font-bold text-green-700 mb-6">
        Gestión de Cultivos
    </h1>

    <button wire:click="abrirCrear"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow mb-5 transition">
        Nuevo Cultivo
    </button>

    <div class="bg-white rounded-2xl shadow p-4 border border-gray-200">

        <table class="w-full border-collapse text-left">
            <thead>
            <tr class="bg-green-100 text-green-800">
                <th class="p-3">Cultivo</th>
                <th class="p-3">Productor</th>
                <th class="p-3">Suelo</th>
                <th class="p-3">Método Riego</th>
                <th class="p-3">Fecha Siembra</th>
                <th class="p-3">Acciones</th>
            </tr>
            </thead>

            <tbody>
            @foreach($cultivos as $c)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 font-semibold text-gray-700">{{ $c->nombre_cultivo }}</td>

                    <td class="p-3">
                        {{ $c->productor->nombre ?? '—' }}
                        {{ $c->productor->apellido ?? '' }}
                    </td>

                    <td class="p-3">
                        {{ $c->tipoSuelo->nombre ?? '—' }}
                    </td>

                    <td class="p-3">
                        {{ $c->metodoRiego->nombre ?? '—' }}
                    </td>

                    <td class="p-3">
                        {{ $c->fecha_siembra ?? '—' }}
                    </td>

                    <td class="p-3">
                        <button wire:click="abrirEditar({{ $c->id }})"
                                class="text-blue-600 hover:underline mr-3">
                            Editar
                        </button>

                        <button wire:click="eliminar({{ $c->id }})"
                                class="text-red-600 hover:underline">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    {{-- Modal --}}
    @if($modal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center backdrop-blur-sm">

            <div class="bg-white w-full max-w-3xl p-8 rounded-2xl shadow-xl overflow-y-auto max-h-[90vh]">

                <h2 class="text-2xl font-semibold text-green-700 mb-4">
                    {{ $cultivo_id ? 'Editar Cultivo' : 'Nuevo Cultivo' }}
                </h2>

                <form wire:submit.prevent="guardar" class="grid grid-cols-2 gap-4">

                    {{-- NOMBRE --}}
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Nombre del cultivo</label>
                        <input type="text" wire:model="nombre_cultivo" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- PRODUCTOR --}}
                    <div>
                        <label class="block text-sm font-medium">Productor</label>
                        <select wire:model="productor_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($productores as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellido }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TIPO SUELO --}}
                    <div>
                        <label class="block text-sm font-medium">Tipo de suelo</label>
                        <select wire:model="tipo_suelo_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($tipos_suelo as $ts)
                                <option value="{{ $ts->id }}">{{ $ts->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MÉTODO DE RIEGO --}}
                    <div>
                        <label class="block text-sm font-medium">Método de riego</label>
                        <select wire:model="metodo_riego_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($metodos_riego as $mr)
                                <option value="{{ $mr->id }}">{{ $mr->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TIPO SIEMBRA --}}
                    <div>
                        <label class="block text-sm font-medium">Tipo de siembra</label>
                        <select wire:model="tipo_siembra_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($tipos_siembra as $ts)
                                <option value="{{ $ts->id }}">{{ $ts->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- FUENTE DE AGUA --}}
                    <div>
                        <label class="block text-sm font-medium">Fuente de agua</label>
                        <select wire:model="tipo_fuente_agua_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($tipos_fuente_agua as $fa)
                                <option value="{{ $fa->id }}">{{ $fa->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ETAPA PLANTA --}}
                    <div>
                        <label class="block text-sm font-medium">Etapa de planta</label>
                        <select wire:model="etapa_planta_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($etapas_planta as $ep)
                                <option value="{{ $ep->id }}">{{ $ep->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ESTACIÓN --}}
                    <div>
                        <label class="block text-sm font-medium">Estación</label>
                        <select wire:model="estacion_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($estaciones as $es)
                                <option value="{{ $es->id }}">{{ $es->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- REGIÓN --}}
                    <div>
                        <label class="block text-sm font-medium">Región</label>
                        <select wire:model="region_id" class="w-full p-2 border rounded-lg">
                            <option value="">Seleccione...</option>
                            @foreach($regiones as $r)
                                <option value="{{ $r->id }}">{{ $r->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- FECHA SIEMBRA --}}
                    <div>
                        <label class="block text-sm font-medium">Fecha de siembra</label>
                        <input type="date" wire:model="fecha_siembra" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- AREA --}}
                    <div>
                        <label class="block text-sm font-medium">Área (m²)</label>
                        <input type="number" step="0.1" wire:model="area_m2" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- DENSIDAD --}}
                    <div>
                        <label class="block text-sm font-medium">Densidad de siembra</label>
                        <input type="number" wire:model="densidad_siembra" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- PROFUNDIDAD --}}
                    <div>
                        <label class="block text-sm font-medium">Profundidad de siembra (cm)</label>
                        <input type="number" step="0.1" wire:model="profundidad_siembra" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- UMBRAL --}}
                    <div>
                        <label class="block text-sm font-medium">Umbral de marchitez (%)</label>
                        <input type="number" step="0.1" wire:model="umbral_marchitez" class="w-full p-2 border rounded-lg">
                    </div>

                    {{-- BOTONES --}}
                    <div class="col-span-2 flex justify-end space-x-3 pt-4">
                        <button type="button"
                                wire:click="$set('modal', false)"
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
