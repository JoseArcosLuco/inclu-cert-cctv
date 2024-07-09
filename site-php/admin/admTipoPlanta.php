<?php
    include("../includes/Database.class.php");
    include("../includes/TipoPlanta.class.php");

    isset($_POST['acciones']) ? $acciones = $_POST['acciones'] : $acciones = 'agregar';
    isset($_POST['token']) ? $token = $_POST['token'] : $token = '';


    $database = new Database();
    $conn = $database->getConnection();
    $stmt = $conn->prepare('SELECT id, nombre, estado FROM cctv_tipo_planta WHERE estado in (0,1)');
    if($stmt->execute()){
        $result = $stmt->fetchAll();
        $rows = $stmt->rowCount();
        if($rows>0){
            //echo 'rows:'.$rows;
        }else{
            //echo 'rows-else:'.$rows;
        }
        
    }
    $data = $result;

    //print_r($data);
 
?>

    <div class="app-content"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Mantenedor de CCTV Tipo Plantas</h3>
                        </div> 
                        <div class="card-body p-0">
                            
                            <form id="dataForm">
                            <input type="hidden" id="acciones" name="acciones" value="<? echo $acciones?>">    
                            <input type="hidden" id="id_aux" name="id_aux" value="">    
                                <div class="mb-3" >
                                    <label class="form-label fw-bold" for="nombre">Nombre:</label>
                                    <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingresa Nombre" required>
                                </div>
                                <div class="mb-3" >
                                    <label class="form-label fw-bold" for="estado">Estado:</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                                <div class="mb-3" >
                                    <button class="btn btn-primary" type="submit">Agregar</button>
                                </div>
                                
                                
                            </form>
                        </div>
                    </div>       
                </div>
            </div>
                <div class="row">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Striped Full Width Table</h3>
                        </div>
                        <div class="card-body p-0">    
                            <table id="dataTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? foreach ($data as $row){  ?>
                                        <tr class="align-middle">
                                            <td><?php echo $row["id"]; ?> </td>
                                            
                                            <td><?php echo $row["nombre"]; ?></td>
                                            <td>
                                                <?php echo $row["estado"] == 1 ? 'Activo' : 'Inactivo'; ?>
                                            </td>
                                            <td>
                                                <button type="button" onclick='removeRow(<?php echo $row["id"]; ?>)' class="btn btn-danger" value="">Delete</button>
                                                &nbsp;<button type="button" onclick="actualizaEstado(this)" class="btn btn-secondary" value="<?php echo $row["estado"] ?>">Activar/Desactivar</button>
                                            </td>
                                        </tr>
                                    <? }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function removeRow(id) {
            
            document.getElementById('acciones').value = 'eliminar';
            document.getElementById('id_aux').value = id;
            
            $.ajax({
                type: 'post',
                url: 'TipoPlanta.php',
                data: {
                    id_aux: document.getElementById('id_aux').value,
                    acciones: document.getElementById('acciones').value
                },
                dataType: 'text',
                success: function (response) {
                    alert(response);
                },
                error: function (response) {
                    alert(response);
                },
            });
        }   
        
        $(document).on("submit","#dataForm",function(e){
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: 'TipoPlanta.php',
                data: $(this).serialize(),
                dataType: 'text',
                success: function (response) {
                    alert(response);
                },
                error: function (response) {
                    alert(response);
                },
            });
        });
    </script>