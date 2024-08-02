<?php
include("./includes/Database.class.php");

require_once('./includes/Clientes.class.php');
require_once('./includes/Plantas.class.php');
require_once('./includes/Operadores.class.php');

$clientes = Clientes::get_all_clients();
$plantas = Plantas::get_all_plantas();
$operadores = Operadores::get_all_operadores_without_turno();
?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4 col-12">
            <div class="card-header p-3 d-flex align-items-center justify-content-start">
                <div class="dropdown col-md-2 col-7">
                    <button class="btn btn-success dropdown-toggle d-flex align-items-center justify-content-start gap-2 fs-5" data-bs-toggle="dropdown" aria-expanded="false">
                        Agregar Reporte
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($clientes as $cliente): ?>
                        <li>
                            <a class="dropdown-item"
                            href="<?php echo $base_url?>/formularios.php?cliente=<?php echo $cliente['id']?>&form=informeperiodico&token=<?php echo $token;?>"
                            name="addUser" 
                            id="addUser">
                                <?php echo htmlspecialchars($cliente['nombre']);?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="card-title d-flex align-items-center justify-content-end gap-1 col-md-2 col-5">Cliente:
                    <select class="form-select form-select-sm" name="cliente" id="cliente">
                        <option value="">Seleccione</option>
                        <?php foreach ($clientes as $cliente): ?>
                        <option value="<?php echo $cliente['id']?>" ><?php echo htmlspecialchars($cliente['nombre']);?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Operador
                            </th>
                            <th>
                                Planta
                            </th>
                            <th class="text-center">
                                N° de Camaras
                            </th>
                            <th class="text-center">
                                N° de Camaras en Linea
                            </th>
                            <th class="text-center">
                                Canal Visualización
                            </th>
                            <th>
                                Observación
                            </th>
                            <th class="text-center">
                                % de Visualización
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
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    //Editar Reporte
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var data = tablaReporte.row($(this).parents('tr')).data();
        $('#formReporte').attr('data-action', 'edit_reporte');
        $('#formReporte').attr('data-id', data.id);
        $('#id_planta').val(data.id_plantas);
        $('#nombre').val(data.nombre);
        $('#estado').val(data.estado);

        $('#modalCRUD').modal('show');
    });

    //Eliminar Reporte
    $('#tabla tbody').on('click', '.btnBorrar', function() {
    var $row = $(this).closest('tr');  // Capturamos la fila correctamente
    var data = tablaReporte.row($row).data();
    var reporteId = data.id;
    
    if (confirm('¿Estás seguro de que deseas eliminar esta cámara?')) {
        $.ajax({
            type: "POST",
            url: "./ajax_handler/reportes.php",
            data: { action: 'delete_reporte', id: reporteId },
            datatype: "json",
            encode: true,
            success: function(response) {
                if (response.status) {
                    // Remover la fila de la tabla
                    tablaCamaras.row($row).remove().draw()  ;
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready( function(){
        var plantas = <?php echo json_encode($plantas); ?>;
        var plantasMap = {};

        plantas.forEach(function(planta) {
            plantasMap[planta.id] = planta.nombre;
        });

        var operadores = <?php echo json_encode($operadores); ?>;
        var operadoresMap = {};

        operadores.forEach(function(operador) {
            operadoresMap[operador.id] = operador.nombre;
        });

        tablaReporte =  $('#tabla').DataTable({
            responsive: true,
            "ajax": {            
                "url": "./ajax_handler/reportes.php",
                "type": 'POST',
                "data": {action: 'get_reportes'},
                "dataSrc": ""
            },
            "columns":[
                {   
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {   
                    "data": "fecha",
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "id_operador",
                    "render": function(data) {
                        return operadoresMap[data] || 'Desconocido';
                    }
                },
                {   
                    "data": "id_planta",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "camaras",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "camaras_online",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "canal",
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
                    }
                },
                {
                    "data": "observacion",
                },
                {   
                    "data": null,
                    "render": function(data, type, row) {
                        var porcentaje = 0;
                        if (row.camaras && row.camaras_online) {
                            porcentaje = Math.round(row.camaras_online / row.camaras * 100);
                        }
                        return '%' + porcentaje;
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-center');
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
<!-- end::Script -->
    
</body>
</html>