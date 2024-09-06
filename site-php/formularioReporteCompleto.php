<?php
include("./includes/Database.class.php");
require_once("./includes/Clientes.class.php");
require_once("./includes/Plantas.class.php");
require_once('./includes/Users.class.php');

$clientes = Clientes::get_all_clients();
$plantas = Plantas::get_all_plantas();
$users = Users::get_all_users();
?>


<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row g-2 p-2">
            <div class="col-md-3 col-xs-4 "> <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-2"> <!--begin::Header-->
                    <div class="card-header d-flex justify-content-start align-items-center">
                        <div class="card-title col-12">Buscar Cámaras</div>
                    </div> <!--end::Header--> <!--begin::Form-->
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label w-100">Fecha
                                <input type="date" class="form-control" id="fecha" name="fecha" disabled required value="<?php echo date("Y-m-d"); ?>">
                            </label>
                        </div>
                        <div class="mb-2">
                            <label class="form-label w-100">Cliente
                                <select class="form-select" name="id_cliente" id="id_cliente">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>
                        <div class="mb-2">
                            <label class="form-label w-100">Planta
                                <select class="form-control" name="planta" id="planta" required disabled>
                                    <option value="">Seleccione un Cliente</option>
                                </select>
                            </label>
                        </div>
                    </div> <!--end::Body--> <!--begin::Footer-->
                    <div class="card-footer">
                        <a href="<?php echo $base_url ?>/formularios.php?form=reporteCompleto&token=<?php echo $token; ?>" class="btn btn-secondary" id="cancelBtn" name="cancelBtn">Cancelar</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Enviar Reporte</button>
                    </div> <!--end::Footer-->
                    <div class="col-md-6" id="mensaje" name="mensaje">

                    </div>

                </div> <!--end::Quick Example--> <!--begin::Input Group-->

                <!--begin::Horizontal Form-->

            </div> <!--end::Col--> <!--begin::Col-->
            <div class="col-md-9">
                <div class="card card-danger card-outline mb-4">
                    <div class="card-header d-flex justify-content-start align-items-center">
                        <div class="card-title col-6">Gestión Cámaras</div>
                        <div class="card-title col-6 d-none justify-content-end" id="totalCamaras" name="totalCamaras">Total Cámaras:
                            <span class="badge bg-success" id="totalCamarasValue">
                            </span>
                        </div>
                    </div>
                    <div class="card-body" id="initialValue">
                        <p class="text-center text-black fw-bold bg-info rounded p-2">Seleccione una Planta</p>
                    </div>
                    <div class="card-body" id="plantaCamaras" name="plantaCamaras" hidden>

                    </div>
                </div>
            </div> <!--end::Col-->

            <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resultModalLabel">Exito</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo $base_url ?>/formularios.php?form=reporteCompleto&token=<?php echo $token; ?>" class="btn btn-primary">Ir a Reportes</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">Error</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo $base_url ?>/formularios.php?form=reporteCompleto&token=<?php echo $token; ?>" class="btn btn-primary">Ir a Reportes</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    //ver las plantas según el cliente ingresado
    $(document).ready(function() {

        var usuarios = <?php echo json_encode($users); ?>;
        var usuariosMap = {};

        usuarios.forEach(function(usuario) {
            usuariosMap[usuario.id] = usuario.nombres + ' ' + usuario.apellidos;
        });

        $('#id_cliente').change(function() {
            var id_cliente = $(this).val();
            $('#planta').prop('disabled', false);

            $.ajax({
                type: 'POST',
                url: './ajax_handler/reporteCompleto.php',
                data: {
                    id_cliente: id_cliente,
                    action: 'get_plantas'
                },
                dataType: 'json',
                success: function(data) {
                    var $plantaSelect = $('#planta');
                    $plantaSelect.empty();
                    $plantaSelect.append('<option value="">Seleccione</option>');
                    $.each(data, function(index, planta) {
                        $plantaSelect.append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error en AJAX:', textStatus, errorThrown);
                }
            });
        });

        //funcion para obtener camaras
        $('#planta').change(function() {
            let id_plantas = $(this).val();
            let id_cliente = $('#id_cliente').val();
            let info = $('#plantaCamaras');

            if (id_plantas !== '') {
                $.ajax({
                    type: 'POST',
                    url: './ajax_handler/reporteCompleto.php',
                    data: {
                        id_plantas: id_plantas,
                        action: 'get_plantas_camaras'
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#totalCamaras').removeClass('d-none');
                        $('#totalCamaras').addClass('d-flex');
                        $('#totalCamarasValue').text(data.length);

                        let operadoresArray = new Set();
                        data.forEach(function(item) {
                            if (item.operador == null) {
                                item.operador = null;
                            } else {
                                let operadores = item.operador.split(',');
                                operadores.forEach(function(operador) {
                                    operadoresArray.add(operador);
                                });
                            }
                        });
                        info.empty();
                        $('#initialValue').prop('hidden', true);
                        info.prop('hidden', false);

                        if (data.length === 0) {
                            info.append(`
                                <p class="text-center text-white bg-danger rounded p-4 fw-bold">Esta planta no posee Cámaras aun. Agregue Cámaras a la planta <a href="<?php echo $base_url ?>./formularios.php?form=camaras&token=<?php echo $token; ?>">aquí.</a></p>
                                `);
                        } else if (data[0].operador == null) {
                            info.append(`
                                <p class="text-center text-white bg-danger rounded p-4 fw-bold">Esta planta no posee ningún Operador. Agregue operadores a la planta <a href="<?php echo $base_url ?>/formularios.php?form=turnos&token=<?php echo $token; ?>">aquí.</a></p>
                                `);
                        } else {
                            $.each(data, function(index, camara) {
                                info.append(`
                                <form class="form mb-5" id="form_${camara.id}">
                                    <div class="container">
                                        <h5 class="text-center text-black bg-info rounded p-2 fw-bold">${camara.nombre}</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Operador:
                                                    <select class="form-select" name="turno" id="turno_${camara.id}" required>
                                                        <option value="">Seleccione</option>
                                                        ${Array.from(operadoresArray).map((operador) => `<option value="${operador}">${usuariosMap[operador]}</option>`).join('')}
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label w-100">N° Cámara / NVR:
                                                    <input type="number" class="form-control" id="camaras_${camara.id}" value="${camara.id}" disabled required>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Estado:
                                                    <select class="form-select" id="estado_${camara.id}" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="1">En Línea</option>
                                                        <option value="2">Intermitente</option>
                                                        <option value="3">Sin Conexión</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Visual:
                                                    <select class="form-select" id="visual_${camara.id}">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Clara</option>
                                                        <option value="2">Desenfocada</option>
                                                        <option value="3">Obstruida</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Analíticas:
                                                    <select class="form-select" id="analiticas_${camara.id}">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activas</option>
                                                        <option value="2">Inactivas</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Recorrido:
                                                    <select class="form-select" id="recorrido_${camara.id}">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activo</option>
                                                        <option value="2">Inactivo</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Evento:
                                                    <select class="form-select" id="evento_${camara.id}">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activo</option>
                                                        <option value="2">Inactivo</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Grabaciones:
                                                    <input type="number" class="form-control grabaciones-input" id="grabaciones_${camara.id}">
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label w-100">Observación:
                                                    <textarea class="form-control" id="observacion_${camara.id}" rows="1"></textarea>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                `);
                            });
                        }

                        $('.grabaciones-input').on('change', function() {
                            const value = parseInt($(this).val());
                            if (value < 0 || isNaN(value)) {
                                mostrarError('El número de grabaciones debe ser mayor o igual a 0');
                                $(this).val('');
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Error en AJAX:', textStatus, errorThrown);
                    }
                });
            } else {
                info.empty();
                $('#initialValue').prop('hidden', false);
                info.prop('hidden', true);
                $('#totalCamaras').removeClass('d-flex');
                $('#totalCamaras').addClass('d-none');
            }
        });

        $('#submitBtn').click(function() {
            id_usuario = <?php echo $id_usuario; ?>;
            let valid = true;

            $('.form').each(function() {
                const form = $(this)[0];
                if (!form.checkValidity()) {
                    $(this).addClass('was-validated');
                    valid = false;
                    return false;
                }
            });

            if (valid) {
                $.ajax({
                    type: 'POST',
                    url: './ajax_handler/reporteCompleto.php',
                    data: {
                        action: 'guardarReportesGral',
                        usuario_id: id_usuario,
                        planta_id: $('#planta').val(),
                        fecha: $('#fecha').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            id_insertado = response.lastInsertId;
                            let totalFormularios = $('.form').length;
                            let formulariosCompletados = 0;
                            let exitosos = 0;
                            let errorEncontrado = null;

                            $('.form').each(function() {
                                let camaraId = $(this).attr('id').split('_')[1];
                                let formData = {
                                    action: 'guardarReportes',
                                    id_operador: $.trim($('#turno_' + camaraId).val()),
                                    id_camara: $.trim($('#camaras_' + camaraId).val()),
                                    estado: $.trim($('#estado_' + camaraId).val()),
                                    visual: $.trim($('#visual_' + camaraId).val()),
                                    analiticas: $.trim($('#analiticas_' + camaraId).val()),
                                    recorrido: $.trim($('#recorrido_' + camaraId).val()),
                                    evento: $.trim($('#evento_' + camaraId).val()),
                                    grabaciones: $.trim($('#grabaciones_' + camaraId).val()),
                                    observacion: $.trim($('#observacion_' + camaraId).val()),
                                    id_insertado: id_insertado
                                };

                                $.ajax({
                                    type: 'POST',
                                    url: './ajax_handler/reporteCompleto.php',
                                    data: formData,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status) {
                                            exitosos++;
                                        } else {
                                            errorEncontrado = response.message;
                                        }
                                        formulariosCompletados++;

                                        if (formulariosCompletados === totalFormularios) {
                                            mostrarResumen(exitosos, errorEncontrado);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        errorEncontrado = 'Error en AJAX: ' + textStatus;
                                        formulariosCompletados++;

                                        if (formulariosCompletados === totalFormularios) {
                                            mostrarResumen(exitosos, errorEncontrado);
                                        }
                                    }
                                });
                            });
                        } else {
                            mostrarError('Hubo un problema al guardar la información general.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        mostrarError('Error en AJAX: ' + textStatus);
                    }
                });
            }
        });

        function mostrarResumen(exitosos, errorEncontrado) {
            let modalBody = $('#resultModal .modal-body');
            modalBody.empty();

            if (errorEncontrado) {
                modalBody.append('<p>No se agregaron reportes por el siguiente error: ' + errorEncontrado + '</p>');
            } else {
                modalBody.append('<p>Se agregaron ' + exitosos + ' reportes a la tabla con éxito.</p>');
            }

            $('#resultModal').modal('show');
        }

        function mostrarError(mensaje) {
            let modalBody = $('#errorModal .modal-body');
            modalBody.empty();
            modalBody.append('<p>' + mensaje + '</p>');
            $('#errorModal').modal('show');
        }
    });
</script>