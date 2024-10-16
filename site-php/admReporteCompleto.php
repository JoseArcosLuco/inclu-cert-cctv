<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Clientes.class.php');
require_once('./includes/Users.class.php');
require_once('./includes/Operadores.class.php');

$clientes = Clientes::get_all_clients();
$plantas = Plantas::get_all_plantas();
$usuarios = Users::get_all_users();
$operadores = Operadores::get_all_operadores_without_turno();
?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-start align-items-center gap-4">
                <a href="<?php echo $base_url ?>/formularios.php?form=reporteCompletoForm&token=<?php echo $token; ?>" class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5">Agregar Reporte<i class="material-icons" style="height: 20px; width:20px;">add</i></a>
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
                <label class="card-title col-2 p-0">Cliente:
                    <select class="form-select" name="cliente" id="cliente">
                        <option value="" selected>Ver Todos</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="card-title col-2 p-0">Planta:
                    <select class="form-select" name="planta" id="planta" disabled>
                        <option value="">Seleccione un Cliente</option>
                    </select>
                </label>
                <label class="card-title col-2 p-0">Fecha:
                    <input type="date" class="form-control" name="date" id="date">
                </label>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center" style="max-width: 70px;">
                                ID
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Autor
                            </th>
                            <th>
                                Planta
                            </th>
                            <th class="text-start">
                                Cámara
                            </th>
                            <th>
                                Observaciones
                            </th>
                            <th>
                                Estado
                            </th>
                            <th>
                                Operador
                            </th>
                            <th>
                                Visual
                            </th>
                            <th>
                                Analíticas
                            </th>
                            <th>
                                Recorrido
                            </th>
                            <th>
                                Evento
                            </th>
                            <th>
                                Grabaciones
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
        <!-- begin::Modal -->

        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Reporte</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form id="formReporte" name="formReporte">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">N° de Cámara:
                                            <input type="number" class="form-control" name="id_camara" id="id_camara" requiered disabled>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Planta:
                                                <select class="form-select" name="id_planta" id="id_planta" disabled requiere>
                                                    <option value="" selected>Seleccione</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Estado:
                                            <select class="form-select" name="estado" id="estado" requiered>
                                                <option value="1">En Línea</option>
                                                <option value="2">Intermitente</option>
                                                <option value="3">Sin Conexión</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Operador:
                                                <select class="form-select" name="id_operador" id="id_operador" requiered>
                                                    <option value="0" selected>Seleccione</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Visual:
                                            <select class="form-select" name="visual" id="visual" requiered>
                                                <option value="0" selected>Seleccione</option>
                                                <option value="1">Clara</option>
                                                <option value="2">Desenfocada</option>
                                                <option value="3">Obstruida</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Analíticas:
                                                <select class="form-select" name="analiticas" id="analiticas" requiered>
                                                    <option value="0" selected>Seleccione</option>
                                                    <option value="1">Activas</option>
                                                    <option value="2">Incativas</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Recorrido:
                                            <select class="form-select" name="recorrido" id="recorrido" requiered>
                                                <option value="0" selected>Seleccione</option>
                                                <option value="1">Activo</option>
                                                <option value="2">Inactivo</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Evento:
                                                <select class="form-select" name="evento" id="evento" requiered>
                                                    <option value="0" selected>Seleccione</option>
                                                    <option value="1">Activo</option>
                                                    <option value="2">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Observación:
                                            <textarea name="observacion" id="observacion" class="form-control" rows="2" requiered></textarea>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="col-form-label w-100">Grabaciones:
                                            <input type="number" name="grabaciones" id="grabaciones" class="form-control" requiered>
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
        <!-- end::Modal -->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $('#cliente').change(function() {
        let id = $(this).val();
        if (id !== '') {
            $('#planta').prop('disabled', false);
        } else {
            $('#planta').prop('disabled', true);
        }

        $.ajax({
            type: "POST",
            url: "./ajax_handler/reporteCompleto.php",
            data: {
                action: 'updateClienteSelect',
                id: id
            },
            dataType: "json",
            success: function(data) {
                $('#planta').empty();
                $('#planta').append('<option value="">Seleccione</option>');
                data.forEach(function(planta) {
                    $('#planta').append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                });

                tablaReporte.ajax.reload();
            },
            error: function(data) {
                console.log(data);
            }
        })
    });

    $('#planta').change(function() {
        tablaReporte.ajax.reload();
    });

    $('#date').change(function() {
        tablaReporte.ajax.reload();
    });

    var plantas = <?php echo json_encode($plantas); ?>;
    var plantasMap = {};

    plantas.forEach(function(planta) {
        plantasMap[planta.id] = planta.nombre;
    });

    var id_usuario = '<?php if (isset($id_usuario)) {
                            echo $id_usuario;
                        } ?>';

    var usuarios = <?php echo json_encode($usuarios); ?>;
    var usuariosMap = {};

    usuarios.forEach(function(usuario) {
        usuariosMap[usuario.id] = usuario.nombres + ' ' + usuario.apellidos;
    });

    var operadores = <?php echo json_encode($operadores); ?>;
    var operadoresMap = {};

    operadores.forEach(function(operador) {
        operadoresMap[operador.id] = operador.nombre;
    });

    function renderEstado(data) {
        const estados = {
            1: 'En Línea',
            2: 'Intermitente',
            3: 'Sin Conexión',
        };
        return estados[data] || 'Desconocido';
    }

    function renderVisual(data) {
        let visual = {
            1: 'Clara',
            2: 'Desenfocada',
            3: 'Obstruida',
        };

        return visual[data] || 'Desconocido';
    }

    function renderAnaliticas(data) {
        let analiticas = {
            1: 'Activas',
            2: 'Inactivas'
        };

        return analiticas[data] || 'Desconocido';
    }

    function renderRecorrido(data) {
        let recorrido = {
            1: 'Activo',
            2: 'Inactivo'
        };

        return recorrido[data] || 'Desconocido';
    }

    function renderEvento(data) {
        let evento = {
            1: 'Activo',
            2: 'Inactivo'
        };

        return evento[data] || 'Desconocido';
    }

    //Editar Reporte
    $('#tabla tbody').on('click', '.btnEditar', function() {
        const data = tablaReporte.row($(this).parents('tr')).data();
        console.log(data)
        $('#id_planta').prop('disabled', true);
        $('#formReporte').attr('data-action', 'edit_reporte');
        $('#formReporte').attr('data-id', data.id);
        $('#id_camara').val(data.id_camaras);

        $('#id_planta').empty();
        $('#id_planta').append('<?php foreach ($plantas as $planta): ?>');
        $('#id_planta').append('<option value="<?php echo $planta['id'] ?>" ><?php echo htmlspecialchars($planta['nombre']); ?></option>');
        $('#id_planta').append('<?php endforeach; ?>');
        $('#id_planta').val(data.id_planta);

        $('#id_operador').empty();
        $('#id_operador').append('<option value="0" selected>Seleccione</option>');
        $('#id_operador').append('<?php foreach ($operadores as $operador): ?>');
        $('#id_operador').append('<option value="<?php echo $operador['id'] ?>" ><?php echo htmlspecialchars($operador['nombre']); ?></option>');
        $('#id_operador').append('<?php endforeach; ?>');
        $('#id_operador').val(data.id_operador);

        $('#estado').val(data.estado);
        $('#evento').val(data.evento);
        $('#recorrido').val(data.recorrido);
        $('#visual').val(data.visual);
        $('#observacion').val(data.observacion);
        $('#grabaciones').val(data.grabaciones);
        $('#analiticas').val(data.analiticas);

        $('#modalCRUD .modal-title').text('Editar Reporte');

        $('#modalCRUD').modal('show');
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
        let $row = $(this).closest('tr');
        let data = tablaReporte.row($row).data();
        console.log(data)
        let reporteId = data.id;
        let modal = $('#warningModal .modal-dialog .modal-content');

        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p class="col-6">Planta: ' + plantasMap[data.id_planta] + '</p>');
        modal.find('.modal-body').append('<p>Autor Reporte: ' + usuariosMap[data.id_usuario] + '</p>');
        modal.find('.modal-body').append('<p>N° de Cámara: ' + data.id_camaras + '</p>');
        modal.find('.modal-body').append('<p>Estado: ' + renderEstado(data.estado) + '</p>');
        modal.find('.modal-body').append('<p>Operador Encargado: ' + usuariosMap[data.id_operador] + '</p>');
        modal.find('.modal-body').append('<p>Visual: ' + renderVisual(data.visual) + '</p>');
        modal.find('.modal-body').append('<p>Analíticas: ' + renderAnaliticas(data.analiticas) + '</p>');
        modal.find('.modal-body').append('<p>Recorrido: ' + renderRecorrido(data.recorrido) + '</p>');
        modal.find('.modal-body').append('<p>Evento: ' + renderEvento(data.evento) + '</p>');
        modal.find('.modal-body').append('<p>Grabaciones: ' + data.grabaciones + '</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function() {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/reporteCompleto.php",
                data: {
                    action: 'delete_reporte',
                    id: reporteId
                },
                dataType: "json",
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
                "Fecha": moment(rowData.fecha).format('DD-MM-YYYY'),
                "Autor": usuariosMap[rowData.id_usuario] || 'Desconocido',
                "Planta": plantasMap[rowData.id_planta] || 'Desconocido',
                "N° Cámara": rowData.id_camaras,
                "Observaciones": rowData.observacion,
                "Estado": renderEstado(rowData.estado),
                "Operador": usuariosMap[rowData.id_operador] || 'Desconocido',
                "Visual": renderVisual(rowData.visual),
                "Analíticas": renderAnaliticas(rowData.analiticas),
                "Recorrido": renderRecorrido(rowData.recorrido),
                "Evento": renderEvento(rowData.evento),
                "Grabaciones": rowData.grabaciones
            };
        });

        var worksheet = XLSX.utils.json_to_sheet(exportData);

        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'ReporteCompleto');

        XLSX.writeFile(workbook, 'ReporteCompleto.xlsx');
    });

    $(document).ready(function() {

        tablaReporte = $('#tabla').DataTable({
            responsive: true,
            "ajax": {
                "url": "./ajax_handler/reporteCompleto.php",
                "type": 'POST',
                "data": function(d) {
                    return {
                        action: 'get_reportes',
                        cliente: $('#cliente').val(),
                        planta: $('#planta').val(),
                        fecha: $('#date').val()
                    }
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
                    "render": function(data) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                {
                    "data": "id_usuario",
                    "render": function(data) {
                        return usuariosMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "id_planta",
                    "render": function(data) {
                        return plantasMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "camaraNombre",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "observacion",
                },
                {
                    "data": "estado",
                    "render": renderEstado
                },
                {
                    "data": "id_operador",
                    "render": function(data) {
                        return usuariosMap[data] || 'Desconocido';
                    }
                },
                {
                    "data": "visual",
                    "render": renderVisual
                },
                {
                    "data": "analiticas",
                    "render": renderAnaliticas
                },
                {
                    "data": "recorrido",
                    "render": renderRecorrido
                },
                {
                    "data": "evento",
                    "render": renderEvento
                },
                {
                    "data": "grabaciones",
                    "createdCell": function(td, cellData, rowData, row, col) {
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
<script>
    // fomrulario Subir/Editar cámaras

    $("#formReporte").submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id: id,
            analiticas: $.trim($("#analiticas").val()) === "0" ? null : $.trim($("#analiticas").val()),
            evento: $.trim($("#evento").val()) === "0" ? null : $.trim($("#evento").val()),
            grabaciones: $.trim($("#grabaciones").val()) === "0" ? null : $.trim($("#grabaciones").val()),
            observacion: $.trim($("#observacion").val()) === "0" ? null : $.trim($("#observacion").val()),
            recorrido: $.trim($("#recorrido").val()) === "0" ? null : $.trim($("#recorrido").val()),
            visual: $.trim($("#visual").val()) === "0" ? null : $.trim($("#visual").val()),
            id_operador: $.trim($("#id_operador").val()) === "0" ? null : $.trim($("#id_operador").val()),
            estado: $.trim($("#estado").val())
        };
        $.ajax({
            type: "POST",
            url: "./ajax_handler/reporteCompleto.php",
            data: formData,
            dataType: "json",
            encode: true,
            success: function(data) {
                console.log(data)

                if (data.status) {

                    tablaReporte.ajax.reload();

                    $('#modalCRUD').modal('hide');

                } else {
                    alert(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejar errores de AJAX
                console.log("Error en AJAX: " + textStatus, errorThrown);
                alert("Error en la solicitud: " + textStatus);
            }
        });
    });
</script>
<!-- end::Script -->

</body>

</html>