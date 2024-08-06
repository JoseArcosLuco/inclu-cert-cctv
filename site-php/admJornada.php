<?php
include("./includes/Database.class.php");

?>
<style>
    @media (max-width: 768px) {
  .specifictd {
    min-width: 600px; /* adjust to desired wrapping */
    display: table;
    word-wrap: break-word;
  }
}
</style>
<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header p-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="add">Agregar Jornada<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
                </div> <!-- /.card-header -->
                <div class="table-responsive">
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
            </div>
        </div> <!-- /.card -->
        <!-- begin::Modal -->

        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title" name="exampleModalLabel" id="exampleModalLabel">Agregar Jornada</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formJornada" name="formJornada">    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombre:
                                            <input type="text" class="form-control" id="nombre">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">    
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

    //Crear
    $("#add").click(function(){
        $('#formJornada').attr('data-action', 'create_');
        $('#formJornada')[0].reset();
        $('#modalCRUD').modal('show');

        const p = document.getElementById("exampleModalLabel");
        p.innerText = "Agregar Jornada!";
    });

    //Editar
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tabla.row($(this).parents('tr')).data();
        $('#formJornada').attr('data-action', 'edit_');
        $('#formJornada').attr('data-id', data.id);
        
        const p = document.getElementById("exampleModalLabel");
        p.innerText = "Editar Jornada!";
        
        $('#nombre').val(data.nombre);
        $('#estado').val(data.estado);
        $('#modalCRUD').modal('show');
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {    
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    //Eliminar
    $('#tabla tbody').on('click', '.btnBorrar', function() {
        var $row = $(this).closest('tr');  // Capturamos la fila correctamente
        var data = tabla.row($row).data();
        var u_Id = data.id;
        
        var modal = $('#warningModal .modal-dialog .modal-content');
                    
        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p>ID: '+data.id+'</p>');
        modal.find('.modal-body').append('<p>Nombre: '+data.nombre+'</p>');
        modal.find('.modal-body').append('<p>Estado: '+(data.estado ? 'Activo' : 'Inactivo')+'</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function(){
            $.ajax({
                type: "POST",
                url: "./ajax_handler/jornada.php",
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
        });
    });
</script>
<script>
    $(document).ready( function(){
        tabla =  $('#tabla').DataTable({
            responsive: true,
            "ajax": {            
                "url": "./ajax_handler/jornada.php",
                "type": 'POST',
                "data": {action: 'get_jornada'},
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

    $("#formJornada"). submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id:id,
            nombre: $.trim($("#nombre").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/jornada.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_'){
                        var newRow = tabla.row.add({
                                "id": data.row.id,
                                "nombre": data.row.nombre,
                                "estado": data.row.estado
                            }).draw().node();
                            $(newRow).attr('data-id', data.row.id);
                            $('#modalCRUD').modal('hide');
                    }else if (action === 'edit_'){
                        var row = tabla.row($('[data-id="' + id + '"]'));
                        console.log(row.data());
                        row.data({
                            "id": id,
                            "nombre": formData.nombre,
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