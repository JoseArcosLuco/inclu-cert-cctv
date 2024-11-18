<?php
include("./includes/Database.class.php");

require_once('./includes/Clientes.class.php');
require_once('./includes/Plantas.class.php');
require_once('./includes/Operadores.class.php');

$operadores = Operadores::get_all_operadores_without_turno();

if (isset($_GET['cliente'])) {
    $id = $_GET['cliente'];
    $cliente = Clientes::get_cliente_by_id($id);
    $plantas = Plantas::get_plantas_by_cliente_id($id);
};
?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="col-12"> <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-2">
                <!--begin::Header-->
                <div class="card-header d-flex justify-content-start align-items-center">
                    <div class="card-title col-6 col-md-8 fw-bold">Ingreso Reporte Diario</div>
                    <div class="card-title col-6 col-md-4 fw-bold d-flex justify-content-end""><?php echo $cliente['nombre']; ?></div>
                </div>
                <!--end::Header--> 
                <!--begin::Card-body-->
                <div class=" card-body w-100 d-flex flex-wrap row align-items-center justify-content-start">
                        <?php foreach ($plantas as $planta): ?>
                            <form class="col-12 col-md-4 mb-3" id="formReporte_<?php echo $planta['id']; ?>" name="formReporte_<?php echo $planta['id']; ?>">
                                <div class="d-flex flex-column justify-content-between align-items-start bg-secondary-subtle rounded p-4">
                                    <h4 class="m-0 mb-3 fw-medium text-capitalize"><?php echo $planta['nombre']; ?></h1>
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label w-100 d-flex gap-2 jusitify-content-between">N° de Cámaras:
                                                    <input
                                                        class="form-control"
                                                        type="text"
                                                        name="camaras_<?php echo $planta['id']; ?>"
                                                        id="camaras_<?php echo $planta['id']; ?>"
                                                        disabled
                                                        required
                                                        value="<?php echo $planta['camaras']; ?>">
                                                    <?php if ($planta['camaras'] == 0) {
                                                        echo '<a title="Agregar Cámaras" class="btn btn-info " href="' . $base_url . 'formularios.php?form=camaras&token=' . $token . '"><i class="material-icons">add</i></a>';
                                                    } ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label w-100">N° de Cámaras en Línea:
                                                    <input class="form-control" type="number" min="0" step="1" name="camaras_online_<?php echo $planta['id']; ?>" id="camaras_online_<?php echo $planta['id']; ?>" required>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label w-100">Estado:
                                                    <!--input class="form-control" type="number" name="canal_<? //php echo $planta['id']; 
                                                                                                                ?>" id="canal_<? //php echo $planta['id']; 
                                                                                                                                ?>" required-->
                                                    <select class="form-select" name="canal_<?php echo $planta['id']; ?>" id="canal_<?php echo $planta['id']; ?>" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="1">En Linea</option>
                                                        <option value="2">Intermitente/ Baja señal</option>
                                                        <option value="3">Reconector abierto</option>
                                                        <option value="4">Pérdida de red</option>
                                                        <option value="5">Pérdida de conexión sin confirmar</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label w-100">Operador:
                                                    <select class="form-select w-100" name="id_operador_<?php echo $planta['id']; ?>" id="id_operador_<?php echo $planta['id']; ?>" required>
                                                        <option value="">Seleccione</option>
                                                        <?php foreach ($operadores as $operador): ?>
                                                            <option value="<?php echo $operador['id'] ?>"><?php echo htmlspecialchars($operador['nombre']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label class="col-form-label w-100">Observación:
                                                    <textarea name="observacion_<?php echo $planta['id']; ?>" id="observacion_<?php echo $planta['id']; ?>" class="form-control" required></textarea>
                                                </label>
                                            </div>
                                        </div>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    </div>
                    <!-- end Card-body -->
                    <!-- begin Card-footer -->
                    <div class="card-footer d-flex gap-2">
                        <a href="<?php echo $base_url ?>/formularios.php?&form=periodico&token=<?php echo $token; ?>" class="btn btn-light">Volver</a>
                        <button
                            type="button"
                            id="btnGuardar"
                            class="btn btn-dark">
                            Guardar
                        </button>
                    </div>
                    <!-- end Card-footer -->
                    <!-- begin Modal-Success -->
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                </div>
                                <div class="modal-body col-12">
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end Modal-Success -->
                </div>
            </div>
        </div>
    </div> <!--end::Container-->
    <!-- begin::Script -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php foreach ($plantas as $planta): ?>
                $('#camaras_online_' + <?php echo $planta['id']; ?>).on('change', function() {
                    let camarasOnline = parseInt($(this).val(), 10);
                    let camaras = parseInt($('#camaras_' + <?php echo $planta['id']; ?>).val(), 10);
                    let modal = $('#warningModal .modal-dialog .modal-content');

                    if (isNaN(camarasOnline) || isNaN(camaras)) {
                        console.error("Error al convertir los valores de las cámaras a números.");
                        return;
                    }

                    if (camarasOnline > camaras) {
                        $('#camaras_online_<?php echo $planta['id']; ?>').val(camaras);
                        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Error en la Planta <?php echo $planta['nombre']; ?></h5>');
                        modal.find('.modal-body').append('<p class="bg-danger text-white text-center p-2 rounded mb-1">El valor de Camaras Online no puede ser mayor al valor de Camaras.</p> <p class="text-center p-2 m-0">Por favor, seleccione una valor menor o igual a ' + camaras + '.</p>');
                        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
                        $('#warningModal').modal('show');
                    }
                });
            <?php endforeach; ?>

            $('#warningModal').on('hidden.bs.modal', function() {
                var modal = $('#warningModal .modal-dialog .modal-content');
                modal.find('.modal-header h5').remove();
                modal.find('.modal-body p').remove();
                modal.find('.modal-footer button').remove();
            });

            $('#btnGuardar').click(function() {
                <?php foreach ($plantas as $planta): ?>
                    var formData = {
                        action: 'create_reporte',
                        id_cliente: <?php echo $cliente['id']; ?>,
                        id_planta: <?php echo $planta['id']; ?>,
                        id_operador: $.trim($("#id_operador_<?php echo $planta['id']; ?>").val()),
                        camaras_online: $.trim($("#camaras_online_<?php echo $planta['id']; ?>").val()),
                        camaras: $.trim($("#camaras_<?php echo $planta['id']; ?>").val()),
                        canal: $.trim($("#canal_<?php echo $planta['id']; ?>").val()),
                        observacion: $.trim($("#observacion_<?php echo $planta['id']; ?>").val())
                    };

                    $.ajax({
                        type: "POST",
                        url: "./ajax_handler/reportes.php",
                        data: formData,
                        datatype: "json",
                        encode: true,
                        success: function(data) {
                            let modal = $('.modal-body');
                            if (data.status) {
                                modal.empty();
                                modal.append('<p>' + data.message + '</p>');
                                modal.append('<p> Planta: <?php echo $planta['nombre']; ?></p>');
                                modal.append('<p> Fecha: ' + data.reporte.fecha + '</p>');
                                modal.append('<p> Camaras en Línea: ' + data.reporte.camaras_online + '</p>');
                                modal.append('<p> Canal: ' + data.reporte.canal + '</p>');
                                modal.append('<p> Observación: ' + data.reporte.observacion + '</p>');
                                modal.append('<a class="btn btn-primary" href="<?php echo $base_url ?>/formularios.php?&form=periodico&token=<?php echo $token; ?>">Ver Reportes</a>');
                                $('#successModal').modal('show');
                                $('#formReporte_<?php echo $planta['id']; ?>').trigger('reset');
                            } else {
                                modal.empty();
                                modal.append('<p>' + data.message + '</p>');
                                $('#successModal').modal('show');
                            }
                        }
                    });
                <?php endforeach; ?>
            });
        });
    </script>
    <!-- end::Script -->

    </body>

    </html>