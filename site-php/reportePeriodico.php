<?php
include("./includes/Database.class.php");

require_once('./includes/Clientes.class.php');
require_once('./includes/Plantas.class.php');
require_once('./includes/Operadores.class.php');

$clientes = Clientes::get_all_clients();
$plantas = Plantas::get_all_plantas();
$operadores = Operadores::get_all_operadores_without_turno();
?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4 col-12">
            <div class="card-header p-3 d-flex align-items-center justify-content-start">
                <div class="col-md-2 col-7">
                    <button class="btn btn-primary d-flex align-items-center justify-content-center gap-2 fs-5" id="addUser">
                        <p class="col-10 m-0 text-nowrap">Agregar Reporte</p>
                        <i class="material-icons col-2">add</i>
                    </button>
                </div>
                <div class="card-title d-flex align-items-center justify-content-end gap-1 col-md-2 col-5">Cliente:
                    <select class="form-select form-select-sm" name="cliente" id="cliente">
                        <option value="">Seleccione</option>
                        <?php foreach ($clientes as $cliente): ?>
                        <option value="<?php echo $cliente['id']?>" ><?php echo htmlspecialchars($cliente['nombre']);?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Operador
                            </th>
                            <th>
                                Planta
                            </th>
                            <th class="text-center">
                                N° de Camaras
                            </th>
                            <th class="text-center">
                                N° de Camaras en Linea
                            </th>
                            <th class="text-center">
                                Canal Visualización
                            </th>
                            <th>
                                Observación
                            </th>
                            <th class="text-center">
                                % de Visualización
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
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Cliente:
                                            <select class="form-select" name="id_clientes" id="id_clientes" required>
                                                <option value="">Seleccione</option>
                                                <?php foreach ($clientes as $cliente): ?>
                                                <option value="<?php echo $cliente['id']?>" ><?php echo htmlspecialchars($cliente['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Planta:
                                                <select class="form-select" name="id_planta" id="id_planta" disabled required>
                                                    <option value="">Seleccione Cliente</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">N° de Cámaras en Línea:
                                            <input class="form-control" type="number" name="camaras_online" id="camaras_online" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">N° de Cámaras:
                                            <input class="form-control" type="number" name="camaras" id="camaras" disabled required>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Operador:
                                            <select class="form-select" name="id_operador" id="id_operador" required>
                                                <option value="">Seleccione</option>
                                                <?php foreach ($operadores as $operador): ?>
                                                <option value="<?php echo $operador['id']?>" id="id_operador"><?php echo htmlspecialchars($operador['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Canal de Visualización:
                                            <input class="form-control" type="number" name="canal" id="canal" required>
                                        </label>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Observación:
                                            <textarea class="form-control" name="observacion" id="observacion" required maxlength="255" rows="4"></textarea>
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
        <!-- end::Modal -->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

    //Crear Reporte
    $("#addUser").click(function(){
        $('#formReporte').attr('data-action', 'create_reporte');
        $('#formReporte')[0].reset();
        $('#modalCRUD').modal('show');
    });

    //Editar Reporte
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaReporte.row($(this).parents('tr')).data();
        $('#formReporte').attr('data-action', 'edit_reporte');
        $('#formReporte').attr('data-id', data.id);
        $('#id_planta').val(data.id_plantas);
        $('#nombre').val(data.nombre);
        $('#estado').val(data.estado);

        $('#modalCRUD').modal('show');
    });

    //Eliminar Reporte
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');  // Capturamos la fila correctamente
    var data = tablaReporte.row($row).data();
    var reporteId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar esta cámara?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/reportes.php",
            data: { action: 'delete_reporte', id: reporteId },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tablaCamaras.row($row).remove().draw()  ;
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
    }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready( function(){
        $('#id_clientes').change(function() {
            var id_cliente = $(this).val();
            $('#id_planta').prop('disabled', false);

            $.ajax({
                type: 'POST',
                url: "./ajax_handler/reportes.php",
                data: {id_cliente: id_cliente,
                    action: 'get_plantas'
                },
                dataType: 'json',
                success: function(data) {
                    var $plantaSelect = $('#id_planta');
                    $plantaSelect.empty();
                    $plantaSelect.append('<option value=""> Seleccione </option>');
                    $.each(data, function(index, planta) {
                        $plantaSelect.append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error en AJAX:', textStatus, errorThrown);
                }
            });
        });

        $('#id_planta').change(function() {
            var id_planta = $(this).val();

            $.ajax({
                type: 'POST',
                url: "./ajax_handler/reportes.php",
                data: {id_planta: id_planta,
                    action: 'count_camaras_planta'
                },
                dataType: 'json',
                success: function(data) {
                    var $camaraInput = $('#camaras');
                    $camaraInput.val(data.total);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error en AJAX:', textStatus, errorThrown);
                }
            });
        });

        var plantas = <?php echo json_encode($plantas); ?>;
        var plantasMap = {};

        plantas.forEach(function(planta) {
            plantasMap[planta.id] = planta.nombre;
        });

        var operadores = <?php echo json_encode($operadores); ?>;
        var operadoresMap = {};

        operadores.forEach(function(operador) {
            operadoresMap[operador.id] = operador.nombre;
        });

        tablaReporte =  $('#tabla').DataTable({
            responsive: true,
            "ajax": {            
                "url": "./ajax_handler/reportes.php",
                "type": 'POST',
                "data": {action: 'get_reportes'},
                "dataSrc": ""
            },
            "columns":[
                {   
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {   
                    "data": "fecha",
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "id_operador",
                    "render": function(data) {
                        return operadoresMap[data] || 'Desconocido';
                    }
                },
                {   
                    "data": "id_planta",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "camaras",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "camaras_online",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "canal",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "observacion",
                },
                {   
                    "data": null,
                    "render": function(data, type, row) {
                        var porcentaje = 0;
                        if (row.camaras && row.camaras_online) {
                            porcentaje = Math.round(row.camaras_online / row.camaras * 100);
                        }
                        return '%' + porcentaje;
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {"defaultContent": "<div class='text-center d-inline-block d-md-block'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
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
    // fomrulario Subir/Editar Reporte

    $("#formReporte"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            id_cliente: $.trim($("#id_clientes").val()),
            id_planta: $.trim($("#id_planta").val()),
            id_operador: $.trim($("#id_operador").val()),
            camaras_online: $.trim($("#camaras_online").val()),
            camaras: $.trim($("#camaras").val()),
            canal: $.trim($("#canal").val()),
            observacion: $.trim($("#observacion").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/reportes.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    console.log(data)
                    if (action === 'create_reporte'){
                        var newRow = tablaReporte.row.add({
                            "id": data.reporte.id,
                            "fecha": data.reporte.fecha,
                            "id_operador": data.reporte.id_operador,
                            "id_planta": data.reporte.id_planta,
                            "camaras": data.reporte.camaras,
                            "camaras_online": data.reporte.camaras_online,
                            "canal": data.reporte.canal,
                            "observacion": data.reporte.observacion,
                            "porcentaje": Math.round(data.reporte.camaras_online / data.reporte.camaras * 100)
                        }).draw().node();
                        $(newRow).attr('data-id', data.reporte.id);
                        $('#modalCRUD').modal('hide');

                    }else if (action === 'edit_reporte'){
                        var row = tablaReporte.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "id_plantas": formData.id_planta,
                            "nombre": formData.nombre,
                            "estado": formData.estado
                        }).draw();
                        $('#modalCRUD').modal('hide');

                    }
                    
                } else {
                    alert(data.message);
                } },
            error:function(jqXHR, textStatus, errorThrown) {
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