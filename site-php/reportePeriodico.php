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
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="dropdown col-6 col-md-8 d-flex align-items-center gap-4">
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
                    <button class='btn btn-success p-2'
                        id="btnExcel"
                        title="Exportar a Excel">
                        <svg class='bi bi-file-earmark-excel-fill'
                            height='24' width='24'
                            xmlns='http://www.w3.org/2000/svg'
                            viewBox='0 0 26 26'
                            xml:space='preserve'>
                            <path style='fill:#fff'
                                d='M25 3h-9v3h3v2h-3v2h3v2h-3v2h3v2h-3v2h3v2h-3v3h9l1-1V4l-1-1zm-1 17h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4V6h4v2zM0 3v20l15 3V0L0 3zm9 15-1-3v-1l-1 1-1 3H3l3-5-3-5h3l1 3 1 1v-1l2-3h2l-3 5 3 5H9z' />
                        </svg>
                    </button>
                </div>
                <label class="card-title col-md-4 col-6 p-0">Cliente:
                    <select class="form-select d-flex" name="cliente" id="cliente">
                        <option value="" selected>Ver Todos</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
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
    //Editar Reporte
    $('#tabla tbody').on('click', '.btnEditar', function() {
        var $data = tablaReporte.row($(this).parents('tr')).data();
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
        $('#fecha').val($data.fecha);
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
                fecha: $.trim($('#fecha').val()),
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
                        var row = tablaReporte.row($('[data-id="' + data.reporte.id + '"]'));
                        row.data({
                            id: data.reporte.id,
                            fecha: data.reporte.fecha,
                            id_operador: data.reporte.id_operador,
                            id_planta: data.reporte.id_planta,
                            camaras: data.reporte.camaras,
                            camaras_online: data.reporte.camaras_online,
                            canal: data.reporte.canal,
                            observacion: data.reporte.observacion,
                            visualizacion: '%' + Math.round(data.reporte.camaras_online / data.reporte.camaras * 100)
                        }).draw();
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

    $('#btnExcel').click(function() {
        var data = tablaReporte.rows().data().toArray();
        var exportData = data.map(function(rowData) {
            return {
                "ID": rowData.id,
                "Cliente": clientesMap[rowData.id_cliente] || 'Desconocido',
                "Planta": plantasMap[rowData.id_planta] || 'Desconocido',
                "Operador": operadoresMap[rowData.id_operador] || 'Desconocido',
                "Fecha Registro": rowData.fecha ? moment(rowData.fecha).format('DD/MM/YYYY') : 'Sin Fecha',
                "N° de Cámaras": rowData.camaras,
                "N° de Cámaras en Línea": rowData.camaras_online,
                "Porcentaje de Visualización":Math.round((rowData.camaras_online / rowData.camaras) * 100) + '%',
                "Observaciones": rowData.observacion,
                "Estado": renderEstado(rowData.canal)
            };
        });

        var worksheet = XLSX.utils.json_to_sheet(exportData);

        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'ReportePeriodico');

        XLSX.writeFile(workbook, 'ReportePeriodico.xlsx');
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
        tablaReporte.ajax.reload();
    });

    $(document).ready(function() {
        tablaReporte = $('#tabla').DataTable({
            responsive: true,
            "ajax": {
                "url": "./ajax_handler/reportes.php",
                "type": 'POST',
                "data": function(d) {
                    let data = {
                        action: 'get_reportes'
                    };
                    data.cliente = $('#cliente').val();
                    return data;
                },
                "dataSrc": ""
            },
            "columns": [{
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
                    "render": renderEstado,
                    "createdCell": function(td) {
                        $(td).addClass('text-start text-capitalize');
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
                {
                    "defaultContent": "<div class='text-center d-inline-block d-md-block'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"
                }
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