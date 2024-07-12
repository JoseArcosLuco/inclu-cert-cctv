<?php
include("./includes/Database.class.php");

require_once('./includes/Users.class.php');
require_once('./includes/Perfil.class.php');

$usuarios = Users::get_all_users();
$perfiles = Perfil::get_all_perfiles();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addUser">Agregar Usuario<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Perfil
                            </th>
                            <th>
                                Nombres
                            </th>
                            <th>
                                Apellidos
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Fecha de Creación
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
                        <?php if(!empty($usuarios)): ?>
                            <?php foreach($usuarios as $usuario): ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($usuario['id']); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($usuario['id_perfil']); ?>
                                    </td>
                                    <td class="text-capitalize">
                                        <?php echo htmlspecialchars($usuario['nombres']); ?>
                                    </td>
                                    <td class="text-capitalize">
                                        <?php echo htmlspecialchars($usuario['apellidos']); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($usuario['email']); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($usuario['fecha_creacion']); ?>
                                    </td>
                                    <td>
                                        <?php echo $usuario['estado'] ? 'Activo' : 'Inactivo'; ?>
                                    </td>
                                    <td class="d-flex gap-3 justify-content-center">
                                        <a href="" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                        <a href="" class="btn btn-danger"><i class="material-icons">delete</i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td>No se encontraron Usuarios</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>      
        </div> <!-- /.card -->
        <!-- begin::Modal -->

        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formUsuarios" name="formUsuarios">    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Nombres:
                                            <input type="text" class="form-control" id="nombres">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Apellidos:
                                            <input type="text" class="form-control" id="apellidos">
                                        </label>
                                    </div>
                                </div>    
                            </div>
                            <div class="row"> 
                                <div class="col-lg-8">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Email:
                                            <input type="email" class="form-control" id="email">
                                        </label>
                                    </div>
                                </div>               
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Perfil:
                                            <select class="form-select" name="id_perfil" id="id_perfil">
                                                <?php foreach ($perfiles as $perfil): ?>
                                                    <option value="<?php echo $perfil['id']?>" ><?php echo htmlspecialchars($perfil['nombre']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Contraseña:
                                            <input type="password" class="form-control" id="password">
                                        </label>
                                    </div>
                                </div>    
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
    $("#addUser").click(function(){
        $("#formUsuarios").trigger("reset");
        $('#modalCRUD').modal('show');
    });
</script>
<script>
    // agregar usuario

    $("#formUsuarios").submit(function(e) {
        e.preventDefault();

        var formData = {
            action: 'create_user',
            id_perfil: $.trim($("#id_perfil").val()),
            nombres: $.trim($("#nombres").val()),
            apellidos: $.trim($("#apellidos").val()),
            email: $.trim($("#email").val()),
            password: $.trim($("#password").val()),
            estado: $.trim($("#estado").val())
        };
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "./ajax_handler/users.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                console.log(data);
                console.log("data.status: ", data['status']);
                console.log("data.status: ", data[0]);
                console.log("data.message: ", data.message);
                $('#modalCRUD').modal('hide');
                if (data.status) {
                    alert(data.message);
                    $('#modalCRUD').modal('hide');
                    let newRow = `<tr>
                        <td>${data.user.id}</td>
                        <td>${data.user.id_perfil}</td>
                        <td class="text-capitalize">${data.user.nombres}</td>
                        <td class="text-capitalize">${data.user.apellidos}</td>
                        <td>${data.user.email}</td>
                        <td>${data.user.fecha_creacion}</td>
                        <td>${data.user.estado ? 'Activo' : 'Inactivo'}</td>
                        <td class="d-flex gap-3 justify-content-center">
                            <a href="" class="btn btn-warning"><i class="material-icons">edit</i></a>
                            <a href="" class="btn btn-danger"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>`;
                    console.log(newRow)
                    $("table tbody").append(newRow);
                    // Clear the form
                    $("#formUsuarios")[0].reset();
                    
                } else {
                    alert(data.message);
                    console.log("nofunkopapito")
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