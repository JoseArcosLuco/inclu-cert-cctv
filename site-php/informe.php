<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Puedes buscar por planta, fecha, nombre usuario </h3>
                                </div> <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="datatable" class="table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Planta</th>
                                                <th>Nombre Usuario</th>
                                                <th>Turno</th>
                                                
                                                <th>Horario</th>
                                                <th>Planta en Línea</th>
                                                <th>Cámaras Con Intermitencia</th>
                                                <th>Cámaras sin Conexión</th>
                                                <th>Cámaras Totales</th>
                                                <th>Observaciones</th>
                                                <th>Fecha Gestion</th>
                                                <th>Fecha Registro</th>
                                                <th>Estado Reporte</th>
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



<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {

        var perfil = '<?php echo $perfilUsuario; ?>';

        tablaInforme = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "informedatos.php",
            "columns": [
                { "data": "id" },
                { "data": "planta" },
                { "data": "nombreusuario" },
                { "data": "turno" },
                { "data": "horario" },
                { "data": "planta_en_linea" },
                { "data": "camarasintermitencia" },
                { "data": "camaras_sin_conexion" },
                { "data": "camaras_totales" },
                { "data": "observaciones" },
                { "data": "fecha_gestion" },
                { "data": "fecha_registro" },
                { "data": "estadoreporte" },
                {"defaultContent": "<div class='text-center d-md-block'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>assignment</i></button></div></div>"}
            ],
            "createdRow": function(row, data, dataIndex) {
                $(row).attr('data-id', data.id); // Añadir atributo data-id

                if (data.estadoreporte !== 'Aprobado') {
                    $(row).find('button.btnEditar').prop('disabled', true);
                }

                if(perfil === 'Admin' || perfil === 'Supervisor'){
                    $(row).find('.btn-group').append('<button class="btn btn-success btn-sm"><i class="material-icons">check</i></button><button class="btn btn-danger btn-sm"><i class="material-icons">remove_done</i></button>');
                    if(data.estadoreporte === 'Aprobado'){
                        $(row).find('button.btn-success').prop('disabled', true);
                    }else{
                        $(row).find('button.btn-danger').prop('disabled', true);
                    }
                }
            },
            "language": {
                "url": "./assets/json/espanol.json"
            }
        });

        $('#datatable tbody').on('click', '.btn-success , .btn-danger', function() {
            var $row = $(this).closest('tr');
            var data = tablaInforme.row($row).data();
            var formularioId = data.id;
            var action = $(this).hasClass('btn-success') ? 'aprobar_informe' : 'desaprobar_informe';

            $.ajax({
                url: "./ajax_handler/informe.php",
                type: 'POST',
                data: { action: action, id: formularioId },
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        if(action === 'aprobar_informe') {
                            data.estadoreporte = 'Aprobado';
                            $row.find('button.btn-success').prop('disabled', true);
                            $row.find('button.btnEditar').prop('disabled', false);
                        }else{
                            data.estadoreporte = 'Por Aprobar';
                            $row.find('button.btn-success').prop('disabled', false);
                            $row.find('button.btn-danger').prop('disabled', true);
                        }
                        tablaInforme.row($row).data(data).draw(false);
                    } else {
                        alert("No se pudo aprobar el informe.");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error en AJAX:', textStatus, errorThrown);
                }
            });
        });
    });


    //Editar Turnos
    $('#datatable tbody').on('click', '.btnEditar', function() {
        var $row = $(this).closest('tr');
        var data = tablaInforme.row($(this).parents('tr')).data();
        var data = tablaInforme.row($row).data();
        var formularioId = data.id;
        alert(formularioId);
        window.open("reportetest.php?id_gestion_plantas=" + formularioId);
        //$('#formTurno').attr('data-action', 'edit_turno');
        //$('#formTurno').attr('data-id', data.id);
        //$('#nombre').val(data.nombre);
        //$('#id_plantas').val(data.id_plantas);
        //$('#id_jornada').val(data.id_jornada);
        //$('#estado').val(data.estado);

        //$('#modalCRUD').modal('show');
    });
</script>