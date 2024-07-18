<?php
include("./includes/Database.class.php");
require_once('./includes/Perfil.class.php');


?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="add">Agregar Comisaria<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover" id="tabla">
                    <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Nombres
                            </th>
                            <th>
                                Dirección
                            </th>
                            <th>
                                Telefono
                            </th>
                            <th>
                                Movil
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
                        <h5 class="modal-title" name="exampleModalLabel" id="exampleModalLabel">Agregar Comisaria</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formComisaria" name="formComisaria">    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombres">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Dirección:
                                            <input type="text" class="form-control" id="direccion">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Telefono:
                                            <input type="text" class="form-control" id="telefono">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Movil Cuadrante:
                                            <input type="text" class="form-control" id="movil">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">    
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
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

    //Crear
    $("#add").click(function(){
        $('#formComisaria').attr('data-action', 'create_');
        $('#formComisaria')[0].reset();
        $('#modalCRUD').modal('show');
        const p = document.getElementById("exampleModalLabel");
        p.innerText = "Agregar Comisaria!";
    });

    //Editar
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tabla.row($(this).parents('tr')).data();
        $('#formComisaria').attr('data-action', 'edit_');
        $('#formComisaria').attr('data-id', data.id);
        $('#nombres').val(data.nombre);
        $('#direccion').val(data.direccion);
        $('#telefono').val(data.telefono);
        $('#movil').val(data.movil);
        $('#estado').val(data.estado);
        $('#modalCRUD').modal('show');
        
        const p = document.getElementById("exampleModalLabel");
        p.innerText = "Editar Comisaria!";
    });

    //Eliminar
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');  // Capturamos la fila correctamente
    var data = tabla.row($row).data();
    var u_Id = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar esta comisaria?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/comisarias.php",
            data: { action: 'delete_', id: u_Id },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tabla.row($row).remove().draw()  ;
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
    $(document).ready( function(){
        tabla =  $('#tabla').DataTable({
            "ajax": {            
                "url": "./ajax_handler/comisarias.php",
                "type": 'POST',
                "data": {action: 'get_comisaria'},
                "dataSrc": ""
            },
            "columns":[
                {   
                    "data": "id",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    }
                },
                {   
                    "data": "nombre",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {   
                    "data": "direccion",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {   
                    "data": "telefono",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {   
                    "data": "movil",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "estado",
                    "render": function(data, type, row) {
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

    $("#formComisaria"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            nombres: $.trim($("#nombres").val()),
            direccion: $.trim($("#direccion").val()),
            telefono: $.trim($("#telefono").val()),
            movil: $.trim($("#movil").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/comisarias.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_'){
                        var newRow = tabla.row.add({
                                "id": data.row.id,
                                "nombre": data.row.nombre,
                                "direccion": data.row.direccion,
                                "telefono": data.row.telefono,
                                "movil": data.row.movil,
                                "estado": data.row.estado
                            }).draw().node();
                            $(newRow).attr('data-id', data.row.id);
                            $('#modalCRUD').modal('hide');
                    }else if (action === 'edit_'){
                        var row = tabla.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "nombre": formData.nombres,
                            "direccion": formData.direccion,
                            "telefono": formData.telefono,
                            "movil": formData.movil,
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