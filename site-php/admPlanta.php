<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Ciudades.class.php');
require_once('./includes/Comisarias.class.php');
require_once('./includes/TipoPlanta.class.php');
require_once('./includes/Comunas.class.php');
require_once('./includes/Clientes.class.php');

$ciudades = Ciudades::get_all_ciudades();
$comunas = Comunas::get_all_comunas_without_id();
$comisarias = Comisarias::get_all_comisarias();
$tiposPlanta = TipoPlanta::get_all_tipo_planta();
$clientes = Clientes::get_all_clients();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addPlanta">Agregar Planta<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-start">
                                ID
                            </th>
                            <th>
                                Cliente
                            </th>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Comuna
                            </th>
                            <th>
                                Comisaria
                            </th>
                            <th>
                                Tipo de Planta
                            </th>
                            <th class="text-start">
                                Grupo
                            </th>
                            <th>
                                Ubicación
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Planta</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formPlantas" name="formPlantas">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Cliente:
                                            <select class="form-select" name="id_clientes" id="id_clientes" required>
                                                <?php foreach ($clientes as $cliente) : ?>
                                                    <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Dirección:
                                            <input type="text" class="form-control" id="direccion" required>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Ciudad:
                                                <select class="form-select" name="id_ciudad" id="id_ciudad" required>
                                                    <?php foreach ($ciudades as $ciudad) : ?>
                                                        <option value="<?php echo $ciudad['id'] ?>"><?php echo htmlspecialchars($ciudad['nombre']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Comuna:
                                            <select class="form-select" name="id_comuna" id="id_comuna" required>
                                                <option value="">Seleccione una Ciudad</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Comisaria:
                                            <select class="form-select" name="id_comisaria" id="id_comisaria" required>
                                                <?php foreach ($comisarias as $comisaria) : ?>
                                                    <option value="<?php echo $comisaria['id'] ?>"><?php echo htmlspecialchars($comisaria['nombre']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Tipo de Planta:
                                            <select class="form-select" name="id_tipoPlanta" id="id_tipoPlanta" required>
                                                <?php foreach ($tiposPlanta as $tipoPlanta) : ?>
                                                    <option value="<?php echo $tipoPlanta['id'] ?>"><?php echo htmlspecialchars($tipoPlanta['nombre']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Grupo:
                                            <input class="form-control" type="text" id="grupo" name="grupo" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Email Encargado:
                                            <input class="form-control" type="email" id="emailEncargado" name="emailEncargado" required>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre Encargado:
                                            <input class="form-control" type="text" id="nombreEncargado" name="nombreEncargado" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Telefono Encargado:
                                            <input class="form-control" type="tel" id="telEncargado" name="telEncargado" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado" required>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Mapa:
                                            <input class="form-control" type="text" id="mapa" name="mapa" required>
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
        <div class="modal fade" id="additionalInfo" tabindex="-1" aria-labelledby="additionalInfo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row" id="row1">
                            </div>
                            <div class="row" id="row2">
                            </div>
                            <div class="row" id="row3">
                            </div>
                            <div class="row" id="row4">
                            </div>
                            <div class="row" id="row5">
                            </div>
                            <div class="row" id="row6">
                            </div>
                            <div class="row" id="row7">
                            </div>
                            <div class="row" id="row8">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
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
    //ver las comunas según la ciudad ingresada en el formulario
    $(document).ready(function() {
        $('#id_ciudad').change(function() {
            var id_ciudad = $(this).val();

            $.ajax({
                type: 'POST',
                url: './ajax_handler/plantas.php',
                data: {
                    id_ciudad: id_ciudad,
                    action: 'get_comuna'
                },
                dataType: 'json',
                success: function(data) {
                    var $comunaSelect = $('#id_comuna');
                    $comunaSelect.empty();
                    $comunaSelect.append('<option value="">Seleccione</option>');
                    $.each(data, function(index, comuna) {
                        $comunaSelect.append('<option value="' + comuna.id + '">' + comuna.nombre + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error en AJAX:', textStatus, errorThrown);
                }
            });
        });
    });
</script>
<script>
    //Crear Planta
    $("#addPlanta").click(function() {
        $('#formPlantas').attr('data-action', 'create_planta');
        $('#formPlantas')[0].reset();
        $('#modalCRUD .modal-title').text('Agregar Planta');
        $('#modalCRUD').modal('show');
    });

    //Editar Planta
    $('#tabla tbody').on('click', '.btnEditar', function() {
        $('#modalCRUD .modal-title').text('Editar Planta');
        var $row = $(this).closest('tr');
        var data = tablaPlantas.row($row).data();
        var plantaId = data.id;
        $.ajax({
            type: 'POST',
            url: './ajax_handler/plantas.php',
            data: {
                action: 'get_plantas_by_id',
                id: plantaId
            },
            success: function(response) {
                console.log(response)
                $('#formPlantas').attr('data-action', 'edit_planta');
                $('#formPlantas').attr('data-id', response[0].id);
                $('#nombre').val(response[0].nombre);
                $('#id_clientes').val(response[0].id_clientes);
                $('#direccion').val(response[0].ubicacion);
                $('#id_ciudad').val(response[0].id_ciudad);
                $('#id_comuna').append('<?php foreach ($comunas as $comuna):?>')
                $('#id_comuna').append('<?php echo '<option value="' . $comuna['id'] . '">' . $comuna['nombre'] . '</option>';?>')
                $('#id_comuna').append('<?php endforeach;?>')
                $('#id_comuna').val(response[0].id_comuna);
                $('#id_comisaria').val(response[0].id_comisarias);
                $('#id_tipoPlanta').val(response[0].id_tipo_planta);
                $('#grupo').val(response[0].grupo);
                $('#nombreEncargado').val(response[0].encargado_contacto);
                $('#telEncargado').val(response[0].encargado_telefono);
                $('#emailEncargado').val(response[0].encargado_email);
                $('#mapa').val(response[0].mapa);
                $('#estado').val(response[0].estado);


                $('#modalCRUD').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        })
    });

    $('#tabla tbody').on('click', '.btnInfo', function() {
        var $row = $(this).closest('tr');
        var data = tablaPlantas.row($row).data();
        var plantaId = data.id;
        $.ajax({
            type: 'POST',
            url: './ajax_handler/plantas.php',
            data: {
                action: 'get_plantas_by_id',
                id: plantaId
            },
            success: function(response) {
                console.log(response)
                let modal = $('#additionalInfo .modal-dialog .modal-content');
                modal.find('.modal-header').append('<h5 class="modal-title">Información Planta ' + response[0].nombre + '</h5>');
                modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">ID: </span><span class="badge bg-primary">' + response[0].id + '</span></p>');
                modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Cliente: </span>' + clientesMap[response[0].id_clientes] + '</p>');
                modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Tipo de Planta: </span>' + tipoPlantaMap[response[0].id_tipo_planta] + '</p>');
                modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Ciudad: </span>' + response[0].nombre_ciudad + '</p>');
                modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Comuna: </span>' + comunasMap[response[0].id_comuna] + '</p>');
                modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Comisaria: </span>' + comisariasMap[response[0].id_comisarias] + '</p>');
                modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Grupo: </span>' + response[0].grupo + '</p>');
                modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Dirección: </span>' + response[0].ubicacion + '</p>');
                modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Mapa: </span>' + response[0].mapa + '</p>');
                modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Encargado: </span>' + response[0].encargado_contacto + '</p>');
                modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Teléfono: </span>' + response[0].encargado_telefono + '</p>');
                modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Email: </span>' + response[0].encargado_email + '</p>');


                $('#additionalInfo').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        })
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    $('#additionalInfo').on('hidden.bs.modal', function() {
        var modal = $('#additionalInfo .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    //Eliminar Planta
    $('#tabla tbody').on('click', '.btnBorrar', function() {
        var $row = $(this).closest('tr');
        var data = tablaPlantas.row($row).data();
        var plantaId = data.id;

        var modal = $('#warningModal .modal-dialog .modal-content');

        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p>ID: ' + data.id + '</p>');
        modal.find('.modal-body').append('<p>Cliente: ' + clientesMap[data.id_clientes] + '</p>');
        modal.find('.modal-body').append('<p>Nombre: ' + data.nombre + '</p>');
        modal.find('.modal-body').append('<p>Comuna: ' + comunasMap[data.id_comuna] + '</p>');
        modal.find('.modal-body').append('<p>Comisaria: ' + comisariasMap[data.id_comisarias] + '</p>');
        modal.find('.modal-body').append('<p>Tipo de Planta: ' + tipoPlantaMap[data.id_tipo_planta] + '</p>');
        modal.find('.modal-body').append('<p>Grupo: ' + data.grupo + '</p>');
        modal.find('.modal-body').append('<p>Ubicación: ' + data.ubicacion + '</p>');
        modal.find('.modal-body').append('<p>Nombre Encargado: ' + data.encargado_contacto + '</p>');
        modal.find('.modal-body').append('<p>Email Encargado: ' + data.encargado_email + '</p>');
        modal.find('.modal-body').append('<p>Telefono Encargado: ' + data.encargado_telefono + '</p>');
        modal.find('.modal-body').append('<p>Mapa: ' + data.mapa + '</p>');
        modal.find('.modal-body').append('<p>Estado: ' + (data.estado ? 'Activo' : 'Inactivo') + '</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function() {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/plantas.php",
                data: {
                    action: 'delete_planta',
                    id: plantaId
                },
                datatype: "json",
                encode: true,
                success: function(response) {
                    if (response.status) {
                        // Remover la fila de la tabla
                        tablaPlantas.row($row).remove().draw();
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

    //ver clientes en tabla
    var clientes = <?php echo json_encode($clientes); ?>;
    var clientesMap = {};

    clientes.forEach(function(cliente) {
        clientesMap[cliente.id] = cliente.nombre;
    });

    //ver comunas en tabla
    var comunas = <?php echo json_encode($comunas); ?>;
    var comunasMap = {};

    comunas.forEach(function(comuna) {
        comunasMap[comuna.id] = comuna.nombre;
    });

    //ver comisarias en tabla
    var comisarias = <?php echo json_encode($comisarias); ?>;
    var comisariasMap = {};

    comisarias.forEach(function(comisaria) {
        comisariasMap[comisaria.id] = comisaria.nombre;
    });

    //ver tipos de planta en tabla
    var tipoPlanta = <?php echo json_encode($tiposPlanta); ?>;
    var tipoPlantaMap = {};

    tipoPlanta.forEach(function(tp) {
        tipoPlantaMap[tp.id] = tp.nombre;
    });

    $(document).ready(function() {
        tablaPlantas = $('#tabla').DataTable({
            responsive: true,
            "ajax": {
                "url": "./ajax_handler/plantas.php",
                "type": 'POST',
                "data": {
                    action: 'get_plantas_short_data'
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "id_clientes",
                    "render": function(data) {
                        return clientesMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "nombre",
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "id_comuna",
                    "render": function(data) {
                        return comunasMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "id_comisarias",
                    "render": function(data) {
                        return comisariasMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "id_tipo_planta",
                    "render": function(data) {
                        return tipoPlantaMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "grupo",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "ubicacion"
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        let url = '<?php echo $base_url?>/formularios.php?form=nvr&planta=' + row.id + '&token=<?php echo $token;?>'
                        return '<div class="text-center d-inline-block d-md-block"><div class="btn-group"><a href="' + url + '" class="btn btn-warning btn-sm btnNVR" title="Ir a NVR"><i class="material-icons">scanner</i></a><button class="btn btn-info btn-sm btnInfo" title="Información adicional"><i class="material-icons">info</i></button><button class="btn btn-primary btn-sm btnEditar" title="Editar"><i class="material-icons">edit</i></button><button class="btn btn-danger btn-sm btnBorrar" title="Eliminar"><i class="material-icons">delete</i></button></div></div>'
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
    // fomrulario Subir/Editar usuarios

    $("#formPlantas").submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id: id,
            id_comuna: $.trim($("#id_comuna").val()),
            id_comisarias: $.trim($("#id_comisaria").val()),
            id_tipo_planta: $.trim($("#id_tipoPlanta").val()),
            nombre: $.trim($("#nombre").val()),
            id_clientes: $.trim($("#id_clientes").val()),
            grupo: $.trim($("#grupo").val()),
            ubicacion: $.trim($("#direccion").val()),
            encargado_contacto: $.trim($("#nombreEncargado").val()),
            encargado_email: $.trim($("#emailEncargado").val()),
            encargado_telefono: $.trim($("#telEncargado").val()),
            mapa: $.trim($("#mapa").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/plantas.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                console.log(data)
                if (data.status) {
                    if (action === 'create_planta') {
                        var newRow = tablaPlantas.row.add({
                            "id": data.planta.id,
                            "nombre": data.planta.nombre,
                            "id_clientes": data.planta.id_clientes,
                            "id_comuna": data.planta.id_comuna,
                            "id_comisarias": data.planta.id_comisarias,
                            "id_tipo_planta": data.planta.id_tipo_planta,
                            "grupo": data.planta.grupo,
                            "ubicacion": data.planta.ubicacion,
                            "estado": data.planta.estado
                        }).draw().node();
                        $(newRow).attr('data-id', data.planta.id);
                        $('#modalCRUD').modal('hide');

                    } else if (action === 'edit_planta') {
                        var row = tablaPlantas.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "nombre": formData.nombre,
                            "id_clientes": formData.id_clientes,
                            "id_comuna": formData.id_comuna,
                            "id_comisarias": formData.id_comisarias,
                            "id_tipo_planta": formData.id_tipo_planta,
                            "grupo": formData.grupo,
                            "ubicacion": formData.ubicacion,
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