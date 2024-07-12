<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Bordered Table</h3>
                                </div> <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="datatable" class="display" style="width:100%">
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
                                            </tr>
                                        </thead>
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
        $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
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
                { "data": "estadoreporte" }
            ]
        });
    });
</script>