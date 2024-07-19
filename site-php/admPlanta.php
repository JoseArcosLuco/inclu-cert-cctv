<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Ciudades.class.php');
require_once('./includes/Comisarias.class.php');
require_once('./includes/TipoPlanta.class.php');
require_once('./includes/Comunas.class.php');

$ciudades = Ciudades::get_all_ciudades();
$comunas = Comunas::get_all_comunas_without_id();
$comisarias = Comisarias::get_all_comisarias();
$tiposPlanta = TipoPlanta::get_all_tipo_planta();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addPlanta">Agregar Planta<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-start">
                                ID
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
                            <th>
                                Nombre
                            </th>
                            <th class="text-start">
                                Grupo
                            </th>
                            <th>
                                Ubicación
                            </th>
                            <th class="text-start">
                                Nombre Encargado
                            </th>
                            <th class="text-start">
                                Email Encargado
                            </th>
                            <th class="text-start">
                                Telefono Encargado
                            </th>
                            <th>
                                Mapa
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Dirección:
                                            <input type="text" class="form-control" id="direccion" required>
                                        </label>
                                    </div>
                                </div>    
                            </div>
                            <div class="row"> 
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Ciudad:
                                            <select class="form-select" name="id_ciudad" id="id_ciudad" required>
                                                <?php foreach ($ciudades as $ciudad): ?>
                                                    <option value="<?php echo $ciudad['id']?>" ><?php echo htmlspecialchars($ciudad['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>               
                                </div>
                                <div class="col-lg-6">
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Comisaria:
                                            <select class="form-select" name="id_comisaria" id="id_comisaria" required>
                                                <?php foreach ($comisarias as $comisaria): ?>
                                                    <option value="<?php echo $comisaria['id']?>" ><?php echo htmlspecialchars($comisaria['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>    
                                <div class="col-lg-6">    
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Tipo de Planta:
                                            <select class="form-select" name="id_tipoPlanta" id="id_tipoPlanta" required>
                                                <?php foreach ($tiposPlanta as $tipoPlanta): ?>
                                                    <option value="<?php echo $tipoPlanta['id']?>" ><?php echo htmlspecialchars($tipoPlanta['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>           
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Grupo:
                                            <input class="form-control" type="text" id="grupo" name="grupo" required>
                                        </label>
                                    </div>
                                </div>    
                                <div class="col-lg-6">    
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Email Encargado:
                                            <input class="form-control" type="email" id="emailEncargado" name="emailEncargado" required>
                                        </label>
                                    </div>           
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre Encargado:
                                            <input class="form-control" type="text" id="nombreEncargado" name="nombreEncargado" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">    
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Telefono Encargado:
                                            <input class="form-control" type="tel" id="telEncargado" name="telEncargado" required>
                                        </label>
                                    </div>           
                                </div> 
                                <div class="col-lg-4">    
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado" required>
                                                    <option value="1" >Activo</option>
                                                    <option value="0" >Inactivo</option>
                                            </select>
                                        </label>
                                    </div>           
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
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
                data: {id_ciudad: id_ciudad,
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
    $("#addPlanta").click(function(){
        $('#formPlantas').attr('data-action', 'create_planta');
        $('#formPlantas')[0].reset();
        $('#modalCRUD').modal('show');
    });

    //Editar Planta
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaPlantas.row($(this).parents('tr')).data();
        $('#formPlantas').attr('data-action', 'edit_planta');
        $('#formPlantas').attr('data-id', data.id);
        $('#nombre').val(data.nombre);
        $('#direccion').val(data.ubicacion);
        $('#id_comuna').val(data.id_comuna);
        $('#id_comisaria').val(data.id_comisarias);
        $('#id_tipoPlanta').val(data.id_tipo_planta);
        $('#grupo').val(data.grupo);
        $('#nombreEncargado').val(data.encargado_contacto);
        $('#telEncargado').val(data.encargado_telefono);
        $('#emailEncargado').val(data.encargado_email);
        $('#mapa').val(data.mapa);
        $('#estado').val(data.estado);
        

        $('#modalCRUD').modal('show');
    });

    //Eliminar Planta
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');
    var data = tablaPlantas.row($row).data();
    var plantaId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar esta Planta?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/plantas.php",
            data: { action: 'delete_planta', id: plantaId },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tablaPlantas.row($row).remove().draw()  ;
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

    $(document).ready( function(){
        tablaPlantas =  $('#tabla').DataTable({
            "ajax": {            
                "url": "./ajax_handler/plantas.php",
                "type": 'POST',
                "data": {action: 'get_plantas'},
                "dataSrc": ""
            },
            "columns":[
                {   
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
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
                    "data": "nombre",
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }},
                {
                    "data": "grupo",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-start');
                    }
                },
                {"data": "ubicacion"},
                {
                    "data": "encargado_contacto",
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "encargado_email",
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
                    }
                },
                {"data": "encargado_telefono"},
                {"data": "mapa"},
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
    // fomrulario Subir/Editar usuarios

    $("#formPlantas"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            id_comuna: $.trim($("#id_comuna").val()),
            id_comisarias: $.trim($("#id_comisaria").val()),
            id_tipo_planta: $.trim($("#id_tipoPlanta").val()),
            nombre: $.trim($("#nombre").val()),
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
                    if (action === 'create_planta'){
                        var newRow = tablaPlantas.row.add({
                            "id": data.planta.id,
                            "id_comuna": data.planta.id_comuna,
                            "id_comisarias": data.planta.id_comisarias,
                            "id_tipo_planta": data.planta.id_tipo_planta,
                            "nombre": data.planta.nombre,
                            "grupo": data.planta.grupo,
                            "ubicacion": data.planta.ubicacion,
                            "encargado_contacto": data.planta.encargado_contacto,
                            "encargado_email": data.planta.encargado_email,
                            "encargado_telefono": data.planta.encargado_telefono,
                            "mapa": data.planta.mapa,
                            "estado": data.planta.estado
                        }).draw().node();
                        $(newRow).attr('data-id', data.planta.id);
                        $('#modalCRUD').modal('hide');

                    }else if (action === 'edit_planta'){
                        var row = tablaPlantas.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "id_comuna": formData.id_comuna,
                            "id_comisarias": formData.id_comisarias,
                            "id_tipo_planta": formData.id_tipo_planta,
                            "nombre": formData.nombre,
                            "grupo": formData.grupo,
                            "ubicacion": formData.ubicacion,
                            "encargado_contacto": formData.encargado_contacto,
                            "encargado_email": formData.encargado_email,
                            "encargado_telefono": formData.encargado_telefono,
                            "mapa": formData.mapa,
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