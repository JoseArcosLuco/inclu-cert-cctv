<?php
include("./includes/Database.class.php");

require_once('./includes/Turnos.class.php');
require_once('./includes/Users.class.php');
require_once('./includes/Operadores.class.php');

$select_users = Operadores::get_all_unasigned_users();
$users = Users::get_all_users();
$turnos = Turnos::get_all_turnos();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <div class="container d-flex gap-3">
                    <a href="<?php echo $base_url ?>/formularios.php?form=turnos&token=<?php echo $token; ?>" class="btn btn-light rounded-circle d-flex alignt-items-center jusitfy-content-center p-2" title="Volver" id="back"><i class="material-icons fs-3">arrow_back</i></a>
                    <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar NVR<i class="material-icons">add</i></button>
                </div>
                <h3 class="card-title m-0 p-0 d-flex align-items-center justify-content-end col-6" id="nombreTurno"></h3>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Turno
                            </th>
                            <th class="text-start">
                                Nombre Completo Operador
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Operador</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formReporte" name="formReporte" autocomplete="off">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Usuario:
                                            <select class="form-select" name="id_user" id="id_user" required>
                                                <option value="">Seleccione</option>
                                                <?php foreach ($select_users as $user) : ?>
                                                    <option value="<?php echo $user['id'] ?>"><?php echo $user['nombres'] . ' ' . $user['apellidos'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Buscar:
                                            <input type="text" class="form-control" name="search" id="search">
                                        </label>
                                        <div>
                                            <ul id="results" hidden class="list-group w-100"></ul>
                                        </div>
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
    let turnoId = <?php echo $_GET['turno']; ?>;

    var turnos = <?php echo json_encode($turnos); ?>;
    var turnosMap = {};

    turnos.forEach(function(turno) {
        turnosMap[turno.id] = turno.nombre;
    });

    var usuarios = <?php echo json_encode($users); ?>;
    var usuariosMap = {};

    usuarios.forEach(function(usuario) {
        usuariosMap[usuario.id] = usuario.nombres + ' ' + usuario.apellidos;
    });
    $('#nombreTurno').text(turnosMap[turnoId]);

    //Crear Operador
    $("#addUser").click(function() {
        $('#formReporte').attr('data-action', 'create_operador');
        $('#formReporte')[0].reset();
        $('#modalCRUD .modal-title').text('Agregar Operador');
        $('#modalCRUD').modal('show');
    });

    $('#search').on('input', function() {
        let searchValue = $(this).val();

        if (searchValue !== '') {
            $.ajax({
                type: 'POST',
                url: './ajax_handler/operador.php',
                data: {
                    action: 'search_operadores',
                    search: searchValue
                },
                dataType: 'json',
                success: function(data) {
                    $('#results').empty();

                    $('#results').prop('hidden', false);
                    $.each(data, function(index, user) {
                        $('#results').append('<li class="list-group-item list-group-item-action" data-id="' + user.id + '">' + user.nombres + ' ' + user.apellidos + '</li>');
                    });
                    $('#results li').on('click', function() {
                        let texto = $(this).text();
                        let id = $(this).data('id');
                        $('#results').empty();
                        $('#search').val(texto);
                        $('#id_user option[value="' + id + '"]').prop('selected', true);
                    });
                }
            });
        } else {
            $('#results').prop('hidden', true);
        }
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    //Eliminar Operador
    $('#tabla tbody').on('click','.btnBorrarOperador',function() {
        let $row = $(this).closest('tr'); // Capturamos la fila correctamente
        let data = tablaReporte.row($row).data();
        let operadorId = data.id;
        let usuarioId = data.id_users;
        var modal = $('#warningModal .modal-dialog .modal-content');

        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este operador del Turno? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p class="col-6">ID: ' + operadorId + '</p>');
        modal.find('.modal-body').append('<p class="col-6">Turno: ' + turnosMap[turnoId] + '</p>');
        modal.find('.modal-body').append('<p class="col-6">Nombre Completo: ' + usuariosMap[usuarioId] + '</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function() {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/operador.php",
                data: {
                    action: 'delete_operador',
                    id: operadorId,
                    id_user: usuarioId
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
                "url": "./ajax_handler/operador.php",
                "type": 'POST',
                "data": {
                    id: turnoId,
                    action: 'get_operadores'
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "id_turnos",
                    "render": function(data) {
                        return turnosMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "id_users",
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
                    },
                    "render": function(data) {
                        return usuariosMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": null,
                    "render": function() {
                        return "<div class='text-center d-inline-block d-md-block'><div class='btn-group'><button class='btn btn-warning d-flex align-items-center justify-content-center btn-sm btnBorrarOperador'><i class='material-icons'>do_not_disturb_on</i></button></div></div>"
                    }
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
            id_user: $.trim($('#id_user').val()),
            id_turno: turnoId,
        };
        $.ajax({
            type: "POST",
            url: "./ajax_handler/operador.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_operador') {
                        var newRow = tablaReporte.row.add({
                            "id": data.operador.id,
                            "id_turnos": data.operador.id_turnos,
                            "id_users": data.operador.id_users
                        }).draw().node();
                        $(newRow).attr('data-id', data.operador.id);
                        $('#modalCRUD').modal('hide');

                    } else if (action === 'edit_nvr') {
                        var row = tablaReporte.row($('[data-id="' + id + '"]'));
                        row.data({
                            "id": id,
                            "id_planta": formData.id_planta,
                            "numero_dispositivo": formData.num_dispositivo,
                            "serial": formData.serial,
                            "estado": data.nvr.estado
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