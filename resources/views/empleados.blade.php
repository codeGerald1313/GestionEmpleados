<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>

    <!-- CSS de Bootstrap para estilos y diseño responsivo -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS de DataTables para mejorar la visualización de tablas -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- CSS de daterangepicker para seleccionar rangos de fechas -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <!-- Scripts de bibliotecas necesarias -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Estilos personalizados */
        .alert-fixed {
            position: fixed;
            /* Posición fija en la pantalla */
            top: 20px;
            right: 20px;
            z-index: 9999;
            /* Asegura que la alerta esté sobre otros elementos */
            display: none;
            /* Ocultar inicialmente */
        }

        .table .btn {
            margin: 0 2px;
            /* Espacio horizontal entre botones */
            min-width: 40px;
            /* Ancho mínimo para los botones */
            padding: 8px 12px;
            /* Aumentar el relleno de los botones */
            font-size: 14px;
            /* Aumentar el tamaño de la fuente */
        }

        .table .btn i {
            margin: 0;
            /* Remover márgenes del ícono */
            font-size: 16px;
            /* Tamaño del icono */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Gestión de Empleados</h1>
        <!-- Botón para agregar un nuevo empleado -->
        <button id="agregar-empleado" class="btn btn-success mb-3">Agregar Empleado</button>
        <!-- Filtros personalizados para búsqueda -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="buscar-fecha" class="form-control"
                    placeholder="Buscar por rango fecha de contratación">
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <input type="checkbox" id="filtrar-indefinido" class="mr-2">
                <label for="filtrar-indefinido">Filtrar por contratos indefinidos</label>
            </div>
        </div>
        <!-- Tabla para mostrar la lista de empleados -->
        <table id="tabla-empleados" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Área</th>
                    <th>Cargo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th class="text-center" style="width: 220px;">Acciones</th>
                    <!-- Ajustar el ancho de la columna de acciones -->
                </tr>
            </thead>
            <tbody id="empleados-lista">
                <!-- Aquí se cargarán los empleados con AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal para mostrar el detalle del empleado -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleModalLabel">Detalle del Empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los detalles del empleado -->
                    <h4 id="nombre-empleado"></h4>
                    <p><span id="dni-empleado"></span></p>
                    <p><span id="email-empleado"></span></p>
                    <p><span id="fecha-nacimiento-empleado"></span></p>
                    <h5>Datos Laborales</h5>
                    <p><span id="area-empleado"></span></p>
                    <p><span id="cargo-empleado"></span></p>
                    <p><span id="local-empleado"></span></p>
                    <h5>Contratos</h5>
                    <div id="contratos-empleado">
                        <!-- Los contratos se agregarán aquí dinámicamente -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas flotantes -->
    <div class="alert alert-success alert-fixed" id="alerta-exito">
        <strong>¡Éxito!</strong> Empleados listados con éxito.
    </div>

    <script>
        $(document).ready(function() {
            // Inicializar DataTables en la tabla de empleados
            var tablaEmpleados = $('#tabla-empleados').DataTable({
                "dom": '<"row"<"col-md-6"l><"col-md-6"f>>' + // Personaliza la disposición de los elementos
                    'rt' + // Tabla de datos
                    '<"row"<"col-md-5"i><"col-md-7"p>>', // Información y paginación
                "language": {
                    "search": "🔍 Área, Cargo o Datos del Empleado",
                    "lengthMenu": "Mostrar _MENU_ registros", // Cambia el texto del "Show entries"
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros", // Cambia el texto de la información
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    }
                }
            });

            // Mostrar alerta con retardo
            function mostrarAlerta(mensaje, tipo) {
                $('#alerta-exito').removeClass('alert-success alert-danger').addClass('alert-' + tipo).text(mensaje)
                    .fadeIn();
                setTimeout(function() {
                    $('#alerta-exito').fadeOut();
                }, 3000);
            }

            // Cargar empleados usando AJAX y DataTables
            function cargarEmpleados() {
                $.ajax({
                    url: '{{ route('empleados.index') }}', // Ruta para obtener la lista de empleados
                    method: 'GET',
                    success: function(response) {
                        tablaEmpleados.clear(); // Limpiar tabla antes de cargar nuevos datos
                        let correlativo = 1; // Iniciar el correlativo

                        response.data.forEach(function(empleado) {
                            // Generar el número correlativo en formato EMPL-001, EMPL-002, etc.
                            let numeroCorrelativo = '#' + ('000' + correlativo).slice(-3);

                            // Verificar si el empleado está de baja y definir los botones de acciones
                            var bajaBtn = empleado.baja ? '' :
                                `<button class="btn btn-warning btn-sm mr-1" onclick="darDeBajaEmpleado(${empleado.id})">
                        <i class="fas fa-user-slash"></i>
                    </button>`;

                            // Ocultar botón de editar si el empleado está de baja
                            var editarBtn = empleado.baja ? '' :
                                `<a href="{{ url('empleados') }}/${empleado.id}/edit" class="btn btn-warning btn-sm mr-1">
                        <i class="fas fa-edit"></i>
                    </a>`;

                            // Si el empleado está de baja, mostrar mensaje de desactivado
                            var datosLaborales = empleado.baja ? 'Empleado desactivado' :
                                `${empleado.datos_laborales ? empleado.datos_laborales.area : 'No asignado'}, 
                    ${empleado.datos_laborales ? empleado.datos_laborales.cargo : 'No asignado'}`;

                            var fechaInicio = empleado.baja ? 'N/A' :
                                (empleado.contratos[0] ? empleado.contratos[0].fecha_inicio :
                                    'N/A');

                            var fechaFin = empleado.baja ? 'N/A' :
                                (empleado.contratos[0] ? (empleado.contratos[0].fecha_fin ?
                                    empleado.contratos[0].fecha_fin : 'Indefinido') : 'N/A');

                            // Agregar fila a la tabla con los botones necesarios
                            tablaEmpleados.row.add([
                                numeroCorrelativo, // Usar el número correlativo en lugar del ID
                                empleado.nombres,
                                empleado.apellidos,
                                empleado.dni,
                                empleado.email,
                                datosLaborales, // Mostrar datos laborales o mensaje de desactivado
                                empleado.baja ? '' : (empleado.datos_laborales ?
                                    empleado.datos_laborales.cargo : 'No asignado'
                                ), // Cargo sólo si no está de baja
                                fechaInicio,
                                fechaFin,
                                `<div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-info btn-sm mr-1" onclick="verDetalleEmpleado(${empleado.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${editarBtn}
                        ${bajaBtn.trim() ? bajaBtn : ''}
                        <button class="btn btn-danger btn-sm" onclick="eliminarEmpleado(${empleado.id})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>`
                            ]).draw(false);

                            correlativo++; // Incrementar el correlativo
                        });
                        mostrarAlerta(response.message, 'success'); // Mostrar alerta de éxito
                    },
                    error: function() {
                        mostrarAlerta('Error al cargar los empleados.',
                            'danger'); // Mostrar alerta de error
                    }
                });
            }

            // Llamar a la función para cargar los empleados
            cargarEmpleados();

            // Redirigir a la página de creación de empleados
            $('#agregar-empleado').click(function() {
                window.location.href = '{{ route('empleados.create') }}'; // Navegar a la página de creación
            });

            // Función para mostrar el detalle de un empleado usando AJAX
            window.verDetalleEmpleado = function(id) {
                // Limpiar indicadores de baja y cualquier contenido previo del modal
                $('#nombre-empleado').text('');
                $('#dni-empleado').html('');
                $('#email-empleado').html('');
                $('#fecha-nacimiento-empleado').html('');
                $('#area-empleado').html('');
                $('#cargo-empleado').html('');
                $('#local-empleado').html('');
                $('#contratos-empleado').html('');
                $('#detalleModal .modal-body').find('.alert').remove(); // Limpiar alertas previas
                $('#activar-empleado').closest('.form-group').remove(); // Limpiar checkbox previo

                $.ajax({
                    url: '{{ url('empleados') }}/' + id, // Ruta para obtener los detalles del empleado
                    method: 'GET',
                    success: function(response) {
                        var empleado = response.data;

                        // Llenar los detalles básicos del empleado en el modal
                        $('#nombre-empleado').text(empleado.nombres + ' ' + empleado.apellidos);
                        $('#dni-empleado').html(`<strong>DNI:</strong> ${empleado.dni}`);
                        $('#email-empleado').html(`<strong>Email:</strong> ${empleado.email}`);
                        $('#fecha-nacimiento-empleado').html(
                            `<strong>Fecha de Nacimiento:</strong> ${empleado.fecha_nacimiento}`
                        );

                        // Verificar si el empleado está de baja
                        if (empleado.baja) {
                            // Mostrar el indicador de baja
                            var bajaHtml = `
                <div class="alert alert-danger mt-3" role="alert">
                    <i class="fas fa-exclamation-circle"></i> Este empleado está actualmente dado de baja.
                </div>`;
                            $('#detalleModal .modal-body').prepend(bajaHtml);

                            // Mostrar solo el checkbox para activar el empleado nuevamente
                            var activarCheckboxHtml = `
                <div class="form-group mt-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="activar-empleado" class="custom-control-input">
                        <label class="custom-control-label" for="activar-empleado">Activar Empleado</label>
                    </div>
                </div>`;
                            $('#detalleModal .modal-body').append(activarCheckboxHtml);

                            // Manejar el evento del checkbox para activar al empleado
                            $('#activar-empleado').on('change', function() {
                                if ($(this).is(':checked')) {
                                    Swal.fire({
                                        title: '¿Estás seguro?',
                                        text: "¿Quieres activar este empleado?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Sí, activar',
                                        cancelButtonText: 'Cancelar'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            activarEmpleado(empleado
                                                .id); // Activar empleado
                                        } else {
                                            // Desmarcar el checkbox si se cancela la activación
                                            $('#activar-empleado').prop('checked',
                                                false);
                                        }
                                    });
                                }
                            });
                        } else {
                            // Si el empleado no está de baja, mostrar los datos laborales y contratos
                            $('#area-empleado').html(
                                `<strong>Área:</strong> ${empleado.datos_laborales ? empleado.datos_laborales.area : 'No asignado'}`
                            );
                            $('#cargo-empleado').html(
                                `<strong>Cargo:</strong> ${empleado.datos_laborales ? empleado.datos_laborales.cargo : 'No asignado'}`
                            );
                            $('#local-empleado').html(
                                `<strong>Local:</strong> ${empleado.datos_laborales ? empleado.datos_laborales.local : 'No asignado'}`
                            );

                            // Generar los contratos del empleado
                            var contratosHtml = '';
                            empleado.contratos.forEach(function(contrato) {
                                contratosHtml += `
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Tipo de Contrato: ${contrato.tipo_contrato}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <strong>Fecha Inicio:</strong> ${contrato.fecha_inicio} <br>
                                <strong>Fecha Fin:</strong> ${contrato.fecha_fin ? contrato.fecha_fin : 'Indefinido'}
                            </p>
                        </div>
                    </div>`;
                            });
                            $('#contratos-empleado').html(
                                contratosHtml); // Agregar contratos al modal
                        }
                        mostrarAlerta(response.message, 'success'); // Mostrar mensaje de éxito

                        // Mostrar el modal con los datos cargados
                        $('#detalleModal').modal('show');
                    },
                    error: function() {
                        mostrarAlerta('Error al obtener los detalles del empleado.',
                            'danger'); // Mostrar alerta de error
                    }
                });
            };

            // Función para activar al empleado
            function activarEmpleado(id) {
                $.ajax({
                    url: '{{ url('empleados/activar') }}/' + id, // Ruta para activar al empleado
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para seguridad
                    },
                    success: function(response) {
                        // Mostrar mensaje de éxito con SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            // Recargar la lista de empleados o actualizar el modal
                            $('#detalleModal').modal('hide'); // Cerrar el modal
                            cargarEmpleados(); // Recargar la lista de empleados
                        });
                    },
                    error: function(xhr) {
                        // Mostrar mensaje de error con SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al activar al empleado. Inténtalo de nuevo.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            }

            // Función para dar de baja a un empleado
            window.darDeBajaEmpleado = function(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Quieres dar de baja a este empleado?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, dar de baja',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('empleados/darDeBaja') }}/' +
                                id, // Ruta para dar de baja
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para seguridad
                            },
                            success: function(response) {
                                // Mostrar mensaje de éxito con SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    cargarEmpleados
                                        (); // Recargar la lista de empleados
                                });
                            },
                            error: function(xhr) {
                                // Mostrar mensaje de error general con SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un error al dar de baja al empleado. Inténtalo de nuevo.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            };

            // Función para eliminar un empleado usando SweetAlert
            window.eliminarEmpleado = function(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará al empleado permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('empleados') }}/' + id, // Ruta para eliminar empleado
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para seguridad
                            },
                            success: function() {
                                cargarEmpleados(); // Recargar la lista de empleados
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Empleado eliminado',
                                    text: 'El empleado ha sido eliminado correctamente.',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al eliminar el empleado. Inténtalo de nuevo.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            };

            // Inicializar el selector de rango de fechas
            $('#buscar-fecha').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' a ',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    fromLabel: 'Desde',
                    toLabel: 'Hasta',
                    customRangeLabel: 'Personalizado',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                },
                opens: 'center',
                autoUpdateInput: false, // No actualizar el campo de entrada automáticamente
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Este año': [moment().startOf('year'), moment()],
                    'Últimos 6 meses': [moment().subtract(6, 'months'), moment()],
                    'Último año': [moment().subtract(1, 'year'), moment()]
                },
                showDropdowns: true,
                alwaysShowCalendars: true,
                startDate: moment().startOf('year'), // Establecer una fecha de inicio predeterminada
                endDate: moment(), // Establecer una fecha de fin predeterminada
            });

            // Evento para aplicar el rango de fechas seleccionado
            $('#buscar-fecha').on('apply.daterangepicker', function(ev, picker) {
                var fechaInicio = picker.startDate.format('YYYY-MM-DD'); // Obtener fecha de inicio
                var fechaFin = picker.endDate.format('YYYY-MM-DD'); // Obtener fecha de fin
                var typeFilter = $('#filtrar-indefinido').is(':checked') ? 'date_end_unideend' :
                    'date_end_in';

                // Asignar el rango seleccionado al campo de entrada
                $('#buscar-fecha').val(fechaInicio + ' a ' + fechaFin); // Actualiza el valor del campo

                // Llamar al backend para filtrar los datos con las fechas seleccionadas y el tipo de filtro
                $.ajax({
                    url: '/api/empleados/filtrar', // Ruta directa al endpoint en api.php
                    method: 'GET',
                    data: {
                        fecha_inicio: fechaInicio,
                        fecha_fin: fechaFin,
                        type_filter: typeFilter
                    },
                    success: function(response) {
                        // Limpiar la tabla antes de cualquier operación
                        tablaEmpleados.clear();

                        if (response.data.length > 0) {
                            // Si hay datos, agregarlos a la tabla
                            response.data.forEach(function(empleado) {
                                var bajaBtn = empleado.baja ? '' :
                                    '<button class="btn btn-warning btn-sm" onclick="darDeBajaEmpleado(' +
                                    empleado.id + ')">' +
                                    '<i class="fas fa-user-slash"></i></button> ';

                                var editarBtn = empleado.baja ? '' :
                                    '<a href="{{ url('empleados') }}/' + empleado.id +
                                    '/edit" class="btn btn-warning btn-sm">' +
                                    '<i class="fas fa-edit"></i></a> ';

                                var eliminarBtn =
                                    '<button class="btn btn-danger btn-sm" onclick="eliminarEmpleado(' +
                                    empleado.id + ')">' +
                                    '<i class="fas fa-trash-alt"></i></button>';

                                // Agregar fila a la tabla con los botones estilizados
                                tablaEmpleados.row.add([
                                    empleado.id,
                                    empleado.nombres,
                                    empleado.apellidos,
                                    empleado.dni,
                                    empleado.email,
                                    empleado.datos_laborales ? empleado
                                    .datos_laborales.area : 'No asignado',
                                    empleado.datos_laborales ? empleado
                                    .datos_laborales.cargo : 'No asignado',
                                    empleado.contratos[0] ? empleado.contratos[
                                        0].fecha_inicio : 'N/A',
                                    empleado.contratos[0] ? (empleado.contratos[
                                            0].fecha_fin ? empleado.contratos[0]
                                        .fecha_fin : 'Indefinido') : 'N/A',
                                    '<div class="d-flex justify-content-center align-items-center">' +
                                    // Usar un contenedor para alinear los botones
                                    '<button class="btn btn-info btn-sm" onclick="verDetalleEmpleado(' +
                                    empleado.id + ')">' +
                                    '<i class="fas fa-eye"></i></button> ' +
                                    editarBtn +
                                    bajaBtn +
                                    eliminarBtn +
                                    '</div>'
                                ]).draw(false);
                            });
                            mostrarAlerta(
                                'Empleados filtrados por rango de fechas de contratación.',
                                'success'); // Mensaje de éxito
                        } else {
                            // Si no hay datos, limpiar la tabla y mostrar una alerta de error
                            tablaEmpleados.clear()
                                .draw(); // Limpiar y redibujar la tabla para mostrarla vacía
                            mostrarAlerta(
                                'No hay empleados que se encuentren dentro del rango de fechas de contratación.',
                                'danger'); // Mensaje de error
                        }
                    },

                    error: function() {
                        mostrarAlerta('Error al filtrar empleados por rango de fechas.',
                            'danger'); // Mensaje de error
                    }
                });
            });

            // Limpiar el filtro cuando se cancela la selección
            $('#buscar-fecha').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val(''); // Limpiar el campo de entrada
                cargarEmpleados(); // Recargar todos los empleados
            });

        });
    </script>
</body>

</html>
