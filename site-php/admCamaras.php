<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Clientes.class.php');

$clientes = Clientes::get_all_clients();
$plantas = Plantas::get_all_plantas();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center ms-2 mb-3 justify-content-start gap-2">
                <div class="col-2">
                    <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-start gap-2 fs-5" id="addUser">Agregar Cámara<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
                </div>
                <label class="card-title col-2 p-0">Cliente:
                    <select class="form-select" name="id_cliente" id="id_cliente">
                        <option value="" selected>Ver Todos</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="card-title col-2 p-0">Planta:
                    <select class="form-select" name="id_planta" id="id_planta" disabled>
                        <option value="">Seleccione un Cliente</option>
                    </select>
                </label>
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
                                Nombre
                            </th>
                            <th>
                                Modelo
                            </th>
                            <th>
                                Tipo de Cámara
                            </th>
                            <th>
                                SN
                            </th>
                            <th class="text-center">
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Cámaras</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form id="formCamara" name="formCamara">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Modelo:
                                            <input type="text" class="form-control" id="modelo" name="modelo">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Tipo Cámara:
                                            <input type="text" class="form-control" id="tipo_camara" name="tipo_camara">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">SN:
                                            <input type="text" class="form-control" id="sn" name="sn">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Cliente:
                                                <select class="form-select" name="cliente" id="cliente">
                                                    <option value="">Seleccionar</option>
                                                    <?php foreach ($clientes as $cliente) : ?>
                                                        <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Planta:
                                                <select class="form-select" name="id_plantas" id="id_plantas" disabled>
                                                    <option value="">Seleccione un Cliente</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado">
                                                <option value="1">Activa</option>
                                                <option value="0">Inactiva</option>
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
<script>
    $('#id_cliente').change(function() {
        let id = $(this).val();
        if (id !== '') {
            $('#id_planta').prop('disabled', false);
        } else {
            $('#id_planta').prop('disabled', true);
        }

        $.ajax({
            type: "POST",
            url: "./ajax_handler/camaras.php",
            data: {
                action: 'updateClienteSelect',
                id: id
            },
            dataType: "json",
            success: function(data) {
                $('#id_planta').empty();
                $('#id_planta').append('<option value="">Seleccione</option>');
                data.forEach(function(planta) {
                    $('#id_planta').append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                });

                tablaCamaras.ajax.reload();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#cliente').change(function() {
        var id = $(this).val();

        if (id !== '') {
            $('#id_plantas').prop('disabled', false);
        } else {
            $('#id_plantas').prop('disabled', true);
        }

        $.ajax({
            type: "POST",
            url: "./ajax_handler/cortesInternet.php",
            data: {
                action: 'get_plantas',
                id: id
            },
            datatype: "json",
            success: function(data) {
                $('#id_plantas').empty();
                $('#id_plantas').append('<option value="">Seleccionar</option>');
                data.forEach(function(planta) {
                    $('#id_plantas').append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                });
            }
        })
    })

    $('#id_planta').change(function() {
        tablaCamaras.ajax.reload();
    });

    //Crear Camara
    $("#addUser").click(function() {

        const cliente = $('#id_cliente').val();
        const planta = $('#id_planta').val();

        $('#formCamara').attr('data-action', 'create_camara');
        $('#formCamara')[0].reset();
        if (cliente !== '') {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/cortesInternet.php",
                data: {
                    action: 'get_plantas',
                    id: cliente
                },
                datatype: "json",
                success: function(data) {
                    $('#id_plantas').empty();
                    $('#id_plantas').append('<option value="">Seleccionar</option>');
                    data.forEach(function(planta) {
                        $('#id_plantas').append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                    });
                    $('#cliente').val(cliente);
                    $('#id_plantas').prop('disabled', false);
                    if (planta !== '') {
                        $('#id_plantas').val(planta);
                    }
                }
            })
        }

        $('#modalCRUD .modal-title').text('Agregar Cámaras');
        $('#modalCRUD').modal('show');
    });

    //Editar Camara
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaCamaras.row($(this).parents('tr')).data();
        $('#formCamara').attr('data-action', 'edit_camara');
        $('#formCamara').attr('data-id', data.id);
        $('#id_plantas').val(data.id_plantas);
        $('#nombre').val(data.nombre);
        $('#modelo').val(data.modelo);
        $('#tipo_camara').val(data.tipo_camara);
        $('#sn').val(data.sn);
        $('#estado').val(data.estado);
        $('#modalCRUD .modal-title').text('Editar Cámara');

        $('#modalCRUD').modal('show');
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });
    //Eliminar Camara
    $('#tabla tbody').on('click', '.btnBorrar', function() {
        var $row = $(this).closest('tr'); // Capturamos la fila correctamente
        var data = tablaCamaras.row($row).data();
        var camaraId = data.id;

        var modal = $('#warningModal .modal-dialog .modal-content');

        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p>ID: ' + data.id + '</p>');
        modal.find('.modal-body').append('<p>Planta: ' + plantasMap[data.id_plantas] + '</p>');
        modal.find('.modal-body').append('<p>Nombre: ' + data.nombre + '</p>');
        modal.find('.modal-body').append('<p>Modelo: ' + data.modelo || 'Desconocido' + '</p>');
        modal.find('.modal-body').append('<p>Tipo de Cámara: ' + data.tipo_camara || 'Desconocido' + '</p>');
        modal.find('.modal-body').append('<p>SN: ' + data.sn || 'Desconocido' + '</p>');
        modal.find('.modal-body').append('<p>Estado: ' + (data.estado ? 'Activo' : 'Inactivo') + '</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function() {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/camaras.php",
                data: {
                    action: 'delete_camara',
                    id: camaraId
                },
                datatype: "json",
                encode: true,
                success: function(response) {
                    if (response.status) {
                        // Remover la fila de la tabla
                        tablaCamaras.row($row).remove().draw();
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

    var plantas = <?php echo json_encode($plantas); ?>;
    var plantasMap = {};

    // Convertir el array de perfiles a un mapa para un acceso más rápido
    plantas.forEach(function(planta) {
        plantasMap[planta.id] = planta.nombre;
    });

    $(document).ready(function() {
        tablaCamaras = $('#tabla').DataTable({
            responsive: true,
            "ajax": {
                "url": "./ajax_handler/camaras.php",
                "type": 'POST',
                "data": function(d) {
                    let data = {
                        action: 'get_camaras'
                    };
                    data.cliente = $('#id_cliente').val();
                    data.planta = $('#id_planta').val();
                    return data;
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
                    "data": "id_plantas",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "nombre",
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "modelo",
                    "render": function(data) {
                        return data || 'Desconocido';
                    }
                },
                {
                    "data": "tipo_camara",
                    "render": function(data) {
                        return data || 'Desconocido';
                    }
                },
                {
                    "data": "sn",
                    "render": function(data) {
                        return data || 'Desconocido';
                    }
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
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

    $("#formCamara").submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id: id,
            id_planta: $.trim($("#id_plantas").val()),
            nombre: $.trim($("#nombre").val()),
            modelo: $.trim($("#modelo").val()),
            tipo_camara: $.trim($("#tipo_camara").val()),
            sn: $.trim($("#sn").val()),
            estado: $.trim($("#estado").val())
        };
        $.ajax({
            type: "POST",
            url: "./ajax_handler/camaras.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {

                    if (action === 'create_camara') {
                        var newRow = tablaCamaras.row.add({
                            "id": data.camara.id,
                            "id_plantas": data.camara.id_plantas,
                            "nombre": data.camara.nombre,
                            "modelo": data.camara.modelo,
                            "tipo_camara": data.camara.tipo_camara,
                            "sn": data.camara.sn,
                            "estado": data.camara.estado,
                        }).draw().node();
                        $(newRow).attr('data-id', data.camara.id);
                        $('#modalCRUD').modal('hide');

                    } else if (action === 'edit_camara') {
                        var row = tablaCamaras.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "id_plantas": formData.id_planta,
                            "nombre": formData.nombre,
                            "modelo": formData.modelo,
                            "tipo_camara": formData.tipo_camara,
                            "sn": formData.sn,
                            "estado": formData.estado
                        }).draw();
                        $('#modalCRUD').modal('hide');

                    }

                } else {
                    alert(data.message);
                    // console.log("nofunkopapito")
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