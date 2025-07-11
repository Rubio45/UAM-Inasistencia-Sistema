<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Solicitud') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('solicitudes.update', $solicitud) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Ausencia</label>
                                <input type="date" name="fechaAusencia" value="{{ $solicitud->fechaAusencia->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Ausencia</label>
                                <select name="tipoAusencia" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="Enfermedad" {{ $solicitud->tipoAusencia === 'Enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                                    <option value="Emergencia Familiar" {{ $solicitud->tipoAusencia === 'Emergencia Familiar' ? 'selected' : '' }}>Emergencia Familiar</option>
                                    <option value="Problemas de Transporte" {{ $solicitud->tipoAusencia === 'Problemas de Transporte' ? 'selected' : '' }}>Problemas de Transporte</option>
                                    <option value="Otro" {{ $solicitud->tipoAusencia === 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Profesor</label>
                                <select name="profesor_id" id="profesor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar profesor...</option>
                                    @foreach(\App\Models\Profesor::with('user')->get() as $profesor)
                                        <option value="{{ $profesor->id }}" {{ $solicitud->profesor_id == $profesor->id ? 'selected' : '' }}>
                                            {{ $profesor->user->name }} {{ $profesor->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asignatura</label>
                                <select name="asignatura_id" id="asignatura_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar asignatura...</option>
                                    @foreach(\App\Models\Asignatura::with('profesor.user')->get() as $asignatura)
                                        <option value="{{ $asignatura->id }}" 
                                                data-profesor="{{ $asignatura->profesor_id }}"
                                                {{ $solicitud->asignatura_id == $asignatura->id ? 'selected' : '' }}>
                                            {{ $asignatura->nombre }} ({{ $asignatura->profesor->user->name }} {{ $asignatura->profesor->apellido }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Comentario</label>
                                <textarea name="comentario" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">{{ $solicitud->comentario }}</textarea>
                            </div>
                            
                            <!-- Evidencias existentes -->
                            @if(count($solicitud->evidencias) > 0)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Evidencias existentes</label>
                                <div class="mt-2 space-y-2">
                                    @foreach($solicitud->evidencias as $index => $evidencia)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                        <div class="flex items-center space-x-3">
                                            @if(pathinfo($evidencia, PATHINFO_EXTENSION) === 'pdf')
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ basename($evidencia) }}</div>
                                                <a href="{{ asset('storage/' . $evidencia) }}" target="_blank" class="text-sm text-cyan-600 hover:text-cyan-800">Ver archivo</a>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                class="text-red-500 hover:text-red-700 eliminar-evidencia" 
                                                data-indice="{{ $index }}"
                                                data-solicitud="{{ $solicitud->id }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Nuevas evidencias -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Agregar nuevas evidencias (PDF o imágenes)</label>
                                <div class="mt-1">
                                    <input type="file" name="evidencias[]" accept=".pdf,image/*" multiple
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                                        id="evidencias-input">
                                    <p class="mt-1 text-sm text-gray-500">Puedes seleccionar múltiples archivos. Máximo 10MB por archivo.</p>
                                </div>
                                
                                <!-- Vista previa de archivos seleccionados -->
                                <div id="evidencias-preview" class="mt-4 space-y-2 hidden">
                                    <h4 class="text-sm font-medium text-gray-700">Archivos seleccionados:</h4>
                                    <div id="evidencias-list" class="space-y-2"></div>
                                </div>
                            </div>
                            
                            @if(Auth::user()->rol !== 'estudiante')
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <select name="estado" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="Pendiente" {{ $solicitud->estado === 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Aprobada" {{ $solicitud->estado === 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="Rechazada" {{ $solicitud->estado === 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Resolución (opcional)</label>
                                <input type="text" name="resolucion" value="{{ $solicitud->resolucion }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            @else
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-blue-800 text-sm">
                                        <strong>Estado actual:</strong> {{ $solicitud->estado }}
                                        @if($solicitud->resolucion)
                                            <br><strong>Resolución:</strong> {{ $solicitud->resolucion }}
                                        @endif
                                    </p>
                                    <p class="text-blue-600 text-xs mt-2">Solo el personal autorizado puede cambiar el estado de la solicitud.</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('solicitudes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
                            <button type="submit" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const profesorSelect = document.getElementById('profesor_id');
    const asignaturaSelect = document.getElementById('asignatura_id');
    const allOptions = Array.from(asignaturaSelect.options);
    const evidenciasInput = document.getElementById('evidencias-input');
    const evidenciasPreview = document.getElementById('evidencias-preview');
    const evidenciasList = document.getElementById('evidencias-list');

    // Manejo de selección de profesor y asignatura
    profesorSelect.addEventListener('change', function () {
        const profesorId = this.value;
        asignaturaSelect.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Seleccionar asignatura...';
        asignaturaSelect.appendChild(defaultOption);
        allOptions.forEach(option => {
            if (!option.value || option.getAttribute('data-profesor') === profesorId) {
                asignaturaSelect.appendChild(option.cloneNode(true));
            }
        });
    });

    // Manejo de vista previa de evidencias
    evidenciasInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        
        if (files.length > 0) {
            evidenciasPreview.classList.remove('hidden');
            evidenciasList.innerHTML = '';
            
            files.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg border';
                
                const fileInfo = document.createElement('div');
                fileInfo.className = 'flex items-center space-x-3';
                
                // Icono según tipo de archivo
                const icon = document.createElement('div');
                if (file.type.startsWith('image/')) {
                    icon.innerHTML = '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>';
                } else {
                    icon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>';
                }
                
                const fileDetails = document.createElement('div');
                fileDetails.innerHTML = `
                    <div class="text-sm font-medium text-gray-900">${file.name}</div>
                    <div class="text-sm text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                `;
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'text-red-500 hover:text-red-700';
                removeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeBtn.onclick = function() {
                    fileItem.remove();
                    if (evidenciasList.children.length === 0) {
                        evidenciasPreview.classList.add('hidden');
                    }
                };
                
                fileInfo.appendChild(icon);
                fileInfo.appendChild(fileDetails);
                fileItem.appendChild(fileInfo);
                fileItem.appendChild(removeBtn);
                evidenciasList.appendChild(fileItem);
            });
        } else {
            evidenciasPreview.classList.add('hidden');
        }
    });

    // Manejo de eliminación de evidencias existentes
    document.querySelectorAll('.eliminar-evidencia').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres eliminar esta evidencia?')) {
                const indice = this.getAttribute('data-indice');
                const solicitudId = this.getAttribute('data-solicitud');
                
                fetch(`/solicitudes/${solicitudId}/evidencia`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ indice: indice })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.flex').remove();
                    } else {
                        alert('Error al eliminar la evidencia');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar la evidencia');
                });
            }
        });
    });
});
</script>
@endpush 