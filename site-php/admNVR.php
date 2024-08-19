<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Clientes.class.php');
require_once('./includes/Users.class.php');

$plantas = Plantas::get_all_plantas();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar NVR<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
                <h3 id="nombrePlanta"></h3>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Planta
                            </th>
                            <th>
                                Número Dispositivo
                            </th>
                            <th>
                                Serial
                            </th>
                            <th>
                                Estado
                            </th>
                            <th class="text-center">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div> <!-- /.card -->
        <!-- begin::Modal -->

        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Reporte</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formReporte" name="formReporte">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Planta:
                                            <input type="text" class="form-control" name="nombre_planta" id="nombre_planta" required disabled>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Número Dispositivo:
                                            <input type="number" class="form-control" name="num_dispositivo" id="num_dispositivo" requiered>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Serial:
                                                <input type="number" class="form-control" name="serial" id="serial" requiered>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado">
                                                <option value="1">En Línea</option>
                                                <option value="2">Retirado</option>
                                                <option value="3">Reemplazado</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                        </div>
                    </form>
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
        <!-- end::Modal -->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>

    let plantaId = <?php echo $_GET['planta']; ?>;

    var plantas = <?php echo json_encode($plantas); ?>;
    var plantasMap = {};

    plantas.forEach(function(planta) {
        plantasMap[planta.id] = planta.nombre;
    });
    $('#nombrePlanta').text(plantasMap[plantaId]);

    //Crear Reporte
    $("#addUser").click(function() {
        $('#formReporte').attr('data-action', 'create_nvr');
        $('#formReporte')[0].reset();
        $('#nombre_planta').val(plantasMap[plantaId]);
        $('#modalCRUD').modal('show');
    });

    //Editar Reporte
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaReporte.row($(this).parents('tr')).data();
        $('#id_cliente').prop('disabled', true);
        $('#id_planta').prop('disabled', true);
        $('#fecha_fin , #hora_fin, #hora').prop('disabled', false);
        $('#formReporte').attr('data-action', 'edit_reporte');
        $('#formReporte').attr('data-id', data.id);
        $('#id_cliente').val(data.id_cliente);
        $('#id_planta').empty();
        $('#id_planta').append('<?php foreach ($plantas as $planta): ?>');
        $('#id_planta').append('<option value="<?php echo $planta['id'] ?>" ><?php echo htmlspecialchars($planta['nombre']); ?></option>');
        $('#id_planta').append('<?php endforeach; ?>');
        $('#id_planta').val(data.id_planta);
        $('#fecha').val(moment(data.fecha, 'YYYY-MM-DD HH:mm:ss').format('yyyy-MM-DD'));
        $('#hora').val(moment(data.fecha).format('HH:mm'));
        $('#fecha_fin').val(moment(data.fecha_fin, 'YYYY-MM-DD HH:mm:ss').format('yyyy-MM-DD'));
        $('#hora_fin').val(moment(data.fecha_fin).format('HH:mm'));
        $('#observacion').val(data.observacion);
        $('#estado').val(data.estado);
        $('#modalCRUD .modal-title').val('Editar Reporte');

        $('#modalCRUD').modal('show');
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    //Eliminar Reporte
    $('#tabla tbody').on('click', '.btnBorrar', function() {
        var $row = $(this).closest('tr'); // Capturamos la fila correctamente
        var data = tablaReporte.row($row).data();
        var reporteId = data.id;
        var fecha = moment(data.fecha).format('DD-MM-YYYY');
        var hora = moment(data.fecha).format('HH:mm');
        var fecha_fin = moment(data.fecha_fin).format('DD-MM-YYYY');
        var hora_fin = moment(data.fecha_fin).format('HH:mm');
        var modal = $('#warningModal .modal-dialog .modal-content');

        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p class="col-6">Cliente: ' + clienteMap[data.id_cliente] + '</p>');
        modal.find('.modal-body').append('<p class="col-6">Planta: ' + plantasMap[data.id_planta] + '</p>');
        modal.find('.modal-body').append('<p>Fecha Inicial: ' + fecha + '</p>');
        modal.find('.modal-body').append('<p>Hora Inicial: ' + hora + '</p>');
        modal.find('.modal-body').append('<p>Fecha Termino: ' + fecha_fin + '</p>');
        modal.find('.modal-body').append('<p>Hora Termino: ' + hora_fin + '</p>');
        modal.find('.modal-body').append('<p>Autor Reporte: ' + usuariosMap[data.id_usuario] + '</p>');
        modal.find('.modal-body').append('<p>Estado: ' + (data.estado ? 'Activo' : 'Inactivo') + '</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function() {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/cortesInternet.php",
                data: {
                    action: 'delete_reporte',
                    id: reporteId
                },
                datatype: "json",
                encode: true,
                success: function(response) {
                    if (response.status) {
                        // Remover la fila de la tabla
                        tablaReporte.row($row).remove().draw();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Manejar errores de AJAX
                    console.log("Error en AJAX: " + textStatus, errorThrown);
                    alert("Error en la solicitud: " + textStatus);
                }
            });
        });
    });

    $(document).ready(function() {
        tablaReporte = $('#tabla').DataTable({
            responsive: true,
            "ajax": {
                "url": "./ajax_handler/nvr.php",
                "type": 'POST',
                "data": {
                    id: plantaId,
                    action: 'get_nvr'
                },
                "dataSrc": ""
            },
            "columns": [
                {
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "id_planta",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "numero_dispositivo"
                },
                {
                    "data": "serial"
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        if(data === 1) {
                            return 'En Línea';
                        } else if (data === 2){
                            return 'Retirado';
                        } else if (data === 3){
                            return 'Reemplazado';
                        }
                    }
                },
                {
                    "defaultContent": "<div class='text-center d-inline-block d-md-block'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"
                }
            ],
            "createdRow": function(row, data, dataIndex) {
                $(row).attr('data-id', data.id); // Añadir atributo data-id
            },
            "language": {
                "url": "./assets/json/espanol.json"
            }

        });
    });
</script>
<script>
    // fomrulario Subir/Editar cámaras

    $("#formReporte").submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id: id,
            id_planta: plantaId,
            num_dispositivo: $.trim($("#num_dispositivo").val()),
            serial: $.trim($("#serial").val()),
            estado: $.trim($("#estado").val())
        };
        $.ajax({
            type: "POST",
            url: "./ajax_handler/nvr.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_nvr') {
                        var newRow = tablaReporte.row.add({
                            "id": data.nvr.id,
                            "id_planta": data.nvr.id_planta,
                            "numero_dispositivo": data.nvr.numero_dispositivo,
                            "serial": data.nvr.serial,
                            "estado": data.nvr.estado,
                        }).draw().node();
                        $(newRow).attr('data-id', data.nvr.id);
                        $('#modalCRUD').modal('hide');

                    } else if (action === 'edit_reporte') {
                        var row = tablaReporte.row($('[data-id="' + id + '"]'));
                        row.data({
                            "id": id,
                            "id_planta": formData.id_planta,
                            "numero_dispositivo": formData.num_dispositivo,
                            "serial": formData.serial,
                            "estado": formData.estado,
                        }).draw();
                        $('#modalCRUD').modal('hide');

                    }

                } else {
                    alert(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejar errores de AJAX
                console.log("Error en AJAX: " + textStatus, errorThrown);
                alert("Error en la solicitud: " + textStatus);
            }
        });
    });
</script>
<!-- end::Script -->

</body>

</html>