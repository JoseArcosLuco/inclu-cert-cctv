<?php
    include("../includes/Database.class.php");
    include("../includes/TipoPlanta.class.php");

    isset($_POST['acciones']) ? $acciones = $_POST['acciones'] : $acciones = 'agregar';
    isset($_POST['token']) ? $token = $_POST['token'] : $token = '';


    $database = new Database();
    $conn = $database->getConnection();
    $stmt = $conn->prepare('SELECT id, nombre, estado FROM cctv_tipo_planta WHERE estado=1');
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
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" required>
                                <label for="estado">Estado:</label>
                                <select id="estado" name="estado" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                <button type="submit">Agregar</button>
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
                                                <button type="button" onclick="removeRow(this)" name="delete_row[]" style="margin-right:10px;" value="">Delete</button>
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
        function removeRow(el) {
            el.parentNode.remove();
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