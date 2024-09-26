<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>

    <!-- CSS de Bootstrap para estilos y diseño responsivo -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Script de jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- SweetAlert CSS para estilos de alertas -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">

    <!-- SweetAlert JS para manejar las alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <style>
        /* Estilos para los mensajes de error */
        .error-message {
            color: red;
            /* Color rojo para los mensajes de error */
            font-size: 0.9em;
            /* Tamaño de fuente más pequeño */
        }

        .is-invalid {
            border-color: red;
            /* Borde rojo para campos inválidos */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Editar Empleado</h1>
        <!-- Contenedor para mostrar mensajes de error generales -->
        <div id="mensaje" class="mt-3"></div>

        <!-- Formulario con ID empleadoEditForm -->
        <form id="empleadoEditForm">
            @csrf <!-- Token CSRF para proteger contra ataques -->
            @method('PUT') <!-- Necesario para la actualización -->
            <div class="row">
                <!-- Sección de Datos Personales -->
                <div class="col-md-6">
                    <h4>Datos Personales</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" name="nombres" id="nombres"
                                    value="{{ $empleado->nombres }}" required>
                                <div class="error-message" id="error-nombres"></div>
                                <!-- Mensaje de error para nombres -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos"
                                    value="{{ $empleado->apellidos }}" required>
                                <div class="error-message" id="error-apellidos"></div>
                                <!-- Mensaje de error para apellidos -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" name="dni" id="dni"
                                    value="{{ $empleado->dni }}" readonly> <!-- Bloquear el campo DNI -->
                                <div class="error-message" id="error-dni"></div> <!-- Mensaje de error para DNI -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ $empleado->email }}" required>
                                <div class="error-message" id="error-email"></div> <!-- Mensaje de error para email -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento"
                            value="{{ $empleado->fecha_nacimiento }}" required>
                        <div class="error-message" id="error-fecha_nacimiento"></div>
                        <!-- Mensaje de error para fecha de nacimiento -->
                    </div>
                </div>

                <!-- Sección de Datos Laborales -->
                <div class="col-md-6">
                    <h4>Datos Laborales</h4>
                    <div class="form-group">
                        <label for="area">Área:</label>
                        <select class="form-control" name="area" id="area" required>
                            <option value="">Selecciona un Área</option>
                            <option value="Recursos Humanos"
                                {{ $empleado->datosLaborales->area == 'Recursos Humanos' ? 'selected' : '' }}>Recursos
                                Humanos</option>
                            <option value="IT" {{ $empleado->datosLaborales->area == 'IT' ? 'selected' : '' }}>IT
                            </option>
                            <option value="Ventas" {{ $empleado->datosLaborales->area == 'Ventas' ? 'selected' : '' }}>
                                Ventas</option>
                            <option value="Marketing"
                                {{ $empleado->datosLaborales->area == 'Marketing' ? 'selected' : '' }}>Marketing
                            </option>
                            <option value="Finanzas"
                                {{ $empleado->datosLaborales->area == 'Finanzas' ? 'selected' : '' }}>Finanzas</option>
                            <!-- Agrega más opciones según lo necesario -->
                        </select>
                        <div class="error-message" id="error-area"></div> <!-- Mensaje de error para área -->
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo:</label>
                        <select class="form-control" name="cargo" id="cargo" required>
                            <option value="">Selecciona un Cargo</option>
                            <option value="Gerente"
                                {{ $empleado->datosLaborales->cargo == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                            <option value="Asistente"
                                {{ $empleado->datosLaborales->cargo == 'Asistente' ? 'selected' : '' }}>Asistente
                            </option>
                            <option value="Desarrollador"
                                {{ $empleado->datosLaborales->cargo == 'Desarrollador' ? 'selected' : '' }}>
                                Desarrollador</option>
                            <option value="Analista"
                                {{ $empleado->datosLaborales->cargo == 'Analista' ? 'selected' : '' }}>Analista
                            </option>
                            <option value="Coordinador"
                                {{ $empleado->datosLaborales->cargo == 'Coordinador' ? 'selected' : '' }}>Coordinador
                            </option>
                            <!-- Agrega más opciones según lo necesario -->
                        </select>
                        <div class="error-message" id="error-cargo"></div> <!-- Mensaje de error para cargo -->
                    </div>
                    <div class="form-group">
                        <label for="local">Local:</label>
                        <select class="form-control" name="local" id="local" required>
                            <option value="">Selecciona un Local</option>
                            <option value="Lima" {{ $empleado->datosLaborales->local == 'Lima' ? 'selected' : '' }}>
                                Lima</option>
                            <option value="Cusco" {{ $empleado->datosLaborales->local == 'Cusco' ? 'selected' : '' }}>
                                Cusco</option>
                            <option value="Arequipa"
                                {{ $empleado->datosLaborales->local == 'Arequipa' ? 'selected' : '' }}>Arequipa
                            </option>
                            <option value="Trujillo"
                                {{ $empleado->datosLaborales->local == 'Trujillo' ? 'selected' : '' }}>Trujillo
                            </option>
                            <option value="Piura"
                                {{ $empleado->datosLaborales->local == 'Piura' ? 'selected' : '' }}>Piura</option>
                            <!-- Agrega más opciones según lo necesario -->
                        </select>
                        <div class="error-message" id="error-local"></div> <!-- Mensaje de error para local -->
                    </div>
                </div>
            </div>

            <!-- Datos del Contrato -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Datos del Contrato</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio"
                                    value="{{ $empleado->contratos[0]->fecha_inicio }}" required>
                                <div class="error-message" id="error-fecha_inicio"></div>
                                <!-- Mensaje de error para fecha de inicio -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin:</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin"
                                    value="{{ $empleado->contratos[0]->fecha_fin }}">
                                <div class="error-message" id="error-fecha_fin"></div>
                                <!-- Mensaje de error para fecha de fin -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_contrato">Tipo de Contrato:</label>
                                <select class="form-control" name="tipo_contrato" id="tipo_contrato" required>
                                    <option value="">Selecciona un Tipo de Contrato</option>
                                    <option value="Indefinido"
                                        {{ $empleado->contratos[0]->tipo_contrato == 'Indefinido' ? 'selected' : '' }}>
                                        Indefinido</option>
                                    <option value="Temporal"
                                        {{ $empleado->contratos[0]->tipo_contrato == 'Temporal' ? 'selected' : '' }}>
                                        Temporal</option>
                                    <option value="Prácticas"
                                        {{ $empleado->contratos[0]->tipo_contrato == 'Prácticas' ? 'selected' : '' }}>
                                        Prácticas</option>
                                    <option value="Por Proyecto"
                                        {{ $empleado->contratos[0]->tipo_contrato == 'Por Proyecto' ? 'selected' : '' }}>
                                        Por Proyecto</option>
                                    <option value="Freelance"
                                        {{ $empleado->contratos[0]->tipo_contrato == 'Freelance' ? 'selected' : '' }}>
                                        Freelance</option>
                                    <!-- Agrega más opciones según lo necesario -->
                                </select>
                                <div class="error-message" id="error-tipo_contrato"></div>
                                <!-- Mensaje de error para tipo de contrato -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón para enviar el formulario (alineado a la derecha y más grande) -->
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Capturar el evento submit del formulario
            $('#empleadoEditForm').on('submit', function(event) {
                event.preventDefault(); // Prevenir el envío tradicional

                // Limpiar mensajes de error anteriores
                $('.error-message').text('');
                $('.form-control').removeClass('is-invalid');

                // Obtener los datos del formulario
                var formData = $(this).serialize(); // Serializar datos del formulario

                // Realizar la solicitud AJAX para actualizar
                $.ajax({
                    url: "{{ route('empleados.update', $empleado->id) }}", // URL del método update
                    method: 'POST', // Método HTTP
                    data: formData, // Datos del formulario
                    success: function(response) {
                        // Mostrar mensaje de éxito con SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message, // Mensaje del controlador
                            showConfirmButton: false,
                            timer: 2000 // Mostrar por 2 segundos
                        }).then(function() {
                            // Redirigir a la URL principal
                            window.location.href = "http://127.0.0.1:8000/";
                        });
                    },
                    error: function(xhr) {
                        // Mostrar mensaje de error general con SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al actualizar el empleado. Revisa los campos e intenta de nuevo.',
                            showConfirmButton: false,
                            timer: 3000 // Mostrar por 3 segundos
                        });

                        // Mostrar errores específicos en los campos
                        var errors = xhr.responseJSON
                            .errors; // Captura errores devueltos por el servidor
                        $.each(errors, function(key, value) {
                            // Agregar clase is-invalid al input correspondiente
                            $('input[name=' + key + '], select[name=' + key + ']')
                                .addClass('is-invalid');
                            // Mostrar mensaje de error debajo del input correspondiente
                            $('#error-' + key).text(value[0]);
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
