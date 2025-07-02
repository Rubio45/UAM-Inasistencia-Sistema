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
                                <label class="block text-sm font-medium text-gray-700">Evidencia (PDF o imagen)</label>
                                <input type="file" name="evidencia" accept=".pdf,image/*"
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
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
});
</script>
@endpush 