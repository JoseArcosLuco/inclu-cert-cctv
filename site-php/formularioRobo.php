<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Clientes.class.php');

$plantas = Plantas::get_all_plantas();
$clientes = Clientes::get_all_clients();



?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar Reporte<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Cliente
                            </th>
                            <th>
                                Planta
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Hora
                            </th>
                            <th>
                                Observación
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
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Cliente:
                                            <select class="form-select" name="id_cliente" id="id_cliente">
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
                                                <select class="form-select" name="id_planta" id="id_planta" disabled requiere>
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
                                        <label class="col-form-label w-100">Fecha:
                                            <input type="date" class="form-control" name="fecha" id="fecha" requiere>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Hora:
                                                <input type="time" class="form-control" name="hora" id="hora" requiere>
                                            </label>
                                        </div>
                                    </div>               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Observación:
                                            <textarea name="observacion" id="observacion" class="form-control" rows="3" requiere></textarea>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado">
                                                    <option value="1" >Activo</option>
                                                    <option value="0" >Inactivo</option>
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
        <!-- end::Modal -->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>

    //Crear Camara
    $("#addUser").click(function(){
        $('#formReporte').attr('data-action', 'create_reporte');
        $('#formReporte')[0].reset();
        $('#modalCRUD').modal('show');
    });

    //Editar Camara
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaReporte.row($(this).parents('tr')).data();
        console.log(data);
        $('#id_cliente').prop('disabled', true);
        $('#formReporte').attr('data-action', 'edit_reporte');
        $('#formReporte').attr('data-id', data.id);
        $('#id_cliente').val(data.id_cliente);
        $('#id_planta').empty();
        $('#id_planta').append('<?php foreach ($plantas as $planta): ?>');
        $('#id_planta').append('<option value="<?php echo $planta['id']?>" ><?php echo htmlspecialchars($planta['nombre']);?></option>');
        $('#id_planta').append('<?php endforeach; ?>');
        $('#id_planta').val(data.id_planta);
        $('#fecha').val(moment(data.fecha, 'YYYY-MM-DD HH:mm:ss').format('yyyy-MM-DD'));
        $('#hora').val(moment(data.fecha).format('HH:mm'));
        $('#observacion').val(data.observacion);
        $('#estado').val(data.estado);

        $('#modalCRUD').modal('show');
    });

    //Eliminar Camara
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');  // Capturamos la fila correctamente
    var data = tablaReporte.row($row).data();
    var reporteId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar esta cámara?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/robos.php",
            data: { action: 'delete_reporte', id: reporteId },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tablaReporte.row($row).remove().draw()  ;
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
<script>
    var clientes = <?php echo json_encode($clientes); ?>;
    var clienteMap = {};

    clientes.forEach(function(cliente) {
        clienteMap[cliente.id] = cliente.nombre;
    });

    var plantas = <?php echo json_encode($plantas); ?>;
    var plantasMap = {};

    plantas.forEach(function(planta) {
        plantasMap[planta.id] = planta.nombre;
    });
    
    $(document).ready( function(){

        $('#id_cliente').change(function() {
            var id = $(this).val();
            $('#id_planta').prop('disabled', false);
            
            $.ajax({
                type: "POST",
                url: "./ajax_handler/robos.php",
                data: { action: 'get_plantas', id: id },
                datatype: "json",
                success: function(data) {
                    console.log(data);
                    $('#id_planta').empty();
                    $('#id_planta').append('<option value="">Seleccionar</option>');
                    data.forEach(function(planta) {
                        $('#id_planta').append('<option value="'+planta.id+'">'+planta.nombre+'</option>');
                    });
                }
            })
        })
        tablaReporte =  $('#tabla').DataTable({
            responsive: true,
            "ajax": {            
                "url": "./ajax_handler/robos.php",
                "type": 'POST',
                "data": {action: 'get_reporte'},
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
                    "data": "id_cliente",
                    "render": function(data) {
                        return clienteMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "id_planta",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    }
                },
                {   
                    "data": "fecha",
                    "render": function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
                {   
                    "data": "fecha",
                    "render": function(data) {
                        return moment(data).format('HH:mm');
                    }
                },
                {   
                    "data": "observacion",
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo'; //editar estado del robo en función de los requerimientos
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
    // fomrulario Subir/Editar cámaras

    $("#formReporte"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            id_planta: $.trim($("#id_planta").val()),
            id_cliente: $.trim($("#id_cliente").val()),
            fecha: $.trim($("#fecha").val()),
            hora: $.trim($("#hora").val()) + ':00',
            observacion: $.trim($("#observacion").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/robos.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    console.log(data)
                    if (action === 'create_reporte'){
                        let hora = moment(data.reporte.fecha, 'YYYY-MM-DD HH:mm:ss').format('HH:mm');
                        var newRow = tablaReporte.row.add({
                                "id": data.reporte.id,
                                "id_cliente": data.reporte.id_cliente,
                                "id_planta": data.reporte.id_planta,
                                "fecha": formData.fecha,
                                "hora": hora,
                                "observacion": data.reporte.observacion,
                                "estado": data.reporte.estado,
                            }).draw().node();
                            $(newRow).attr('data-id', data.reporte.id);
                            $('#modalCRUD').modal('hide');

                    }else if (action === 'edit_reporte'){
                        var row = tablaReporte.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "id_cliente": formData.id_cliente,
                            "id_planta": formData.id_planta,
                            "fecha": formData.fecha,
                            "hora": formData.hora,
                            "observacion": formData.observacion,
                            "estado": formData.estado,
                        }).draw();
                        $('#modalCRUD').modal('hide');

                    }
                    
                } else {
                    alert(data.message);
                    // console.log("nofunkopapito")
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