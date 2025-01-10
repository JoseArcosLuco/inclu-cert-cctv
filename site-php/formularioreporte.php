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
        <form id="dataForm" name="dataForm"> <!--begin::Body-->
        <div class="row g-2 p-4"> 
            <div class="col-md-6 col-xs-4 "> <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-2"> <!--begin::Header-->
                    <div class="card-header d-flex justify-content-start align-items-center">
                        <div class="card-title col-4 col-md-6">Ingreso Reporte Turno</div>
                        <div class="card-title d-flex align-items-center gap-1 col-8 col-md-6">Cliente:&nbsp;
                            <select class="form-select form-select-sm" style="min-width: min-content !important;" name="id_cliente" id="id_cliente" tabindex="1" autofocus>
                                <option value="">Seleccione</option>
                                <?php foreach ($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['id']?>" ><?php echo htmlspecialchars($cliente['nombre']);?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> <!--end::Header--> <!--begin::Form-->
                    
                        <input type="hidden" id="id_aux" name="id_aux">
                        <input type="hidden" id="acciones" name="acciones">
                        <div class="card-body">
                            <div class="mb-3"> 
                                <label class="form-label">Fecha Turno</label> 
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                                <div id="emailHelp" class="form-text">
                                    Reportar fecha y hora exacta para el registro interno.
                                </div>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Planta</label> 
                                <select class="form-control" name="planta" id="planta" required>
                                    <option value="">Seleccione un Planta</option>
                                </select>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Jornada</label> 
                                <select class="form-control" name="jornada" id="jornada" required">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($dataJornadas as $row){  ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Turno</label> 
                                <select class="form-control" name="turno" id="turno" required>
                                    <option value="">Seleccione una Planta</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="horario">Horario</label>
                                <div class="d-flex align-items-center gap-1">
                                    <input type="text" class="form-control" id="horario" name="horario" readonly>
                                    <a 
                                    class="btn btn-secondary btn-sm" 
                                    href="<?php echo $base_url?>/formularios.php?form=turnos&token=<?php echo $token;?>"
                                    target="_blank"
                                    title="Ver horarios"
                                    >
                                        <i class="material-icons">open_in_new</i>
                                        <span class="d-none">Ver horarios</span>
                                    </a>
                                </div>
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
                                    <input type="number" class="form-control" id="camarastotales" name="camarastotales" readonly>  
                                </div>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Responsable</label> 
                                <div class="d-flex align-items-center gap-1">
                                    <select class="form-control" name="responsable" id="responsable">
                                        <option value="">Seleccione</option>
                                    </select> 
                                    <a 
                                    class="btn btn-secondary btn-sm" 
                                    href=""
                                    target="_blank"
                                    title="Ver Responsables"
                                    hidden
                                    id="open_responsables"
                                    >
                                        <i class="material-icons">open_in_new</i>
                                        <span class="d-none">Ver Responsables</span>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3"> 
                                <label class="form-label">Planta En Linea</label> 
                                <select class="form-control" name="planta_sin_conexion" id="planta_sin_conexion">
                                    <option value="">Seleccione</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select> 
                            </div>
                            <div class="mb-3"> 
                                <label for="exampleInputPassword1" class="form-label">Observaciones Turno</label> 
                                <input type="text" class="form-control" name="obs_turno" id="obs_turno" required> 
                            </div>
                            

                            
                        </div> <!--end::Body--> <!--begin::Footer-->
                        <div class="card-footer d-flex gap-3"> 
                            <button type="submit" class="btn btn-primary" id="submitBtn">Enviar Reporte</button> 
                            <button class="btn btn-secondary btn-sm" id="refreshBtn" title="Refrescar Formulario" style="display: flex; justify-content: center; align-items: center;">
                                <i class="material-icons">refresh</i>
                            </button>
                        </div> <!--end::Footer-->
                        <div class="col-md-6" id="mensaje" name="mensaje"> 
                
                        </div>
                    
                </div> <!--end::Quick Example--> <!--begin::Input Group-->
                
                <!--begin::Horizontal Form-->
                
            </div> <!--end::Col--> <!--begin::Col-->
            <div class="col-md-6"> 
                <div class="card card-danger card-outline mb-4"> 
                    <div class="card-header p-4">
                        <div class="card-title">Gestión Camaras</div>
                    </div>
                    <div class="card-body" name="plantaCamaras" id="plantaCamaras"> <!--begin::Row-->
                        <div class="row d-flex align-items-center"> <!--begin::Col-->
                            <div class="col-12"> Seleccione una Planta </div> <!--end::Col--> <!--begin::Col-->
                        </div> <!--end::Row-->
                    </div>
                </div>
            </div> <!--end::Col-->
            
        </div> <!--end::Row-->
    </form> <!--end::Form-->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script>
//ver las plantas según el cliente ingresado
$(document).ready(function() {

    $('#id_cliente').change(onChangeClientes);

    $('#planta').change( () => {
        onChangePlantas();
        getTurnos();
    });
    
    $('#jornada').change(getTurnos);

    $('#turno').change(() => {
        onChangeTurnos();
        buscarresponsables();
    });

    $('#refreshBtn').click(() => {
        getTurnos();
        onChangeTurnos();
        buscarresponsables();
    });

    function onChangeClientes() {
        let id_cliente = $("#id_cliente").val();

        $.ajax({
            type: 'POST',
            url: 'formularioreporteback.php',
            data: {id_cliente: id_cliente,
                acciones: 'get_plantas'
            },
            dataType: 'json',
            success: function(data) {
                let $plantaSelect = $('#planta');
                $plantaSelect.empty();
                $plantaSelect.append('<option value="">-Seleccione-</option>');
                $.each(data, function(index, planta) {
                    $plantaSelect.append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        });
    }

    function getTurnos() {
    
        let id_plantas = $('#planta').val();
        let id_jornada = $('#jornada').val();

        $.ajax({
            type: 'POST',
            url: 'formularioreporteback.php',
            data: {id_plantas: id_plantas,
                id_jornada: id_jornada,
                acciones: 'get_turnos'
            },
            dataType: 'json',
            success: function(data) {
                let $turnoSelect = $('#turno');
                $turnoSelect.empty();
                $turnoSelect.append('<option value="">-Seleccione-</option>');
                $.each(data, function(index, turno) {
                    $turnoSelect.append('<option value="' + turno.id + '">' + turno.nombre + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        });
    };

    function onChangePlantas() {
        let id_plantas = $("#planta").val();

        $.ajax({
            type: 'POST',
            url: 'formularioreporteback.php',
            data: {id_plantas: id_plantas,
                acciones: 'get_plantas_camaras'
            },
            dataType: 'json',
            success: function(data) {
                var $plantaCamarasSelect = $('#plantaCamaras');
                var $camaraConcatenado = '';
                var $cantidadcamaras = 0;
                $plantaCamarasSelect.empty();
                
                $.each(data, function(index, planta) {
                        $cantidadcamaras ++;
                        $camaraConcatenado = '';
                        $camaraConcatenado = $camaraConcatenado + '<div class="row d-flex align-items-center p-2">'; 
                        $camaraConcatenado = $camaraConcatenado + '<input type="hidden" name="idcamaras_' + $cantidadcamaras + '" id="idcamaras_' + $cantidadcamaras + '" value="' + planta.id + '"><div class="col-3"> ' + planta.nombre + ' </div>';
                        $camaraConcatenado = $camaraConcatenado + '<div class="col-3">';
                        $camaraConcatenado = $camaraConcatenado + '<label class="form-check-label">Habilitada: ';
                        $camaraConcatenado = $camaraConcatenado + '<input type="checkbox" class="form-check-input" name="checkbox_' + $cantidadcamaras + '" id="checkbox_' + $cantidadcamaras + '" placeholder=".col-4">';
                        $camaraConcatenado = $camaraConcatenado + '</label></div>';
                        $camaraConcatenado = $camaraConcatenado + '<div class="col-6"> <input type="text" class="form-control" name="camara_obs_' + $cantidadcamaras + '" id="camara_obs_' + $cantidadcamaras + '" placeholder="observaciones"></div>';
                        $camaraConcatenado = $camaraConcatenado + '</div>';
                        $plantaCamarasSelect.append($camaraConcatenado);
                        
                });
                document.getElementById('camarastotales').value = $cantidadcamaras;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        });
    }

    function onChangeTurnos() {
        let turno_id = $("#turno").val();
        let planta_id = $("#planta").val();
        
        $("#open_responsables").prop("href", "<?php echo $base_url?>/formularios.php?form=operador&turno=" + turno_id +"&token=<?php echo $token;?>");
        $("#open_responsables").prop("hidden", false);

        $.ajax({
            url: 'formularioreporteback.php',
            type: 'POST',
            data: {
                turno_id: turno_id,
                acciones: 'get_turno_info'
            },
            dataType: 'json',
            success: function(data) {
                let horarioInput = $('#horario');
                horarioInput.empty();
                horarioInput.val(moment(data.hora_entrada, 'HH:mm:ss').format('HH:mm') + ' - ' + moment(data.hora_salida, 'HH:mm:ss').format('HH:mm'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
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

    $(document).on("submit","#dataForm",function(e){
        e.preventDefault();
        $('#submitBtn').attr("disabled", true);
        $("#submitBtn").attr("value", 'Enviando...');
        document.getElementById('acciones').value = 'grabarreporte';
        let data = $(this).serialize();
        console.log(data)
        $.ajax({
            type: 'post',
            url: 'formularioreporteback.php',
            data: data,
            dataType: 'text',
            cache: false,
            async: true,
            success: function (response) {
                //alert(response);
                $('#submitBtn').attr("disabled", false);
                $("#submitBtn").attr("value", 'Enviar Reporte');
                $('#mensaje').html(response).fadeIn('slow');
                $('#mensaje').delay(5000).fadeOut('slow');
                document.getElementById("dataForm").reset();
            },
            error: function (response) {
                //alert(response);
                $('#submitBtn').attr("disabled", false);
                $("#submitBtn").attr("value", 'Enviar Reporte');
                $('#mensaje').html(response).fadeIn('slow');
                $('#mensaje').delay(5000).fadeOut('slow');
            },
        });
    });

});
</script>