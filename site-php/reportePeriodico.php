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
            <div class="card-header card-header p-3 d-flex justify-content-start align-items-center gap-4">
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle d-flex align-items-center justify-content-start gap-1 fs-5" data-bs-toggle="dropdown" aria-expanded="false">
                        Agregar Reporte
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($clientes as $cliente): ?>
                            <li>
                                <a class="dropdown-item"
                                    href="<?php echo $base_url ?>/formularios.php?cliente=<?php echo $cliente['id'] ?>&form=informeperiodico&token=<?php echo $token; ?>"
                                    name="addUser"
                                    id="addUser">
                                    <?php echo htmlspecialchars($cliente['nombre']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class='btn btn-success p-2 dropdown-toggle'
                    title="Exportar a Excel"
                    data-bs-toggle="dropdown" 
                    aria-expanded="false"
                    >
                        <svg class='bi bi-file-earmark-excel-fill'
                            height='24' width='24'
                            xmlns='http://www.w3.org/2000/svg'
                            viewBox='0 0 26 26'
                            xml:space='preserve'>
                            <path style='fill:#fff'
                                d='M25 3h-9v3h3v2h-3v2h3v2h-3v2h3v2h-3v2h3v2h-3v3h9l1-1V4l-1-1zm-1 17h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4V6h4v2zM0 3v20l15 3V0L0 3zm9 15-1-3v-1l-1 1-1 3H3l3-5-3-5h3l1 3 1 1v-1l2-3h2l-3 5 3 5H9z' />
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item"
                                id="btnExcelActual">
                                Exportar tabla actual
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item"
                                id="btnExcelSelected">
                                Exportar elementos seleccionados
                            </button>
                        </li>
                    </ul>
                </div>
                <label class="card-title col-2 p-0">Cliente:
                    <select class="form-select d-flex" name="cliente" id="cliente">
                        <option value="" selected>Ver Todos</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="card-title col-2 p-0">Planta:
                    <select class="form-select d-flex" name="filtro_planta" id="filtro_planta" disabled> 
                        <option value="">Seleccione Cliente</option>
                    </select>
                </label>
                <label class="card-title col-2 p-0">Fecha:
                    <input type="date" class="form-control" name="filtro_fecha" id="filtro_fecha" required>
                </label>

                <button id="clean" class="btn btn-secondary p-2" title="Limpiar Filtros">
                    <i class="material-icons">filter_alt_off</i>
                </button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center" style="max-width: 70px;">
                                <svg class='bi bi-file-earmark-excel-fill'
                                height='18' width='18'
                                viewBox='0 0 26 26'
                                xml:space='preserve'>
                                <path style='fill:#fff'
                                    d='M25 3h-9v3h3v2h-3v2h3v2h-3v2h3v2h-3v2h3v2h-3v3h9l1-1V4l-1-1zm-1 17h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4V6h4v2zM0 3v20l15 3V0L0 3zm9 15-1-3v-1l-1 1-1 3H3l3-5-3-5h3l1 3 1 1v-1l2-3h2l-3 5 3 5H9z' />
                                </svg>
                            </th>
                            <th class="text-center">
                                ID
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Hora
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
                            <th class="text-start">
                                Estado
                            </th>
                            <th>
                                Observación
                            </th>
                            <th class="text-center">
                                % de Visualización
                            </th>
                            <th class="text-center">
                                N° Robos
                            </th>
                            <th class="text-center">
                                N° Perdidas de red
                            </th>
                            <th class="text-center">
                                N° Perdidas de internet
                            </th>
                            <th class="text-center">
                                Reconectores Abiertos
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

        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Reporte</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formReporte" name="formReporte">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Cliente:
                                            <select class="form-select" name="id_cliente" id="id_cliente">
                                                <option value="">Seleccione</option>
                                                <?php foreach ($clientes as $cliente): ?>
                                                    <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Planta:
                                                <select class="form-select" name="id_planta" id="id_planta" disabled requiere>
                                                    <option value="">Seleccione Cliente</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Fecha:
                                            <input type="date" class="form-control" name="fecha" id="fecha" requiered>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Hora:
                                            <input type="time" class="form-control" name="hora" id="hora" requiered>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Canal:
                                                <select name="canal" id="canal" class="form-select">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">En Línea</option>
                                                    <option value="2">Intermitente / Baja Señal</option>
                                                    <option value="3">Reconector Abierto</option>
                                                    <option value="4">Pérdida De Red</option>
                                                    <option value="5">Pérdida De Conexión / Sin Confirmar</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">N° de Cámaras:
                                            <input type="number" class="form-control" name="camaras" id="camaras" requiered>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">N° de Cámaras en Linea:
                                                <input type="number" class="form-control" name="camaras_online" id="camaras_online" requiered>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Observación:
                                            <textarea name="observacion" id="observacion" class="form-control" rows="3" requiered></textarea>
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
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        //Editar Reporte
        $('#tabla tbody').on('click', '.btnEditar', function() {
            const $data = tablaReporte.row($(this).parents('tr')).data();
            const fecha = moment($data.fecha).format('YYYY-MM-DD');
            const hora = moment($data.fecha).format('HH:mm');
            $('#id_cliente').prop('disabled', true);
            $('#id_planta').prop('disabled', true);
            $('#camaras').prop('disabled', true);
            $('#camaras').val($data.camaras);
            $('#formReporte').attr('data-action', 'edit_reporte');
            $('#formReporte').attr('data-id', $data.id);
            $('#id_cliente').val($data.id_cliente);
            $('#id_planta').append('<?php foreach ($plantas as $planta): ?>');
            $('#id_planta').append('<option value="<?php echo $planta['id'] ?>" ><?php echo htmlspecialchars($planta['nombre']); ?></option>');
            $('#id_planta').append('<?php endforeach; ?>');
            $('#id_planta').val($data.id_planta);
            $('#fecha').val(fecha !== 'Invalid date' ? fecha : '');
            $('#hora').val(hora !== '00:00' ? hora : '');
            $('#camaras_online').val($data.camaras_online);
            $('#canal').val($data.canal);
            $('#observacion').val($data.observacion);
            $('#modalCRUD .modal-title').text('Editar Reporte');

            $('#modalCRUD').modal('show');

            $('#camaras_online').on('change', function() {
                let camarasOnline = $(this).val();
                let camaras = $('#camaras').val();
                let modal = $('#warningModal .modal-dialog .modal-content');

                if (camarasOnline > camaras) {
                    $('#camaras_online').val(camaras);
                    modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Error en la Reporte ' + $data.id + '</h5>');
                    modal.find('.modal-body').append('<p class="bg-danger text-white text-center p-2 rounded mb-1">El valor de Camaras Online no puede ser mayor al valor de Camaras.</p> <p class="text-center p-2 m-0">Por favor, seleccione una valor menor o igual a ' + camaras + '.</p>');
                    modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
                    $('#warningModal').modal('show');
                }
            });

            $("#formReporte").submit(function(e) {
                e.preventDefault();
                var formData = {
                    action: 'edit_reporte',
                    id: $data.id,
                    fecha: $.trim($('#fecha').val()) + ' ' + $.trim($('#hora').val()),
                    canal: $.trim($('#canal').val()),
                    camaras_online: $.trim($('#camaras_online').val()),
                    observacion: $.trim($('#observacion').val()),
                };
                $.ajax({
                    url: "./ajax_handler/reportes.php",
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        if (data.status) {
                            tablaReporte.ajax.reload();
                            $('#modalCRUD').modal('hide');
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Error en AJAX: " + textStatus, errorThrown);
                    }
                });
            });

        });

        //Formatear Modal
        $('#warningModal').on('hidden.bs.modal', function() {
            var modal = $('#warningModal .modal-dialog .modal-content');
            modal.find('.modal-header h5').remove();
            modal.find('.modal-body p').remove();
            modal.find('.modal-footer button').remove();
        });

        //Eliminar Reporte
        $('#tabla tbody').on('click', '.btnBorrar', function() {
            var $row = $(this).closest('tr'); // Capturamos la fila correctamente
            var data = tablaReporte.row($row).data();
            var reporteId = data.id;
            var modal = $('#warningModal .modal-dialog .modal-content');

            modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
            modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
            modal.find('.modal-body').append('<p>ID: ' + data.id + '</p>');
            modal.find('.modal-body').append('<p>Operador: ' + operadoresMap[data.id_operador] + '</p>');
            modal.find('.modal-body').append('<p>Planta: ' + plantasMap[data.id_planta] + '</p>');
            modal.find('.modal-body').append('<p>Fecha: ' + moment(data.fecha).format('DD/MM/YYYY') || 'Fecha no válida' + '</p>');
            modal.find('.modal-body').append('<p>N° de Cámaras: ' + data.camaras + '</p>');
            modal.find('.modal-body').append('<p>N° de Cámaras en Lína: ' + data.camaras_online + '</p>');
            modal.find('.modal-body').append('<p>Estado: ' + data.canal + '</p>');
            modal.find('.modal-footer').append('<button type="button" class="btn |btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
            modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
            $('#warningModal').modal('show');
            $('#warningModal').on('click', '.btnBorrar', function() {
                $.ajax({
                    type: "POST",
                    url: "./ajax_handler/reportes.php",
                    data: {
                        action: 'delete_reporte',
                        id: reporteId
                    },
                    datatype: "json",
                    encode: true,
                    success: function(response) {
                        if (response.status) {
                            // Remover la fila de la tabla
                            tablaReporte.row($row).remove().draw();
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

        $('#tabla tbody').on('click', '.btnInfo', function() {
            const $row = $(this).closest('tr');
            const data = tablaReporte.row($row).data();
            const modal = $('#warningModal .modal-dialog .modal-content');

            modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Información</h5>');
            modal.find('.modal-body').append('<p>ID: ' + data.id + '</p>');
            modal.find('.modal-body').append('<p>Fecha: ' + moment(data.fecha).format('DD/MM/YYYY') + '</p>');
            modal.find('.modal-body').append('<p>Operador: ' + operadoresMap[data.id_operador] + '</p>');
            modal.find('.modal-body').append('<p>Planta: ' + plantasMap[data.id_planta] + '</p>');
            modal.find('.modal-body').append('<p>N° de Cámaras: ' + data.camaras + '</p>');
            modal.find('.modal-body').append('<p>N° de Cámaras en Línea: ' + data.camaras_online + '</p>');
            modal.find('.modal-body').append('<p>Estado: ' + renderEstado(data.canal) + '</p>');
            modal.find('.modal-body').append('<p>Observación: ' + data.observacion + '</p>');
            modal.find('.modal-body').append('<p>Porcentaje de Visualización: ' + Math.round(( data.camaras_online / data.camaras ) * 100) + '%' + '</p>');
            modal.find('.modal-body').append('<p>N° Robos: ' + data.cantidad_robos + '</p>');
            modal.find('.modal-body').append('<p>N° Reconector abierto: ' +  + '</p>');
            modal.find('.modal-body').append('<p>N° Perdidas de internet: ' + data.cantidad_corte_internet + '</p>');
            modal.find('.modal-body').append('<p>N° Perdidas de red: ' + data.cantidad_corte_energia + '</p>');
            modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>');
            $('#warningModal').modal('show');
        });

        $('#btnExcelActual').click(function() {
            var data = tablaReporte.rows().data().toArray();
            var exportData = data.map(function(rowData) {
                const hora = moment(rowData.fecha).format('HH:mm');
                return {
                    "ID": rowData.id,
                    "Cliente": clientesMap[rowData.id_cliente] || 'Desconocido',
                    "Planta": plantasMap[rowData.id_planta] || 'Desconocido',
                    "Operador": operadoresMap[rowData.id_operador] || 'Desconocido',
                    "Fecha Registro": rowData.fecha ? moment(rowData.fecha).format('DD/MM/YYYY') : 'Sin Fecha',
                    "Hora Registro": hora !== '00:00' ? hora : 'Sin Hora',
                    "N° de Cámaras": rowData.camaras,
                    "N° de Cámaras en Línea": rowData.camaras_online,
                    "Porcentaje de Visualización": Math.round((rowData.camaras_online / rowData.camaras) * 100) + '%',
                    "Observaciones": rowData.observacion,
                    "Estado": renderEstado(rowData.canal)
                };
            });

            var worksheet = XLSX.utils.json_to_sheet(exportData);

            var workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'ReportePeriodico');

            XLSX.writeFile(workbook, 'ReportePeriodico.xlsx');
        });

        $('#btnExcelSelected').click(function() {
            let selectedData = [];
            $('#tabla tbody input.form-check-input:checked').each(function() {
                let row = $(this).closest('tr');
                let rowData = tablaReporte.row(row).data();

                const hora = rowData.fecha ? moment(rowData.fecha).format('HH:mm') : 'Sin Hora';
                selectedData.push({
                    "ID": rowData.id,
                    "Cliente": clientesMap[rowData.id_cliente] || 'Desconocido',
                    "Planta": plantasMap[rowData.id_planta] || 'Desconocido',
                    "Operador": operadoresMap[rowData.id_operador] || 'Desconocido',
                    "Fecha Registro": rowData.fecha ? moment(rowData.fecha).format('DD/MM/YYYY') : 'Sin Fecha',
                    "Hora Registro": hora !== '00:00' ? hora : 'Sin Hora',
                    "N° de Cámaras": rowData.camaras,
                    "N° de Cámaras en Línea": rowData.camaras_online,
                    "Porcentaje de Visualización": rowData.camaras ? Math.round((rowData.camaras_online / rowData.camaras) * 100) + '%' : 'N/A',
                    "Observaciones": rowData.observacion,
                    "Estado": renderEstado(rowData.canal)
                });
            });

            if (selectedData.length === 0) {
                alert('Por favor, selecciona al menos una fila para exportar.');
                return;
            }

            let worksheet = XLSX.utils.json_to_sheet(selectedData);

            let workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'ReportePeriodicoSeleccionados');
            XLSX.writeFile(workbook, 'ReportePeriodicoSeleccionados.xlsx');
        });

        var plantas = <?php echo json_encode($plantas); ?>;
        var plantasMap = {};

        plantas.forEach(function(planta) {
            plantasMap[planta.id] = planta.nombre;
        });

        var clientes = <?php echo json_encode($clientes); ?>;
        var clientesMap = {};

        clientes.forEach(function(cliente) {
            clientesMap[cliente.id] = cliente.nombre;
        });

        var operadores = <?php echo json_encode($operadores); ?>;
        var operadoresMap = {};

        operadores.forEach(function(operador) {
            operadoresMap[operador.id] = operador.nombre;
        });

        function renderEstado(data) {
            const estados = {
                1: 'En Linea',
                2: 'Intermitente/ Baja señal',
                3: 'Reconector Abierto',
                4: 'Pérdida De Red',
                5: 'Pérdida De Conexión / Sin Confirmar',
            };
            return estados[data] || 'Desconocido';
        }

        $('#cliente').on('change', function() {
            const id_cliente = $('#cliente').val();

            $.ajax({
                type: 'POST',
                url: './ajax_handler/reportes.php',
                data: {
                    action: 'get_plantas',
                    id_cliente: id_cliente
                },
                dataType: 'json',
                success: function(data) {
                    var $plantaSelect = $('#filtro_planta');
                    $plantaSelect.empty();
                    $plantaSelect.append('<option value="">Seleccione</option>');
                    $.each(data, function(index, planta) {
                        $plantaSelect.append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                    });
                }
            })
            
            if ($('#cliente').val() === '') {
                $('#filtro_planta').prop('disabled', true);
            } else {
                $('#filtro_planta').prop('disabled', false);
            }
            tablaReporte.ajax.reload();
        });

        $('#filtro_fecha').on('change', function() {
            if ($('#filtro_fecha').val() === '') {
                tablaReporte.columns([3, 6, 7]).visible(true);
            } else {
                tablaReporte.columns([3, 6, 7]).visible(false);
            }

            tablaReporte.ajax.reload();
        });

        $('#filtro_planta').on('change', function() {
            if ($('#filtro_planta').val() === '') {
                tablaReporte.columns([3, 6, 7]).visible(true);
            } else {
                tablaReporte.columns([3, 6, 7]).visible(false);
            }

            tablaReporte.ajax.reload();
        });

        $('#clean').on('click', function() {
            $('#cliente').val('');
            $('#filtro_fecha').val('');
            $('#filtro_planta').val('');
            tablaReporte.columns([3, 6, 7]).visible(true);
            tablaReporte.ajax.reload();
        });

    
        let groupColumn = 2;

        let tablaReporte = $('#tabla').DataTable({
            responsive: true,
            ajax: {
                url: "./ajax_handler/reportes.php",
                type: 'POST',
                data: function (d) {
                    let data = {
                        action: 'get_reportes'
                    };
                    data.cliente = $('#cliente').val();
                    data.fecha = $('#filtro_fecha').val();
                    data.planta = $('#filtro_planta').val();
                    return data;
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: null,
                    defaultContent: "<input type='checkbox' class='form-check-input'/>",
                    orderable: false,
                    className: "text-center"
                },
                {
                    data: "id",
                    className: "text-center"
                },
                {
                    data: "fecha",
                    render: function (data) {
                        return moment(data).format('DD/MM/YYYY');
                    },
                    className: "visually-hidden"
                },
                {
                    data: "fecha",
                    render: function (data) {
                        const hora = moment(data).format('HH:mm');
                        return hora === '00:00' ? 'Sin Hora' : hora;
                    },
                    className: "visually-hidden",
                },
                {
                    data: "id_operador",
                    render: function (data) {
                        return operadoresMap[data] || 'Desconocido';
                    }
                },
                {
                    data: "id_planta",
                    render: function (data) {
                        return plantasMap[data] || 'Desconocido';
                    },
                    className: "text-capitalize"
                },
                {
                    data: "camaras",
                    className: "text-center"
                },
                {
                    data: "camaras_online",
                    className: "text-center"
                },
                {
                    data: "canal",
                    render: renderEstado,
                    className: "text-start text-capitalize"
                },
                {
                    data: "observacion"
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var porcentaje = 0;
                        if (row.camaras && row.camaras_online) {
                            porcentaje = Math.round(row.camaras_online / row.camaras * 100);
                        }
                        return '%' + porcentaje;
                    },
                    className: "text-center"
                },
                {
                    data: "cantidad_robos",
                    className: "text-center"
                },
                {
                    data: "cantidad_corte_energia",
                    className: "text-center"
                },
                {
                    data: "cantidad_corte_internet",
                    className: "text-center"
                },
                {
                    data: "reconectores_abiertos",
                    className: "text-center"
                },
                {
                    defaultContent: `
                    <div class='text-center d-inline-block d-md-block'>
                        <div class='dropdown'>
                            <button class='btn btn-secondary btn-sm dropdown-toggle no-caret' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='material-icons'>more_vert</i>
                            </button>
                            <ul class='dropdown-menu'>
                                <li>
                                    <button class='bg-info btnInfo w-100 flex align-items-center'>
                                        <i class='material-icons'>info</i> Información
                                    </button>
                                </li>
                                <li>
                                    <button class='bg-primary btnEditar w-100'>
                                        <i class='material-icons'>edit</i> Editar
                                    </button>
                                </li>
                                <li>
                                    <button class='bg-danger btnBorrar w-100'>
                                        <i class='material-icons'>delete</i> Eliminar
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>`,
                    className: "text-center"
                }
            ],
            drawCallback: function (settings) {
                let api = this.api();
                let rows = api.rows({ page: 'current' }).nodes();
                let last = null;

                api.column(groupColumn, { page: 'current' })
                    .data()
                    .each(function (group, i) {
                        const groupFormated = moment(group).format('DD/MM/YYYY HH:mm');
                        if (moment(last).format('DD/MM/YYYY HH:mm') !== moment(group).format('DD/MM/YYYY HH:mm')) {
                            $(rows)
                                .eq(i)
                                .before(
                                    `<tr class="group">
                                        <td colspan="14" class="text-start groupedDate align-middle bg-secondary bg-gradient">
                                            FECHA: <span class="fecha fw-bold px-2">${moment(group).format('DD/MM/YYYY')}</span>
                                            HORA: <span class="hora fw-bold px-2">${moment(group).format('HH:mm')}</span>
                                        </td>
                                        <td colspan="1" class="bg-secondary bg-gradient">
                                            <button class="btnPdf btn btn-success btn-sm d-flex gap-1 align-items-center text-nowrap">
                                                <i class="material-icons">picture_as_pdf</i>Exportar a PDF
                                            </button>
                                        </td>
                                    </tr>`
                                );

                            last = group;

                        }
                    });
            },
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            },
            order: [1, 'desc'],
            language: {
                url: "./assets/json/espanol.json"
            }
        });

        $('#tabla tbody').on('click', '.btnPdf', function () {

            let groupRow = $(this).closest('tr.group');
            let groupDate = groupRow.find('td.groupedDate span.fecha').text().trim();
            let groupHour = groupRow.find('td.groupedDate span.hora').text().trim();

            let allRows = tablaReporte.rows({ page: 'current' }).nodes();

            let groupRows = [];
            $(allRows).each(function () {
                let row = $(this);
                
                if (row.hasClass('group')) {
                    return;
                }

                let rowDate = row.find('td:eq(2)').text().trim();
                let rowHour = row.find('td:eq(3)').text() === 'Sin Hora' ? '00:00' : row.find('td:eq(3)').text().trim();

                const fullDate = rowDate + ' ' + rowHour;

                const groupFullDate = groupDate + ' ' + groupHour;

                if (fullDate === groupFullDate) {
                    groupRows.push(tablaReporte.row(row).data());
                }
            });

            window.open("reportePeriodicoPDF.php?fecha=" + moment(groupRows[0].fecha).format('YYYY-MM-DD') + "&hora=" + moment(groupRows[0].fecha).format('HH:mm'), "_blank");
        });
    });
</script>

<style>
    .no-caret::after {
        display: none !important;
    }

    .btnInfo, .btnBorrar, .btnEditar, .btnPdf {
        border: none;
        outline: none;
        display: flex;
        gap: 8px;
        justify-items: start;
        align-items: center;
        height: 56px;
    }

    .btnInfo {
        color: black;
    }
</style>
<!-- end::Script -->

</body>

</html>