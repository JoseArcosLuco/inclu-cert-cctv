<?php
include("./includes/Database.class.php");
require_once('./includes/Plantas.class.php');
require_once('./includes/Jornada.class.php');

$plantas = Plantas::get_all_plantas();
$jornadas = Jornada::get_all_jornadas();
$idPerfil = '';
$idPerfil = isset($_SESSION["idperfil"]) ? $_SESSION["idperfil"] : '';
?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <?php if ($idPerfil === 1 || $idPerfil === 2): ?>
                    <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar Turno<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
                <?php endif; ?>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
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
                                Hora Entrada
                            </th>
                            <th>
                                Hora Salida
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
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                        </label>
                                    </div>
                                </div>  
                                <div class="col-md-6 mb-3">
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
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Hora Entrada:
                                            <input type="time" class="form-control" id="horaEntrada" name="horaEntrada" required>
                                        </label>
                                    </div>
                                </div>  
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Hora Salida:
                                            <input type="time" class="form-control" id="horaSalida" name="horaSalida" required>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
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
                                <div class="col-md-6 mb-3">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script>

    //Crear Turnos
    $("#addUser").click(function(){
        $('#formTurno').attr('data-action', 'create_turno');
        $('#formTurno')[0].reset();
        $('#modalCRUD .modal-title').text('Agregar Turno');
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
        $('#horaEntrada').val(data.hora_entrada);
        $('#horaSalida').val(data.hora_salida);
        $('#estado').val(data.estado);
        $('#modalCRUD .modal-title').text('Editar Turno');

        $('#modalCRUD').modal('show');
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {    
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    //Eliminar Turnos
    $('#tabla tbody').on('click', '.btnBorrar', function() {
        var $row = $(this).closest('tr');
        var data = tablaTurnos.row($row).data();
        var turnoId = data.id;
        var modal = $('#warningModal .modal-dialog .modal-content');
            
        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p>ID: '+data.id+'</p>');
        modal.find('.modal-body').append('<p>Nombre: '+data.nombre+'</p>');
        modal.find('.modal-body').append('<p>Planta: '+plantasMap[data.id_plantas]+'</p>');
        modal.find('.modal-body').append('<p>Jornada: '+jornadasMap[data.id_jornada]+'</p>');
        modal.find('.modal-body').append('<p>Horario: '+moment(data.hora_entrada, 'HH:mm:ss').format('HH:mm')+' - '+moment(data.hora_salida, 'HH:mm:ss').format('HH:mm')+'</p>');
        modal.find('.modal-body').append('<p>Estado: '+(data.estado ? 'Activo' : 'Inactivo')+'</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function(){
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
        });
    });

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
            responsive: true,
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
                    "data": "hora_entrada",
                    "render": function(data) {
                        return moment(data, 'HH:mm:ss').format('HH:mm') || 'Sin Hora';
                    }
                },
                {   
                    "data": "hora_salida",
                    "render": function(data) {
                        return moment(data, 'HH:mm:ss').format('HH:mm') || 'Sin Hora';
                    }
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    } 
                },
                {
                    "data":null,
                    render: function(data, type, row) {
                        let url = '<?php echo $base_url ?>/formularios.php?form=operador&turno='+data.id+'&token=<?php echo $token; ?>'
                        return "<div class='text-center d-inline-block d-md-block'><div class='btn-group'><a href='"+url+"' class='btn btn-info btn-sm btnOperador' title='Ir a Operadores'><i class='material-icons'>engineering</i></a><?php if($idPerfil === 1 || $idPerfil === 2):?><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button><?php endif;?></div></div>"
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
            estado: $.trim($("#estado").val()),
            hora_entrada: $.trim($("#horaEntrada").val()),
            hora_salida: $.trim($("#horaSalida").val())
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
                            "hora_entrada": data.turno.hora_entrada,
                            "hora_salida": data.turno.hora_salida,
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
                            "hora_entrada": formData.hora_entrada,
                            "hora_salida": formData.hora_salida,
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