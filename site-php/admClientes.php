<?php
include("./includes/Database.class.php");

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar Cliente<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
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
                                Email
                            </th>
                            <th class="text-start">
                                Fecha de Contrato
                            </th>
                            <th>
                                Contacto
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formClientes" name="formClientes">    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre Cliente:
                                            <input type="text" class="form-control" id="nombre">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Fecha Contrato:
                                            <input type="date" class="form-control" id="fecha_contrato">
                                        </label>
                                    </div>
                                </div> 
                            </div>
                            <div class="row"> 
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Email:
                                                <input type="email" class="form-control" id="email">
                                            </label>
                                        </div>
                                    </div>               
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Contacto:
                                            <input type="text" class="form-control" id="contacto">
                                        </label>
                                    </div>
                                </div>    
                                <div class="col-md-4 mb-3">    
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

    //Crear Usuario
    $("#addUser").click(function(){
        $('#formClientes').attr('data-action', 'create_');
        $('#formClientes')[0].reset();
        $('#modalCRUD').modal('show');
    });

    //Editar Usuario
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaClientes.row($(this).parents('tr')).data();
        $('#formClientes').attr('data-action', 'edit_');
        $('#formClientes').attr('data-id', data.id);
        
        $('#nombre').val(data.nombre);
        $('#email').val(data.email);  
        $('#fecha_contrato').val(data.fecha_contrato);
        $('#contacto').val(data.contacto);
        $('#estado').val(data.estado);

        $('#modalCRUD').modal('show');
    });

    //Eliminar Usuario
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');  // Capturamos la fila correctamente
    var data = tablaClientes.row($row).data();
    var userId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/clientes.php",
            data: { action: 'delete_', id: userId },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tablaClientes.row($row).remove().draw()  ;

                } else if(response.clientes) {
                    let clientes = response.clientes
                    let listaClientes = '';
                    for (let i = 0; i < clientes.length; i++) {
                        listaClientes += 'ID: '+ clientes[i].id +' - Nombre: ' + clientes[i].nombre + '\n';
                    }
                    alert(response.message + '\n\n' + listaClientes);

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
        tablaClientes =  $('#tabla').DataTable({
            responsive: true,
            "ajax": {            
                "url": "./ajax_handler/clientes.php",
                "type": 'POST',
                "data": {action: 'get_clientes'},
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
                {"data": "email"},
                {
                    "data": "fecha_contrato",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-start');
                    }
                },
                {   
                    "data": "contacto",
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
    // fomrulario Subir/Editar usuarios

    $("#formClientes"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            nombre: $.trim($("#nombre").val()),
            email: $.trim($("#email").val()),
            fecha_contrato: $.trim($("#fecha_contrato").val()),
            contacto: $.trim($("#contacto").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/clientes.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_'){
                        var newRow = tablaClientes.row.add({
                                "id": data.row.id,
                                "email": data.row.email,
                                "nombre": data.row.nombre,
                                "contacto": data.row.contacto,
                                "fecha_contrato": data.row.fecha_contrato,
                                "estado": data.row.estado
                            }).draw().node();
                            $(newRow).attr('data-id', data.row.id);
                            $('#modalCRUD').modal('hide');
                    }else if (action === 'edit_'){
                        var row = tablaClientes.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "nombre": formData.nombre,
                            "email": formData.email,
                            "contacto": formData.contacto,
                            "estado": formData.estado,
                            "fecha_contrato": formData.fecha_contrato // Mantener la fecha de contrato existente
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