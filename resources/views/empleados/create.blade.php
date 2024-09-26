<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Empleado</title>
    <!-- CSS de Bootstrap para estilos y diseño responsivo -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- SweetAlert CSS para estilos de alertas -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    
    <!-- Script de jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- SweetAlert JS para manejar las alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    
    <style>
        /* Estilos para los mensajes de error */
        .error-message {
            color: red; /* Color rojo para los mensajes de error */
            font-size: 0.9em; /* Tamaño de fuente más pequeño */
        }

        .is-invalid {
            border-color: red; /* Borde rojo para campos inválidos */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Crear Nuevo Empleado</h1>
        <!-- Contenedor para mostrar mensajes de error generales -->
        <div id="mensaje" class="mt-3"></div>
        <!-- Formulario con ID empleadoForm -->
        <form id="empleadoForm">
            @csrf <!-- Token CSRF para proteger contra ataques -->
            <div class="row">
                <!-- Sección de Datos Personales -->
                <div class="col-md-6">
                    <h4>Datos Personales</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" name="nombres" id="nombres" required>
                                <div class="error-message" id="error-nombres"></div> <!-- Mensaje de error para nombres -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                                <div class="error-message" id="error-apellidos"></div> <!-- Mensaje de error para apellidos -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" name="dni" id="dni" required>
                                <div class="error-message" id="error-dni"></div> <!-- Mensaje de error para DNI -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                                <div class="error-message" id="error-email"></div> <!-- Mensaje de error para email -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required>
                        <div class="error-message" id="error-fecha_nacimiento"></div> <!-- Mensaje de error para fecha de nacimiento -->
                    </div>
                </div>
                <!-- Sección de Datos Laborales -->
                <div class="col-md-6">
                    <h4>Datos Laborales</h4>
                    <div class="form-group">
                        <label for="area">Área:</label>
                        <select class="form-control" name="area" id="area" required>
                            <option value="">Selecciona un Área</option>
                            <option value="Recursos Humanos">Recursos Humanos</option>
                            <option value="IT">IT</option>
                            <option value="Ventas">Ventas</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Finanzas">Finanzas</option>
                            <!-- Agrega más opciones según lo necesario -->
                        </select>
                        <div class="error-message" id="error-area"></div> <!-- Mensaje de error para área -->
                    </div>
                    <div class="form-group">
                        <label for="cargo">Cargo:</label>
                        <select class="form-control" name="cargo" id="cargo" required>
                            <option value="">Selecciona un Cargo</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Asistente">Asistente</option>
                            <option value="Desarrollador">Desarrollador</option>
                            <option value="Analista">Analista</option>
                            <option value="Coordinador">Coordinador</option>
                            <!-- Agrega más opciones según lo necesario -->
                        </select>
                        <div class="error-message" id="error-cargo"></div> <!-- Mensaje de error para cargo -->
                    </div>
                    <div class="form-group">
                        <label for="local">Local:</label>
                        <select class="form-control" name="local" id="local" required>
                            <option value="">Selecciona un Local</option>
                            <option value="Lima">Lima</option>
                            <option value="Cusco">Cusco</option>
                            <option value="Arequipa">Arequipa</option>
                            <option value="Trujillo">Trujillo</option>
                            <option value="Piura">Piura</option>
                            <!-- Agrega más opciones según lo necesario -->
                        </select>
                        <div class="error-message" id="error-local"></div> <!-- Mensaje de error para local -->
                    </div>
                </div>
            </div>

            <!-- Datos del Contrato (ocupa 12 columnas en una fila) -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4>Datos del Contrato</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
                                <div class="error-message" id="error-fecha_inicio"></div> <!-- Mensaje de error para fecha de inicio -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin:</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
                                <div class="error-message" id="error-fecha_fin"></div> <!-- Mensaje de error para fecha de fin -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_contrato">Tipo de Contrato:</label>
                                <select class="form-control" name="tipo_contrato" id="tipo_contrato" required>
                                    <option value="">Selecciona un Tipo de Contrato</option>
                                    <option value="Indefinido">Indefinido</option>
                                    <option value="Temporal">Temporal</option>
                                    <option value="Prácticas">Prácticas</option>
                                    <option value="Por Proyecto">Por Proyecto</option>
                                    <option value="Freelance">Freelance</option>
                                    <!-- Agrega más opciones según lo necesario -->
                                </select>
                                <div class="error-message" id="error-tipo_contrato"></div> <!-- Mensaje de error para tipo de contrato -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón para enviar el formulario (alineado a la derecha y más grande) -->
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
            </div>

        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Capturar el evento submit del formulario
            $('#empleadoForm').on('submit', function(event) {
                event.preventDefault(); // Prevenir el envío tradicional

                // Limpiar mensajes de error anteriores
                $('.error-message').text('');
                $('.form-control').removeClass('is-invalid');

                // Obtener los datos del formulario
                var formData = $(this).serialize(); // Serializar datos del formulario

                // Realizar la solicitud AJAX
                $.ajax({
                    url: "{{ route('empleados.store') }}", // URL del método store
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
                            // Redirigir a la ruta principal (/)
                            window.location.href = "http://127.0.0.1:8000/";
                        });
                    },
                    error: function(xhr) {
                        // Mostrar mensaje de error general con SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al crear el empleado. Revisa los campos e intenta de nuevo.',
                            showConfirmButton: false,
                            timer: 3000 // Mostrar por 3 segundos
                        });

                        // Mostrar errores específicos en los campos
                        var errors = xhr.responseJSON.errors; // Captura errores devueltos por el servidor
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
