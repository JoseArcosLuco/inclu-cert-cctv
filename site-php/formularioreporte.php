<?php   
include("./includes/Database.class.php");
require_once("./includes/Clientes.class.php");


$database = new Database();
$conn = $database->getConnection();
$stmt = $conn->prepare('SELECT id, nombre FROM cctv_plantas WHERE estado =1');
if($stmt->execute()){
    $resultPlantas = $stmt->fetchAll();
    $rows = $stmt->rowCount();
    if($rows>0){
        $dataPlantas = $resultPlantas;
    }else{
        $dataPlantas = null;
    }
}

$stmt = $conn->prepare('SELECT id, nombre FROM cctv_jornada WHERE estado =1');
if($stmt->execute()){
    $resultJornadas = $stmt->fetchAll();
    $rows = $stmt->rowCount();
    if($rows>0){
        $dataJornadas = $resultJornadas;
    }else{
        $dataJornadas = null;
    }
}

$clientes = Clientes::get_all_clients();
?>


<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row g-2 p-4"> 
            <div class="col-md-12 col-xs-6"> <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-2"> <!--begin::Header-->
                    <div class="card-header d-flex gap-5 justify-content-start align-items-center">
                        <div class="card-title">Ingreso Reporte Turno</div>
                        <div class="card-title d-flex align-items-center gap-1">Cliente:
                            <select class="form-select" name="id_cliente" id="id_cliente">
                                <option value="">Seleccione</option>
                                <?php foreach ($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['id']?>" ><?php echo htmlspecialchars($cliente['nombre']);?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> <!--end::Header--> <!--begin::Form-->
                    <form id="dataForm" name="dataForm"> <!--begin::Body-->
                        <input type="hidden" id="id_aux" name="id_aux">
                        <input type="hidden" id="acciones" name="acciones">
                        <div class="card-body">
                            <div class="mb-1"> 
                                <label class="form-label">Fecha Turno</label> 
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                                <div id="emailHelp" class="form-text">
                                    Reportar fecha y hora exacta para el registro interno.
                                </div>
                            </div>
                            <div class="mb-1"> 
                                <label class="form-label">Planta</label> 
                                <select class="form-control" name="planta" id="planta" required>
                                    <option value="">Seleccione un Cliente</option>
                                </select>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Jornada</label> 
                                <select class="form-control" name="jornada" id="jornada" onchange="javascript:buscarturno(this.value);" required>
                                    <option value="">Seleccione</option>
                                    <?php foreach ($dataJornadas as $row){  ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Turno</label> 
                                <select class="form-control" name="turno" id="turno" onchange="javascript:buscarhorario();buscarresponsables();" required>
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Horario</label>
                                <input type="text" class="form-control" id="horario" name="horario" readonly>
                            </div>
                            <div class="row mb-3"> 
                                <div class="col-4">
                                    <label class="form-label">Camaras Intermitencia</label>
                                    <input type="number" class="form-control" id="conintermitencia" name="conintermitencia" required>  
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Camaras Sin Conexion</label>
                                    <input type="number" class="form-control" id="camarassinconexion" name="camarassinconexion" required>  
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Camaras Totales</label>
                                    <input type="number" class="form-control" id="camarastotales" name="camarastotales" required>  
                                </div>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Responsable</label> 
                                <select class="form-control" name="responsable" id="responsable" required>
                                    <option value="">Seleccione</option>
                                </select> 
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Planta En Linea</label> 
                                <select class="form-control" name="planta_sin_conexion" id="planta_sin_conexion" required>
                                    <option value="">Seleccione</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select> 
                            </div>
                            <div class="mb-3"> 
                                <label for="exampleInputPassword1" class="form-label">Observaciones Turno</label> 
                                <input type="text" class="form-control" name="obs_turno" id="obs_turno" required> 
                            </div>
                            <div class="mb-3"> 
                                <label for="exampleInputPassword1" class="form-label">Observaciones Semana</label> 
                                <input type="text" class="form-control" name="obs_semana" id="obs_semana"> 
                            </div>

                            
                        </div> <!--end::Body--> <!--begin::Footer-->
                        <div class="card-footer"> 
                            <button type="submit" class="btn btn-primary" id="submitBtn">Enviar Reporte</button> 
                        </div> <!--end::Footer-->
                        <div class="col-md-6" id="mensaje" name="mensaje"> 
                
                        </div>
                    </form> <!--end::Form-->
                </div> <!--end::Quick Example--> <!--begin::Input Group-->
                
                <!--begin::Horizontal Form-->
                
            </div> <!--end::Col--> <!--begin::Col-->
            <div class="col-md-6"> 
                
            </div> <!--end::Col-->
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
//ver las plantas según el cliente ingresado
$(document).ready(function() {
    $('#id_cliente').change(function() {
        var id_cliente = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'formularioreporteback.php',
            data: {id_cliente: id_cliente,
                acciones: 'get_plantas'
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var $plantaSelect = $('#planta');
                $plantaSelect.empty();
                $.each(data, function(index, planta) {
                    $plantaSelect.append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
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
    function buscarturno(idJornada){
        document.getElementById('acciones').value = 'buscarturnos';
        document.getElementById('id_aux').value = idJornada;

        $.ajax({
            url: 'formularioreporteback.php',
            type: 'POST',
            data: { 
                id_aux: document.getElementById('id_aux').value,
                id_planta: document.getElementById('planta').value,
                acciones: document.getElementById('acciones').value
            },
            success: function(response) {
                // Asumiendo que el PHP retorna una lista de opciones en formato HTML
                $('#turno').html(response);
            }
        });
    }
    function buscarresponsables(){
        document.getElementById('acciones').value = 'buscarresponsables';

        $.ajax({
            url: 'formularioreporteback.php',
            type: 'POST',
            data: { 
                id_aux: document.getElementById('id_aux').value,
                id_planta: document.getElementById('planta').value,
                id_turno: document.getElementById('turno').value,
                acciones: document.getElementById('acciones').value
                },
            success: function(response) {
                // Asumiendo que el PHP retorna una lista de opciones en formato HTML
                $('#responsable').html(response);
            }
        });
    }

    function buscarhorario(){
        if (document.getElementById('jornada').value === 1){
            document.getElementById('horario').value = "08:00 A 20:00 HRS."
        }else{
            document.getElementById('horario').value = "20:00 A 08:00 HRS."
        }
    }


    $(document).on("submit","#dataForm",function(e){
        e.preventDefault();
        $('#submitBtn').attr("disabled", true);
        $("#submitBtn").attr("value", 'Enviando...');
        const self = this;
        document.getElementById('acciones').value = 'grabarreporte';
        $.ajax({
            type: 'post',
            url: 'formularioreporteback.php',
            data: $(this).serialize(),
            dataType: 'text',
            cache: false,
            async: true,
            success: function (response) {
                alert(response);
                $('#submitBtn').attr("disabled", false);
                $("#submitBtn").attr("value", 'Enviar Reporte');
                $('#mensaje').html(response).fadeIn('slow');
                $('#mensaje').delay(5000).fadeOut('slow');
                document.getElementById("dataForm").reset();
            },
            error: function (response) {
                alert(response);
                $('#submitBtn').attr("disabled", false);
                $("#submitBtn").attr("value", 'Enviar Reporte');
                $('#mensaje').html(response).fadeIn('slow');
                $('#mensaje').delay(5000).fadeOut('slow');
            },
        });
    });
</script>