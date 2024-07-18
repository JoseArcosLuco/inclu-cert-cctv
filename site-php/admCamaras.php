<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');

$plantas = Plantas::get_all_plantas();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar Cámara<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover" id="tabla">
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
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formCamara" name="formCamara">    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                        </label>
                                    </div>
                                </div>  
                            </div>
                            <div class="row"> 
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Planta:
                                            <select class="form-select" name="id_planta" id="id_planta">
                                                <?php foreach ($plantas as $planta): ?>
                                                    <option value="<?php echo $planta['id']?>" ><?php echo htmlspecialchars($planta['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>               
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado">
                                                    <option value="1" >Activa</option>
                                                    <option value="0" >Inactiva</option>
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
<script>

    //Crear Camara
    $("#addUser").click(function(){
        $('#formCamara').attr('data-action', 'create_camara');
        $('#formCamara')[0].reset();
        $('#modalCRUD').modal('show');
    });

    //Editar Camara
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaCamaras.row($(this).parents('tr')).data();
        $('#formCamara').attr('data-action', 'edit_camara');
        $('#formCamara').attr('data-id', data.id);
        $('#id_planta').val(data.id_plantas);
        $('#nombre').val(data.nombre);
        $('#estado').val(data.estado);

        $('#modalCRUD').modal('show');
    });

    //Eliminar Camara
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');  // Capturamos la fila correctamente
    var data = tablaCamaras.row($row).data();
    var camaraId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/camaras.php",
            data: { action: 'delete_camara', id: camaraId },
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
<script>
    var plantas = <?php echo json_encode($plantas); ?>;
    var plantasMap = {};

    // Convertir el array de perfiles a un mapa para un acceso más rápido
    plantas.forEach(function(planta) {
        plantasMap[planta.id] = planta.nombre;
    });
    
    $(document).ready( function(){
        tablaCamaras =  $('#tabla').DataTable({
            "ajax": {            
                "url": "./ajax_handler/camaras.php",
                "type": 'POST',
                "data": {action: 'get_camaras'},
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
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    } 
                },
                {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
            ],
            "createdRow": function(row, data, dataIndex) {
            $(row).attr('data-id', data.id); // Añadir atributo data-id
            }

        });
    });
</script>
<script>
    // fomrulario Subir/Editar cámaras

    $("#formCamara"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            id_planta: $.trim($("#id_planta").val()),
            nombre: $.trim($("#nombre").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/camaras.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {

                    if (action === 'create_camara'){
                        var newRow = tablaCamaras.row.add({
                                "id": data.camara.id,
                                "id_plantas": data.camara.id_plantas,
                                "nombre": data.camara.nombre,
                                "estado": data.camara.estado,
                            }).draw().node();
                            $(newRow).attr('data-id', data.camara.id);
                            $('#modalCRUD').modal('hide');

                    }else if (action === 'edit_camara'){
                        var row = tablaCamaras.row($('[data-id="' + id + '"]'));
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