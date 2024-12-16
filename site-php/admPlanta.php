<?php
include("./includes/Database.class.php");

require_once('./includes/Plantas.class.php');
require_once('./includes/Ciudades.class.php');
require_once('./includes/Comisarias.class.php');
require_once('./includes/TipoPlanta.class.php');
require_once('./includes/Comunas.class.php');
require_once('./includes/Clientes.class.php');

$ciudades = Ciudades::get_all_ciudades();
$comunas = Comunas::get_all_comunas_without_id();
$comisarias = Comisarias::get_all_comisarias();
$tiposPlanta = TipoPlanta::get_all_tipo_planta();
$clientes = Clientes::get_all_clients();

?>

<div class="app-content"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="card mb-4">
            <div class="card-header p-3 d-flex justify-content-between align-items-center">
                <button class="btn btn-primary d-flex alignt-items-center jusitfy-content-center gap-2 fs-5" id="addPlanta">Agregar Planta<i class="material-icons" style="height: 20px; width:20px;">add</i></button>
            </div> <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover w-100" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-start">
                                ID
                            </th>
                            <th>
                                Cliente
                            </th>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Comuna
                            </th>
                            <th>
                                Comisaria
                            </th>
                            <th>
                                Tipo de Planta
                            </th>
                            <th class="text-start">
                                Grupo
                            </th>
                            <th>
                                Ubicación
                            </th>
                            <th class="text-center">
                                Estado
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
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Planta</h5>
                        <button type="button" class="btn-close border-0 rounded-2" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formPlantas" name="formPlantas">
                        <div class="modal-body">
                            <div id="formPagina1">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Nombre:
                                                <input type="text" class="form-control" id="nombre" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Cliente:
                                                <select class="form-select" name="id_clientes" id="id_clientes" required>
                                                    <?php foreach ($clientes as $cliente) : ?>
                                                        <option value="<?php echo $cliente['id'] ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Dirección:
                                                <input type="text" class="form-control" id="direccion" required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Ciudad:
                                                <select class="form-select" name="id_ciudad" id="id_ciudad" required>
                                                    <option value="">Seleccione</option>
                                                    <?php foreach ($ciudades as $ciudad) : ?>
                                                        <option value="<?php echo $ciudad['id'] ?>"><?php echo htmlspecialchars($ciudad['nombre']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Comuna:
                                                <select class="form-select" name="id_comuna" id="id_comuna" required disabled>
                                                    <option value="">Seleccione una Ciudad</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Comisaria:
                                                <select class="form-select" name="id_comisaria" id="id_comisaria" required>
                                                    <?php foreach ($comisarias as $comisaria) : ?>
                                                        <option value="<?php echo $comisaria['id'] ?>"><?php echo htmlspecialchars($comisaria['nombre']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Tipo de Planta:
                                                <select class="form-select" name="id_tipoPlanta" id="id_tipoPlanta" required>
                                                    <?php foreach ($tiposPlanta as $tipoPlanta) : ?>
                                                        <option value="<?php echo $tipoPlanta['id'] ?>"><?php echo htmlspecialchars($tipoPlanta['nombre']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Grupo:
                                                <input class="form-control" type="text" id="grupo" name="grupo" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Email Encargado:
                                                <input class="form-control" type="email" id="emailEncargado" name="emailEncargado" required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Nombre Encargado:
                                                <input class="form-control" type="text" id="nombreEncargado" name="nombreEncargado" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Telefono Encargado:
                                                <input class="form-control" type="tel" id="telEncargado" name="telEncargado" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Estado:
                                                <select class="form-select" name="estado" id="estado" required>
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Mapa:
                                                <input class="form-control" type="text" id="mapa" name="mapa" required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div hidden id="formPagina2">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Marca NVR:
                                                <input class="form-control" type="text" id="marcaDispositivos" name="marcaDispositivos"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Modelos NVR:
                                                <input class="form-control" type="text" id="modelosDispositivos" name="modelosDispositivos"></input>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Cantidad de Cámaras:
                                                <input class="form-control" type="number" id="cantidadCamaras" name="cantidadCamaras" disabled></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Tipo Modelo de Cámaras:
                                                <input class="form-control" type="text" id="modeloCamaras" name="modeloCamaras"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Codificación de Cámaras:
                                                <input class="form-control" type="text" id="codificacionCamaras" name="codificacionCamaras"></input>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Analíticas:
                                                <input class="form-control" type="text" id="analiticas" name="analiticas"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Sensores:
                                                <input class="form-control" type="text" id="sensores" name="sensores"></input>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Tamaño Grabación:
                                                <input class="form-control" type="text" id="tamanoGrabacion" name="tamanoGrabacion"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Dias Grabación:
                                                <input class="form-control" type="number" id="diasGrabacion" name="diasGrabacion"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Alarma Voceo:
                                                <input class="form-control" type="text" id="alarmaVoceo" name="alarmaVoceo"></input>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Sirenas:
                                                <input class="form-control" type="text" id="sirenas" name="sirenas"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Internet:
                                                <input class="form-control" type="text" id="internet" name="internet"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Proveedor Internet:
                                                <input class="form-control" type="text" id="proveedorInternet" name="proveedorInternet"></input>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">P2P:
                                                <input class="form-control" type="text" id="p2p" name="p2p"></input>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label class="col-form-label w-100">Autoregistro:
                                                <input class="form-control" type="text" id="autoregistro" name="autoregistro"></input>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary active" id="btnForm1">1</button>
                                <button type="button" class="btn btn-outline-primary" id="btnForm2" title="Información adicional">2</button>
                            </div>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true" role="dialog">
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
        <div class="modal fade" id="additionalModal" tabindex="-1" aria-labelledby="additionalModal" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-2" id="row1">
                            </div>
                            <div class="row mb-2" id="row2">
                            </div>
                            <div class="row mb-2" id="row3">
                            </div>
                            <div class="row mb-2" id="row4">
                            </div>
                            <div class="row mb-2" id="row5">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary" id="btn1">1</button>
                            <button type="button" class="btn btn-outline-primary" id="btn2">2</button>
                        </div>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>'
                    </div>
                </div>
            </div>
        </div>
        <!-- end::Modal -->
    </div> <!--end::Container-->
</div> <!--end::App Content-->
<!-- begin::Script -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    //ver las comunas según la ciudad ingresada en el formulario
    $(document).ready(function() {
        $('#btnForm2').click(function() {
            $('#btnForm1').removeClass('active');
            $('#btnForm2').addClass('active');
            $('#formPagina1').prop('hidden', true);
            $('#formPagina2').prop('hidden', false);
        });
        $('#btnForm1').click(function() {
            $('#btnForm2').removeClass('active');
            $('#btnForm1').addClass('active');
            $('#formPagina2').prop('hidden', true);
            $('#formPagina1').prop('hidden', false);
        });

        $('#id_ciudad').change(function() {
            var id_ciudad = $(this).val();

            if (id_ciudad !== '') {
                $('#id_comuna').prop('disabled', false).focus();
            } else {
                $('#id_comuna').prop('disabled', true);
            }

            $.ajax({
                type: 'POST',
                url: './ajax_handler/plantas.php',
                data: {
                    id_ciudad: id_ciudad,
                    action: 'get_comuna'
                },
                dataType: 'json',
                success: function(data) {
                    var $comunaSelect = $('#id_comuna');
                    $comunaSelect.empty();
                    $comunaSelect.append('<option value="">Seleccione</option>');
                    $.each(data, function(index, comuna) {
                        $comunaSelect.append('<option value="' + comuna.id + '">' + comuna.nombre + '</option>');
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
    //Crear Planta
    $("#addPlanta").click(function() {
        $('#formPlantas').attr('data-action', 'create_planta');
        $('#formPlantas')[0].reset();
        $('#modalCRUD .modal-title').text('Agregar Planta');
        $('#modalCRUD').modal('show');
    });

    //Editar Planta
    $('#tabla tbody').on('click', '.btnEditar', function() {
        $('#modalCRUD .modal-title').text('Editar Planta');
        const $row = $(this).closest('tr');
        const data = tablaPlantas.row($row).data();
        $.ajax({
            type: 'POST',
            url: './ajax_handler/plantas.php',
            data: {
                action: 'get_plantas_by_id',
                id: data.id
            },
            success: function(response) {
                $('#formPlantas').attr('data-action', 'edit_planta');
                $('#formPlantas').attr('data-id', response[0].id);
                $('#nombre').val(response[0].nombre);
                $('#id_clientes').val(response[0].id_clientes);
                $('#direccion').val(response[0].ubicacion);
                $('#id_ciudad').val(response[0].id_ciudad);
                $('#id_comuna').append('<?php foreach ($comunas as $comuna): ?>')
                $('#id_comuna').append('<?php echo '<option value="' . $comuna['id'] . '">' . $comuna['nombre'] . '</option>'; ?>')
                $('#id_comuna').append('<?php endforeach; ?>')
                $('#id_comuna').val(response[0].id_comuna);
                $('#id_comisaria').val(response[0].id_comisarias);
                $('#id_tipoPlanta').val(response[0].id_tipo_planta);
                $('#grupo').val(response[0].grupo);
                $('#nombreEncargado').val(response[0].encargado_contacto);
                $('#telEncargado').val(response[0].encargado_telefono);
                $('#emailEncargado').val(response[0].encargado_email);
                $('#mapa').val(response[0].mapa);
                $('#estado').val(response[0].estado);
                $('#marcaDispositivos').val(response[0].marca_dispositivos ?? null);
                $('#modelosDispositivos').val(response[0].modelos_dispositivos);
                $('#cantidadCamaras').val(response[0].camaras);
                $('#modeloCamaras').val(response[0].tipo_modelo_camaras);
                $('#codificacionCamaras').val(response[0].codificacion_camaras);
                $('#analiticas').val(response[0].analiticas);
                $('#sensores').val(response[0].sensores);
                $('#tamanoGrabacion').val(response[0].tamano_grabacion);
                $('#diasGrabacion').val(response[0].dias_grabacion);
                $('#alarmaVoceo').val(response[0].alarma_voceo);
                $('#sirenas').val(response[0].sirenas);
                $('#internet').val(response[0].internet);
                $('#proveedorInternet').val(response[0].proveedor_internet);
                $('#p2p').val(response[0].p2p);
                $('#autoregistro').val(response[0].autoregistro);


                $('#modalCRUD').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        })
    });

    $('#tabla tbody').on('click', '.btnInfo', function() {
        let modal = $('#additionalModal .modal-dialog .modal-content');
        let $row = $(this).closest('tr');
        let data = tablaPlantas.row($row).data();

        $.ajax({
            type: 'POST',
            url: './ajax_handler/plantas.php',
            data: {
                action: 'get_plantas_by_id',
                id: data.id
            },
            success: function(response) {
                $('#additionalModal').modal('show');
                modal.response = response;
                modal.find('.modal-header').append('<h5 class="modal-title">Información Planta ' + response[0].nombre + '</h5>');
                pagina1(modal);

                $('#btn1').prop('aria-current', "page").addClass('active');
                $('#btn2').removeClass('active');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en AJAX:', textStatus, errorThrown);
            }
        });

        $('#btn2').click(function() {
            modal.find('.modal-body p').remove();
            pagina2(modal);
            $('#btn2').prop('aria-current', "page").addClass('active');
            $('#btn1').removeClass('active');
        });

        $('#btn1').click(function() {
            modal.find('.modal-body p').remove();
            pagina1(modal);
            $('#btn1').prop('aria-current', "page").addClass('active');
            $('#btn2').removeClass('active');
        });

        function pagina1(modal) {
            let response = modal.response;
            modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">ID: </span><span class="badge bg-primary">' + response[0].id + '</span></p>');
            modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Cliente: </span>' + clientesMap[response[0].id_clientes] + '</p>');
            modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Tipo de Planta: </span>' + tipoPlantaMap[response[0].id_tipo_planta] + '</p>');
            modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Ciudad: </span>' + response[0].nombre_ciudad + '</p>');
            modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Comuna: </span>' + comunasMap[response[0].id_comuna] + '</p>');
            modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Comisaria: </span>' + comisariasMap[response[0].id_comisarias] + '</p>');
            modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Grupo: </span>' + response[0].grupo + '</p>');
            modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Dirección: </span>' + response[0].ubicacion + '</p>');
            modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Mapa: </span>' + response[0].mapa + '</p>');
            modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Encargado: </span>' + response[0].encargado_contacto + '</p>');
            modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Teléfono: </span>' + response[0].encargado_telefono + '</p>');
            modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Email: </span>' + response[0].encargado_email + '</p>');
        };

        function pagina2(modal) {
            let response = modal.response;
            modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Marca NVR: </span>'+ response[0].marca_dispositivos +'</p>');
            modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Modelos NVR: </span>'+ response[0].modelos_dispositivos +'</p>');
            modal.find('#row1').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Cantidad Cámaras: </span>'+ response[0].camaras +'</p>');
            modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Modelo Cámaras: </span>' + response[0].tipo_modelo_camaras + '</p>');
            modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Codificación Cámaras: </span>' + response[0].codificacion_camaras + '</p>');
            modal.find('#row2').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Analíticas: </span>' + response[0].analiticas + '</p>');
            modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Sensores: </span>' + response[0].sensores + '</p>');
            modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Tamaño Grabación: </span>' + response[0].tamano_grabacion + '</p>');
            modal.find('#row3').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Dias Grabación: </span>' + response[0].dias_grabacion + '</p>');
            modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Alarma Voceo: </span>' + response[0].alarma_voceo + '</p>');
            modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Sirenas: </span>' + response[0].sirenas + '</p>');
            modal.find('#row4').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Proveedor Internet: </span>' + response[0].proveedor_internet + '</p>');
            modal.find('#row5').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">P2P: </span>' + response[0].p2p + '</p>');
            modal.find('#row5').append('<p class="card-text col-6 col-md-4"><span class="fw-bold">Autoregistro: </span>' + response[0].autoregistro + '</p>');
        };
    });

    //Formatear Modal
    $('#warningModal').on('hidden.bs.modal', function() {
        var modal = $('#warningModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
        modal.find('.modal-footer button').remove();
    });

    $('#additionalModal').on('hidden.bs.modal', function() {
        var modal = $('#additionalModal .modal-dialog .modal-content');
        modal.find('.modal-header h5').remove();
        modal.find('.modal-body p').remove();
    });

    //Eliminar Planta
    $('#tabla tbody').on('click', '.btnBorrar', function() {
        var $row = $(this).closest('tr');
        var data = tablaPlantas.row($row).data();
        var plantaId = data.id;

        var modal = $('#warningModal .modal-dialog .modal-content');

        modal.find('.modal-header').append('<h5 class="modal-title" id="warningModalLabel">Atención!</h5>');
        modal.find('.modal-body').append('<p>¿Seguro que deseas eliminar este registro? Esta acción no se puede revertir.</p>');
        modal.find('.modal-body').append('<p>ID: ' + data.id + '</p>');
        modal.find('.modal-body').append('<p>Cliente: ' + clientesMap[data.id_clientes] + '</p>');
        modal.find('.modal-body').append('<p>Nombre: ' + data.nombre + '</p>');
        modal.find('.modal-body').append('<p>Comuna: ' + comunasMap[data.id_comuna] + '</p>');
        modal.find('.modal-body').append('<p>Comisaria: ' + comisariasMap[data.id_comisarias] + '</p>');
        modal.find('.modal-body').append('<p>Tipo de Planta: ' + tipoPlantaMap[data.id_tipo_planta] + '</p>');
        modal.find('.modal-body').append('<p>Grupo: ' + data.grupo + '</p>');
        modal.find('.modal-body').append('<p>Ubicación: ' + data.ubicacion + '</p>');
        modal.find('.modal-body').append('<p>Estado: ' + (data.estado ? 'Activo' : 'Inactivo') + '</p>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        modal.find('.modal-footer').append('<button type="button" class="btn btn-danger btnBorrar" data-bs-dismiss="modal">Eliminar</button>');
        $('#warningModal').modal('show');
        $('#warningModal').on('click', '.btnBorrar', function() {
            $.ajax({
                type: "POST",
                url: "./ajax_handler/plantas.php",
                data: {
                    action: 'delete_planta',
                    id: plantaId
                },
                datatype: "json",
                encode: true,
                success: function(response) {
                    if (response.status) {
                        // Remover la fila de la tabla
                        tablaPlantas.row($row).remove().draw();
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

    //ver clientes en tabla
    var clientes = <?php echo json_encode($clientes); ?>;
    var clientesMap = {};

    clientes.forEach(function(cliente) {
        clientesMap[cliente.id] = cliente.nombre;
    });

    //ver comunas en tabla
    var comunas = <?php echo json_encode($comunas); ?>;
    var comunasMap = {};

    comunas.forEach(function(comuna) {
        comunasMap[comuna.id] = comuna.nombre;
    });

    //ver comisarias en tabla
    var comisarias = <?php echo json_encode($comisarias); ?>;
    var comisariasMap = {};

    comisarias.forEach(function(comisaria) {
        comisariasMap[comisaria.id] = comisaria.nombre;
    });

    //ver tipos de planta en tabla
    var tipoPlanta = <?php echo json_encode($tiposPlanta); ?>;
    var tipoPlantaMap = {};

    tipoPlanta.forEach(function(tp) {
        tipoPlantaMap[tp.id] = tp.nombre;
    });

    $(document).ready(function() {
        tablaPlantas = $('#tabla').DataTable({
            responsive: true,
            "ajax": {
                "url": "./ajax_handler/plantas.php",
                "type": 'POST',
                "data": {
                    action: 'get_plantas_short_data'
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id",
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "id_clientes",
                    "render": function(data) {
                        return clientesMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "nombre",
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "id_comuna",
                    "render": function(data) {
                        return comunasMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "id_comisarias",
                    "render": function(data) {
                        return comisariasMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "id_tipo_planta",
                    "render": function(data) {
                        return tipoPlantaMap[data] || 'Desconocido';
                    },
                    "createdCell": function(td) {
                        $(td).addClass('text-capitalize');
                    }
                },
                {
                    "data": "grupo",
                    "createdCell": function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-start');
                    }
                },
                {
                    "data": "ubicacion"
                },
                {
                    "data": "estado",
                    "render": function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        let url = '<?php echo $base_url ?>/formularios.php?form=nvr&planta=' + row.id + '&token=<?php echo $token; ?>'
                        return '<div class="text-center d-inline-block d-md-block"><div class="btn-group"><a href="' + url + '" class="btn btn-warning btn-sm btnNVR" title="Ir a NVR"><i class="material-icons">scanner</i></a><button class="btn btn-info btn-sm btnInfo" title="Información adicional"><i class="material-icons">info</i></button><button class="btn btn-primary btn-sm btnEditar" title="Editar"><i class="material-icons">edit</i></button><button class="btn btn-danger btn-sm btnBorrar" title="Eliminar"><i class="material-icons">delete</i></button></div></div>'
                    }
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
    // fomrulario Subir/Editar usuarios

    $("#formPlantas").submit(function(e) {
        e.preventDefault();

        var action = $(this).attr('data-action');
        var id = $(this).attr('data-id') || null;

        var formData = {
            action: action,
            id: id,
            id_comuna: $.trim($("#id_comuna").val()),
            id_comisarias: $.trim($("#id_comisaria").val()),
            id_tipo_planta: $.trim($("#id_tipoPlanta").val()),
            nombre: $.trim($("#nombre").val()),
            id_clientes: $.trim($("#id_clientes").val()),
            grupo: $.trim($("#grupo").val()),
            ubicacion: $.trim($("#direccion").val()),
            encargado_contacto: $.trim($("#nombreEncargado").val()),
            encargado_email: $.trim($("#emailEncargado").val()),
            encargado_telefono: $.trim($("#telEncargado").val()),
            mapa: $.trim($("#mapa").val()),
            estado: $.trim($("#estado").val()),
            marcaDispositivos: $.trim($("#marcaDispositivos").val()),
            modelosDispositivos: $.trim($("#modelosDispositivos").val()),
            cantidadCamaras: $.trim($("#cantidadCamaras").val()),
            modeloCamaras: $.trim($("#modeloCamaras").val()),
            codificacionCamaras: $.trim($("#codificacionCamaras").val()),
            analiticas: $.trim($("#analiticas").val()),
            sensores: $.trim($("#sensores").val()),
            tamanoGrabacion: $.trim($("#tamanoGrabacion").val()),
            diasGrabacion: $.trim($("#diasGrabacion").val()),
            alarmaVoceo: $.trim($("#alarmaVoceo").val()),
            sirenas: $.trim($("#sirenas").val()),
            internet: $.trim($("#internet").val()),
            proveedorInternet: $.trim($("#proveedorInternet").val()),
            p2p: $.trim($("#p2p").val()),
            autoregistro: $.trim($("#autoregistro").val()),
        };
        $.ajax({
            type: "POST",
            url: "./ajax_handler/plantas.php",
            data: formData,
            datatype: "json",
            encode: true,
            success: function(data) {
                if (data.status) {
                    if (action === 'create_planta') {
                        var newRow = tablaPlantas.row.add({
                            "id": data.planta.id,
                            "nombre": data.planta.nombre,
                            "id_clientes": data.planta.id_clientes,
                            "id_comuna": data.planta.id_comuna,
                            "id_comisarias": data.planta.id_comisarias,
                            "id_tipo_planta": data.planta.id_tipo_planta,
                            "grupo": data.planta.grupo,
                            "ubicacion": data.planta.ubicacion,
                            "estado": data.planta.estado,

                            "marcaDispositivos": data.planta.marca_dispositivos,
                            "modelosDispositivos": data.planta.modelos_dispositivos,
                            "cantidadCamaras": data.planta.cantidad_camaras,
                            "modeloCamaras": data.planta.tipo_modelo_camaras,
                            "codificacionCamaras": data.planta.codificacion_camaras,

                            "analiticas": data.planta.analiticas,
                            "sensores": data.planta.sensores,
                            "tamanoGrabacion": data.planta.tamano_grabacion,
                            "diasGrabacion": data.planta.dias_grabacion,
                            "alarmaVoceo": data.planta.alarma_voceo,
                            
                            "sirenas": data.planta.sirenas,           
                            "internet": data.planta.internet,
                            "proveedorInternet": data.planta.proveedor_internet,
                            "p2p": data.planta.p2p,
                            "autoregistro": data.planta.autoregistro

                        }).draw().node();
                        $(newRow).attr('data-id', data.planta.id);
                        $('#modalCRUD').modal('hide');

                    } else if (action === 'edit_planta') {
                        var row = tablaPlantas.row($('[data-id="' + id + '"]'));
                        row.data({
                            "id": id,
                            "nombre": data.planta.nombre,
                            "id_clientes": data.planta.id_clientes,
                            "id_comuna": data.planta.id_comuna,
                            "id_comisarias": data.planta.id_comisarias,
                            "id_tipo_planta": data.planta.id_tipo_planta,
                            "grupo": data.planta.grupo,
                            "ubicacion": data.planta.ubicacion,
                            "estado": data.planta.estado,

                            "marcaDispositivos": data.planta.marca_dispositivos,
                            "modelosDispositivos": data.planta.modelos_dispositivos,
                            "cantidadCamaras": data.planta.cantidad_camaras,
                            "modeloCamaras": data.planta.tipo_modelo_camaras,
                            "codificacionCamaras": data.planta.codificacion_camaras,

                            "analiticas": data.planta.analiticas,
                            "sensores": data.planta.sensores,
                            "tamanoGrabacion": data.planta.tamano_grabacion,
                            "diasGrabacion": data.planta.dias_grabacion,
                            "alarmaVoceo": data.planta.alarma_voceo,
                            
                            "sirenas": data.planta.sirenas,           
                            "internet": data.planta.internet,
                            "proveedorInternet": data.planta.proveedor_internet,
                            "p2p": data.planta.p2p,
                            "autoregistro": data.planta.autoregistro

                        }).draw();
                        $('#modalCRUD').modal('hide');

                    }

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