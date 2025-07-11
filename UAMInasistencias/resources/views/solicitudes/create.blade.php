<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Nueva Solicitud') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('solicitudes.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Ausencia</label>
                                <input type="date" name="fechaAusencia" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Ausencia</label>
                                <select name="tipoAusencia" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="Enfermedad">Enfermedad</option>
                                    <option value="Emergencia Familiar">Emergencia Familiar</option>
                                    <option value="Problemas de Transporte">Problemas de Transporte</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Profesor</label>
                                <select name="profesor_id" id="profesor_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar profesor...</option>
                                    @foreach($profesores as $profesor)
                                        <option value="{{ $profesor->id }}">{{ $profesor->user->name }} {{ $profesor->apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asignatura</label>
                                <select name="asignatura_id" id="asignatura_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
                                    <option value="">Seleccionar asignatura...</option>
                                    @foreach($asignaturas as $asignatura)
                                        <option value="{{ $asignatura->id }}" data-profesor="{{ $asignatura->profesor_id }}">
                                            {{ $asignatura->nombre }} ({{ $asignatura->profesor->user->name }} {{ $asignatura->profesor->apellido }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Comentario</label>
                                <textarea name="comentario" rows="4" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Evidencias (PDF o imágenes)</label>
                                <div class="mt-1">
                                    <input type="file" name="evidencias[]" accept=".pdf,image/*" multiple
                                        class="block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                                        id="evidencias-input">
                                    <p class="mt-1 text-sm text-gray-500">Puedes seleccionar múltiples archivos. Máximo 10MB por archivo.</p>
                                </div>
                                
                                <!-- Vista previa de archivos seleccionados -->
                                <div id="evidencias-preview" class="mt-4 space-y-2 hidden">
                                    <h4 class="text-sm font-medium text-gray-700">Archivos seleccionados:</h4>
                                    <div id="evidencias-list" class="space-y-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800 transition">Crear Solicitud</button>
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
});
</script>
@endpush 