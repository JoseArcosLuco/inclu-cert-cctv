<?php
    include("../includes/Database.class.php");


    $database = new Database();
    $conn = $database->getConnection();
    $stmt = $conn->prepare('SELECT id, nombre, estado FROM cctv_tipo_planta WHERE estado=1');
    if($stmt->execute()){
        $result = $stmt->fetchAll();
        $rows = $stmt->rowCount();
        if($rows>0){
            echo 'rows:'.$rows;
        }else{
            echo 'rows-else:'.$rows;
        }
        print_r(json_encode($result));
    }

   
    // $data = array();
    // if ($rows > 0) {
    //     while ($row = $result) {
    //         $data[] = $row;
    //     }
    // }







?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Mantenedor de CCTV Tipo Plantas</h3>
            </div> 
            <div class="card-body p-0">
                
                <form id="dataForm">
                    <label for="id">ID:</label>
                    <input type="number" id="id" name="id" required>
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

    
    <table id="dataTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "ajax": "api/get_data.php",
                "columns": [
                    { "data": "id" },
                    { "data": "nombre" },
                    { "data": "estado", "render": function(data, type, row) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    }}
                ]
            });

            $('#dataForm').on('submit', function(event) {
                event.preventDefault();
                var id = $('#id').val();
                var nombre = $('#nombre').val();
                var estado = $('#estado').val();
                table.row.add({
                    "id": id,
                    "nombre": nombre,
                    "estado": estado == 1 ? 'Activo' : 'Inactivo'
                }).draw(false);
                this.reset();
            });
        });
    </script>