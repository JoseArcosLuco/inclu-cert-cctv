<?php
include("./includes/Database.class.php");
require_once('./includes/Plantas.class.php');
require_once('./includes/Jornada.class.php');

$plantas = Plantas::get_all_plantas();
$jornadas = Jornada::get_all_jornadas();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar Turno<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Planta
                            </th>
                            <th>
                                Jornada
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Perfiles</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formTurno" name="formTurno">    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                        </label>
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Planta:
                                            <select class="form-select" name="id_plantas" id="id_plantas" required>
                                                <?php foreach ($plantas as $planta): ?>
                                                    <option value="<?php echo $planta['id']?>" ><?php echo htmlspecialchars($planta['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Jornada:
                                            <select class="form-select" name="id_jornada" id="id_jornada" required>
                                                <?php foreach ($jornadas as $jornada): ?>
                                                    <option value="<?php echo $jornada['id']?>" ><?php echo htmlspecialchars($jornada['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
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
<script>

    //Crear Turnos
    $("#addUser").click(function(){
        $('#formTurno').attr('data-action', 'create_turno');
        $('#formTurno')[0].reset();
        $('#modalCRUD').modal('show');
    });

    //Editar Turnos
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaTurnos.row($(this).parents('tr')).data();
        $('#formTurno').attr('data-action', 'edit_turno');
        $('#formTurno').attr('data-id', data.id);
        $('#nombre').val(data.nombre);
        $('#id_plantas').val(data.id_plantas);
        $('#id_jornada').val(data.id_jornada);
        $('#estado').val(data.estado);

        $('#modalCRUD').modal('show');
    });

    //Eliminar Turnos
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');
    var data = tablaTurnos.row($row).data();
    var turnoId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar este perfil?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/turnos.php",
            data: { action: 'delete_turno', id: turnoId },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tablaTurnos.row($row).remove().draw()  ;
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
    //ver plantas en tabla
    var plantas = <?php echo json_encode($plantas); ?>;
    var plantasMap = {};

    plantas.forEach(function(planta) {
        plantasMap[planta.id] = planta.nombre;
    });

    //ver jornadas en tabla
    var jornadas = <?php echo json_encode($jornadas); ?>;
    var jornadasMap = {};

    jornadas.forEach(function(jornada) {
        jornadasMap[jornada.id] = jornada.nombre;
    });

    $(document).ready( function(){
        tablaTurnos =  $('#tabla').DataTable({
            "ajax": {            
                "url": "./ajax_handler/turnos.php",
                "type": 'POST',
                "data": {action: 'get_turnos'},
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
                    "data": "nombre",
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {   
                    "data": "id_plantas",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    }
                },
                {   
                    "data": "id_jornada",
                    "render": function(data) {
                        return jornadasMap[data] || 'Desconocido';
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
    // fomrulario Subir/Editar Turnos

    $("#formTurno"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            nombre: $.trim($("#nombre").val()),
            id_plantas: $.trim($("#id_plantas").val()),
            id_jornada: $.trim($("#id_jornada").val()),
            estado: $.trim($("#estado").val())
        };
        $.ajax({
            type: "POST",
            url: "./ajax_handler/turnos.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_turno'){
                        var newRow = tablaTurnos.row.add({
                            "id": data.turno.id,
                            "nombre": data.turno.nombre,
                            "id_plantas": data.turno.id_plantas,
                            "id_jornada": data.turno.id_jornada,
                            "estado": data.turno.estado,
                        }).draw().node();
                        $(newRow).attr('data-id', data.turno.id);
                        $('#modalCRUD').modal('hide');

                    }else if (action === 'edit_turno'){
                        var row = tablaTurnos.row($('[data-id="' + id + '"]'));
                        row.data({
                            "id": id,
                            "nombre": formData.nombre,
                            "id_plantas": formData.id_plantas,
                            "id_jornada": formData.id_jornada,
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