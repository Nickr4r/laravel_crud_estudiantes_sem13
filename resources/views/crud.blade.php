<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Estudiantes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#ABA38F] min-h-screen p-4 md:p-10">

<div class="max-w-7xl mx-auto">

    <!-- Header centrado -->
    <header class="mb-10 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-neutral-950 mb-3">
            Gestión de Estudiantes
        </h1>
        <p class="text-stone-500 text-lg">Sistema CRUD para administración de estudiantes</p>
    </header>

    <!-- Mensaje de éxito -->
    @if (session('mensaje'))
        <div id="success-message" class="max-w-2xl mx-auto flex items-center justify-between p-4 mb-8 rounded-xl bg-gradient-to-r from-lime-900/10 to-lime-900/5 border border-lime-900/20 shadow-sm">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-neutral-950 font-semibold">{{ session('mensaje') }}</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('success-message').remove()" class="text-stone-500 hover:text-neutral-950 transition-colors">
                ✕
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Panel de formulario -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl p-6 h-full border border-stone-500/20">
                <div class="mb-6 pb-4 border-b border-stone-500/20">
                    <h2 class="text-xl font-bold text-lime-900">
                        {{ $editar ? 'Editar Estudiante' : 'Nuevo Estudiante' }}
                    </h2>
                </div>

                @if ($editar)
                <div class="mb-5 px-4 py-3 bg-gradient-to-r from-lime-900/5 to-lime-900/10 border border-lime-900/20 rounded-lg">
                    <p class="text-lime-900 font-medium">
                        Modo edición activo
                    </p>
                </div>
                @endif

                <form action="{{ $editar ? '/actualizar/' . $editar->idEstudiante : '/guardar' }}" method="POST" id="student-form">
                    @csrf
                    
                    <div class="space-y-5">
                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-neutral-950 mb-2">
                                Nombre completo
                            </label>
                            <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre completo" required
                                   value="{{ $editar->nomEstudiante ?? old('nombre') }}"
                                   class="w-full p-3.5 border border-stone-500/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-lime-900 focus:border-lime-900 transition-all duration-300 bg-white hover:border-stone-500 text-neutral-950">
                            @error('nombre')
                                <p class="text-red-900 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="direccion" class="block text-sm font-semibold text-neutral-950 mb-2">
                                Dirección
                            </label>
                            <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección" required
                                   value="{{ $editar->dirEstudiante ?? old('direccion') }}"
                                   class="w-full p-3.5 border border-stone-500/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-lime-900 focus:border-lime-900 transition-all duration-300 bg-white hover:border-stone-500 text-neutral-950">
                            @error('direccion')
                                <p class="text-red-900 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="ciudad" class="block text-sm font-semibold text-neutral-950 mb-2">
                                Ciudad
                            </label>
                            <input type="text" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad" required
                                   value="{{ $editar->ciuEstudiante ?? old('ciudad') }}"
                                   class="w-full p-3.5 border border-stone-500/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-lime-900 focus:border-lime-900 transition-all duration-300 bg-white hover:border-stone-500 text-neutral-950">
                            @error('ciudad')
                                <p class="text-red-900 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" id="submit-btn" class="w-full bg-gradient-to-r from-lime-900 to-lime-800 hover:from-lime-800 hover:to-lime-700 text-white font-bold px-6 py-3.5 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                                {{ $editar ? 'Actualizar estudiante' : 'Guardar estudiante' }}
                            </button>
                            
                            @if ($editar)
                                <a href="/" class="w-full mt-4 block bg-stone-500/20 hover:bg-stone-500/30 text-neutral-950 font-bold px-6 py-3.5 rounded-xl text-center transition-all duration-300 border border-stone-500/30 hover:border-stone-500/40">
                                    Cancelar edición
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel de lista y búsqueda -->
        <div class="lg:col-span-2">
            <!-- Buscador -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-stone-500/20">
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-lime-900">
                        Buscar Estudiantes
                    </h2>
                </div>
                
                <form method="GET" action="/">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-grow">
                            <input type="text" name="buscar" placeholder="Buscar por nombre, ciudad o dirección..."
                                   value="{{ request('buscar') }}"
                                   class="w-full p-3.5 border border-stone-500/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-lime-900 focus:border-lime-900 transition-all duration-300 bg-white hover:border-stone-500 text-neutral-950">
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-lime-900 to-lime-800 hover:from-lime-800 hover:to-lime-700 text-white font-bold px-6 py-3.5 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                            Buscar
                        </button>
                        
                        @if(request('buscar'))
                            <a href="/" class="bg-stone-500/20 hover:bg-stone-500/30 text-neutral-950 font-bold px-6 py-3.5 rounded-xl text-center transition-all duration-300 border border-stone-500/30 hover:border-stone-500/40 flex items-center justify-center">
                                Limpiar
                            </a>
                        @endif
                    </div>
                    
                    @if(request('buscar'))
                        <div class="mt-5 p-3 bg-gradient-to-r from-lime-900/5 to-lime-900/10 rounded-lg border border-lime-900/20">
                            <p class="text-neutral-950 font-medium">
                                Mostrando resultados para: <span class="font-bold">"{{ request('buscar') }}"</span>
                            </p>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Lista de estudiantes -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-stone-500/20">
                <div class="p-6 border-b border-stone-500/20 bg-gradient-to-r from-lime-900/5 to-transparent">
                    <h2 class="text-xl font-bold text-lime-900">
                        Estudiantes Registrados
                    </h2>
                </div>
                
                @if($estudiantes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-lime-900/10 to-lime-900/5">
                                <tr>
                                    <th class="text-left py-4 px-6 text-lime-900 font-bold uppercase text-sm border-r border-stone-500/20">ID</th>
                                    <th class="text-left py-4 px-6 text-lime-900 font-bold uppercase text-sm border-r border-stone-500/20">Nombre</th>
                                    <th class="text-left py-4 px-6 text-lime-900 font-bold uppercase text-sm border-r border-stone-500/20">Dirección</th>
                                    <th class="text-left py-4 px-6 text-lime-900 font-bold uppercase text-sm border-r border-stone-500/20">Ciudad</th>
                                    <th class="text-left py-4 px-6 text-lime-900 font-bold uppercase text-sm">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-500/20">
                                @foreach ($estudiantes as $e)
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-100/50 hover:to-gray-100/30 transition-all duration-200 group">
                                        <td class="py-4 px-6 font-bold text-neutral-950 border-r border-stone-500/20 group-hover:border-stone-500/30">
                                            {{ $e->idEstudiante }}
                                        </td>
                                        <td class="py-4 px-6 font-medium text-neutral-950 border-r border-stone-500/20 group-hover:border-stone-500/30">{{ $e->nomEstudiante }}</td>
                                        <td class="py-4 px-6 text-neutral-950 border-r border-stone-500/20 group-hover:border-stone-500/30">{{ $e->dirEstudiante }}</td>
                                        <td class="py-4 px-6 text-neutral-950 border-r border-stone-500/20 group-hover:border-stone-500/30">{{ $e->ciuEstudiante }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex space-x-2">
                                                <a href="/?id={{ $e->idEstudiante }}"
                                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-lime-900/10 to-lime-900/5 hover:from-lime-900/20 hover:to-lime-900/15 text-lime-900 font-bold rounded-lg border border-lime-900/20 hover:border-lime-900/30 transition-all duration-300">
                                                    Editar
                                                </a>
                                                
                                                <form action="/eliminar/{{ $e->idEstudiante }}" method="POST" class="inline" onsubmit="return confirmDelete(event)">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-900/10 to-red-900/5 hover:from-red-900/20 hover:to-red-900/15 text-red-900 font-bold rounded-lg border border-red-900/20 hover:border-red-900/30 transition-all duration-300">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Estado vacío -->
                    <div class="text-center py-16 px-4">
                        <div class="mx-auto w-28 h-28 rounded-full bg-gradient-to-br from-gray-100 to-stone-500/20 flex items-center justify-center mb-8">
                            👥
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-950 mb-4">
                            @if(request('buscar'))
                                No se encontraron resultados
                            @else
                                No hay estudiantes registrados
                            @endif
                        </h3>
                        <p class="text-stone-500 mb-8 max-w-md mx-auto text-lg">
                            @if(request('buscar'))
                                No se encontraron estudiantes que coincidan con "{{ request('buscar') }}". Intenta con otros términos.
                            @else
                                Comienza agregando tu primer estudiante usando el formulario.
                            @endif
                        </p>
                        @if(request('buscar'))
                            <a href="/" class="inline-flex items-center bg-gradient-to-r from-lime-900 to-lime-800 hover:from-lime-800 hover:to-lime-700 text-white font-bold px-8 py-3.5 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                                Ver todos los estudiantes
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<!-- Scripts para mejoras de UI -->
<script>
    // Confirmación personalizada para eliminar
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target;
        
        if (confirm('¿Estás seguro de que deseas eliminar este estudiante? Esta acción no se puede deshacer.')) {
            form.submit();
        }
        
        return false;
    }
    
    // Validación de formulario
    document.getElementById('student-form')?.addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const direccion = document.getElementById('direccion').value.trim();
        const ciudad = document.getElementById('ciudad').value.trim();
        const submitBtn = document.getElementById('submit-btn');
        
        if (!nombre || !direccion || !ciudad) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos.');
            return;
        }
        
        // Cambiar texto del botón mientras se procesa
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Procesando...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
            
            // Restaurar después de 5 segundos por si hay un error
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75');
            }, 5000);
        }
    });
    
    // Auto-foco en el primer campo del formulario si estamos en modo creación
    @if(!$editar)
        document.addEventListener('DOMContentLoaded', function() {
            const nombreField = document.getElementById('nombre');
            if (nombreField) {
                setTimeout(() => {
                    nombreField.focus();
                }, 300);
            }
        });
    @endif
    
    // Mostrar/ocultar mensajes de éxito
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    if (successMessage.parentNode) {
                        successMessage.parentNode.removeChild(successMessage);
                    }
                }, 500);
            }, 5000);
        }
    });
</script>

</body>
</html>