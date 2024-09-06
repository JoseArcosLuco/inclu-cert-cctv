<?php

error_reporting(E_ALL);
session_start();


if (isset($_SESSION["token"])) {
    $token = $_SESSION["token"];
} else {
    $token = "";
}
if (empty($token)) {
    echo "<meta http-equiv='refresh' content='2; url=index.php?cod=1' />";
}
require_once("./includes/Clientes.class.php");
require_once("./includes/Novedades.class.php");
require_once("./includes/CortesEnergia.class.php");
require_once("./includes/CortesInternet.class.php");
$clientes = Clientes::get_all_clients();
$novedadesDiarias = Novedades::get_all_novedades_top10(1);
$novedadesSemanales = Novedades::get_all_novedades_top10(2);
$cortesEnergiaActivos = CortesEnergia::get_all_corteEnergia_Activos();
$cortesInternetActivos = CortesInternet::get_all_corteInternet_Activos();
?>

<!DOCTYPE html>
<html lang="es-CL"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Inclusive CCTV</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="CCTV | Dashboard">
    <meta name="author" content="iarcos.cl">
    <meta name="description" content="Sitio php en desarrollo a medida para Inclusive GROUP CCTV">
    <meta name="keywords" content="Seguridad, Sistema de Seguridad y control de monitoreo camaras CCTV"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="icon" href="./assets/img/inclusive.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <?php include_once("header.php"); ?>
        <!--end::Header-->

        <!--begin::Sidebar-->
        <?php include_once("main-sidebar.php"); ?>
        <!--end::Sidebar-->

        <!--begin::App Main-->
        <main class="app-main">

            <!--begin::App Content Header-->
            <?php include_once("content-header.php"); ?>
            <!--end::App Content Header--> <!--begin::Row-->
            <div class="row ms-2 mb-3 justify-content-start">
                <div class="col-sm-2">
                    <p class="m-0">Cliente:</p>
                    <select class="form-select" name="id_cliente" id="id_cliente" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id'] ?>"><?php echo $cliente['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <p class="m-0">Planta:</p>
                    <select class="form-select" name="id_planta" id="id_planta" disabled required>
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <p class="m-0">Fecha inicio:</p>
                    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
                </div>
                <div class="col-sm-2">
                    <p class="m-0">Fecha fin:</p>
                    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required>
                </div>
            </div>


            <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row"> <!--begin::Col-->
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3 id="total_reportes">0</h3>
                                    <p>Nuevos Reportes</p>
                                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                                </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i> </a>
                            </div> <!--end::Small Box Widget 1-->
                        </div> <!--end::Col-->
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3 id="porcentaje" style="display: inline-block;">0</h3><sup class="fs-5">%</sup>
                                    <p>Operatividad de camaras</p>
                                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                                </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i> </a>
                            </div> <!--end::Small Box Widget 2-->
                        </div> <!--end::Col-->
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3 id="countUsers">0</h3>
                                    <p>Usuarios Registrados</p>
                                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                                </svg> <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i> </a>
                            </div> <!--end::Small Box Widget 3-->
                        </div> <!--end::Col-->
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3 id="countPlantas">0</h3>
                                    <p>Puestos de vigilancia</p>
                                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                                </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i> </a>
                            </div> <!--end::Small Box Widget 4-->
                        </div> <!--end::Col-->
                    </div> <!--end::Row--> <!--begin::Row-->

                    <div class="row">
                        <div class="col-lg-6 connectedSortable">
                            <div class="card direct-chat direct-chat-primary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Novedades Semanales</h3>
                                    <div class="card-tools"> <span title="3 New Messages" class="badge text-bg-primary">
                                            3
                                        </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane"> <i class="bi bi-chat-text-fill"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages"> <!-- Message. Default to the start -->
                                        <div class="direct-chat-msg">
                                            <?php foreach ($novedadesSemanales as $novedadesSemanalesList): ?>
                                                <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-start">
                                                        <?php echo $novedadesSemanalesList['nombreusuario']; ?>&nbsp;<?php echo $novedadesSemanalesList['apellidousuario']; ?>
                                                    </span> <span class="direct-chat-timestamp float-end">
                                                        <?php echo $novedadesSemanalesList['fecha']; ?>
                                                    </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user9-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    Planta: <?php echo $novedadesSemanalesList['nombreplanta']; ?> - <?php echo $novedadesSemanalesList['observacion']; ?>
                                                </div> <!-- /.direct-chat-text -->
                                            <?php endforeach; ?>
                                        </div> <!-- /.direct-chat-msg --> <!-- Message to the end -->
                                    </div> <!-- /.direct-chat-messages--> <!-- Contacts are loaded here -->
                                    <div class="direct-chat-contacts">
                                        <ul class="contacts-list">
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user1-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Count Dracula
                                                            <small class="contacts-list-date float-end">
                                                                2/28/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            How have you been? I was...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                        </ul> <!-- /.contacts-list -->
                                    </div> <!-- /.direct-chat-pane -->
                                </div> <!-- /.card-body -->
                            </div>
                        </div>

                        <div class="col-lg-6 connectedSortable">
                            <div class="card direct-chat direct-chat-primary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Novedades Diarias</h3>
                                    <div class="card-tools"> <span title="3 New Messages" class="badge text-bg-primary">
                                            3
                                        </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane"> <i class="bi bi-chat-text-fill"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!-- Conversations are loaded here -->

                                    <div class="direct-chat-messages"> <!-- Message. Default to the start -->
                                        <div class="direct-chat-msg">
                                            <?php foreach ($novedadesDiarias as $novedadesDiariasList): ?>
                                                <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-start">
                                                        <?php echo $novedadesDiariasList['nombreusuario']; ?>&nbsp;<?php echo $novedadesDiariasList['apellidousuario']; ?>
                                                    </span> <span class="direct-chat-timestamp float-end">
                                                        <?php echo $novedadesDiariasList['fecha']; ?>
                                                    </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user9-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    Planta: <?php echo $novedadesDiariasList['nombreplanta']; ?> - <?php echo $novedadesDiariasList['observacion']; ?>
                                                </div> <!-- /.direct-chat-text -->
                                            <?php endforeach; ?>
                                        </div> <!-- /.direct-chat-msg --> <!-- Message to the end -->
                                    </div> <!-- /.direct-chat-messages--> <!-- Contacts are loaded here -->

                                    <div class="direct-chat-contacts">
                                        <ul class="contacts-list">
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user1-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Count Dracula
                                                            <small class="contacts-list-date float-end">
                                                                2/28/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            How have you been? I was...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                        </ul> <!-- /.contacts-list -->
                                    </div> <!-- /.direct-chat-pane -->
                                </div> <!-- /.card-body -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 connectedSortable">
                            <div class="card direct-chat direct-chat-primary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Cortes de Red Activos</h3>
                                    <div class="card-tools"> <span title="3 New Messages" class="badge text-bg-primary">
                                            0
                                        </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane"> <i class="bi bi-chat-text-fill"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages"> <!-- Message. Default to the start -->
                                        <div class="direct-chat-msg">
                                            <?php foreach ($cortesInternetActivos as $cortesInternetActivosList): ?>
                                                <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-start">
                                                        <?php echo $cortesInternetActivosList['nombreusuario']; ?>&nbsp;<?php echo $cortesInternetActivosList['apellidousuario']; ?>
                                                    </span> <span class="direct-chat-timestamp float-end">
                                                        <?php echo $cortesInternetActivosList['fecha']; ?>
                                                    </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user9-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    <i class="bi bi-power"></i> Planta: <?php echo $cortesInternetActivosList['nombreplanta']; ?> - <?php echo $cortesInternetActivosList['observacion']; ?>
                                                </div> <!-- /.direct-chat-text -->
                                            <?php endforeach; ?>
                                        </div> <!-- /.direct-chat-msg --> <!-- Message to the end -->
                                    </div> <!-- /.direct-chat-messages--> <!-- Contacts are loaded here -->

                                </div> <!-- /.card-body -->
                            </div>
                        </div>

                        <div class="col-lg-6 connectedSortable">
                            <div class="card direct-chat direct-chat-primary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Cortes de Enegia Activos</h3>
                                    <div class="card-tools"> <span title="3 New Messages" class="badge text-bg-primary">
                                            3
                                        </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane"> <i class="bi bi-chat-text-fill"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!-- Conversations are loaded here -->

                                    <div class="direct-chat-messages"> <!-- Message. Default to the start -->
                                        <div class="direct-chat-msg">
                                            <?php foreach ($cortesEnergiaActivos as $cortesEnergiaActivosList): ?>
                                                <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-start">
                                                        <?php echo $cortesEnergiaActivosList['nombreusuario']; ?>&nbsp;<?php echo $cortesEnergiaActivosList['apellidousuario']; ?>
                                                    </span> <span class="direct-chat-timestamp float-end">
                                                        <?php echo $cortesEnergiaActivosList['fecha']; ?>
                                                    </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user9-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    <i class="bi bi-power"></i> Planta: <?php echo $cortesEnergiaActivosList['nombreplanta']; ?> - <?php echo $cortesEnergiaActivosList['observacion']; ?>
                                                </div> <!-- /.direct-chat-text -->
                                            <?php endforeach; ?>
                                        </div> <!-- /.direct-chat-msg --> <!-- Message to the end -->
                                    </div> <!-- /.direct-chat-messages--> <!-- Contacts are loaded here -->

                                    <div class="direct-chat-contacts">
                                        <ul class="contacts-list">
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user1-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Count Dracula
                                                            <small class="contacts-list-date float-end">
                                                                2/28/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            How have you been? I was...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                        </ul> <!-- /.contacts-list -->
                                    </div> <!-- /.direct-chat-pane -->
                                </div> <!-- /.card-body -->
                            </div>
                        </div>
                    </div>

                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-6 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Operatividad por clientes</h3>
                                </div>
                                <div class="card-body">
                                    <div id="revenue-chart"></div>
                                </div>
                            </div> <!-- /.card --> <!-- DIRECT CHAT -->
                            <!-- /.direct-chat -->
                        </div>
                        <div class="col-lg-6 connectedSortable">
                            <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Sales Value</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-primary btn-sm" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> </div>
                                </div>
                                <div class="card-body">
                                    <div id="world-map" style="height: 220px"></div>
                                </div>
                                <div class="card-footer border-0"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <div id="sparkline-1" class="text-dark"></div>
                                            <div class="text-white">Visitors</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div id="sparkline-2" class="text-dark"></div>
                                            <div class="text-white">Online</div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <div id="sparkline-3" class="text-dark"></div>
                                            <div class="text-white">Sales</div>
                                        </div>
                                    </div> <!--end::Row-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title" id="grafico_torta">Gráfico de Torta</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="pie-chart"></div>
                                        </div> <!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-4 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Gráfico De Lineas</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="chart-line"></div>
                                        </div> <!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-4 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Gráfico De Barra</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="chart-bar"></div>
                                        </div> <!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 connectedSortable">
                            <div class="card direct-chat direct-chat-primary mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Direct Chat</h3>
                                    <div class="card-tools"> <span title="3 New Messages" class="badge text-bg-primary">
                                            3
                                        </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane"> <i class="bi bi-chat-text-fill"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!-- Conversations are loaded here -->
                                    <div class="direct-chat-messages"> <!-- Message. Default to the start -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-start">
                                                    Alexander Pierce
                                                </span> <span class="direct-chat-timestamp float-end">
                                                    23 Jan 2:00 pm
                                                </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user1-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                Is this template really for free? That's unbelievable!
                                            </div> <!-- /.direct-chat-text -->
                                        </div> <!-- /.direct-chat-msg --> <!-- Message to the end -->
                                        <div class="direct-chat-msg end">
                                            <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-end">
                                                    Sarah Bullock
                                                </span> <span class="direct-chat-timestamp float-start">
                                                    23 Jan 2:05 pm
                                                </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user3-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                You better believe it!
                                            </div> <!-- /.direct-chat-text -->
                                        </div> <!-- /.direct-chat-msg --> <!-- Message. Default to the start -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-start">
                                                    Alexander Pierce
                                                </span> <span class="direct-chat-timestamp float-end">
                                                    23 Jan 5:37 pm
                                                </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user1-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                Working with AdminLTE on a great new app! Wanna join?
                                            </div> <!-- /.direct-chat-text -->
                                        </div> <!-- /.direct-chat-msg --> <!-- Message to the end -->
                                        <div class="direct-chat-msg end">
                                            <div class="direct-chat-infos clearfix"> <span class="direct-chat-name float-end">
                                                    Sarah Bullock
                                                </span> <span class="direct-chat-timestamp float-start">
                                                    23 Jan 6:10 pm
                                                </span> </div> <!-- /.direct-chat-infos --> <img class="direct-chat-img" src="./assets/img/user3-128x128.jpg" alt="message user image"> <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">I would love to.</div> <!-- /.direct-chat-text -->
                                        </div> <!-- /.direct-chat-msg -->
                                    </div> <!-- /.direct-chat-messages--> <!-- Contacts are loaded here -->
                                    <div class="direct-chat-contacts">
                                        <ul class="contacts-list">
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user1-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Count Dracula
                                                            <small class="contacts-list-date float-end">
                                                                2/28/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            How have you been? I was...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user7-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Sarah Doe
                                                            <small class="contacts-list-date float-end">
                                                                2/23/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            I will be waiting for...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user3-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Nadia Jolie
                                                            <small class="contacts-list-date float-end">
                                                                2/20/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            I'll call you back at...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user5-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Nora S. Vans
                                                            <small class="contacts-list-date float-end">
                                                                2/10/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            Where is your new...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user6-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            John K.
                                                            <small class="contacts-list-date float-end">
                                                                1/27/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            Can I take a look at...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                            <li> <a href="#"> <img class="contacts-list-img" src="./assets/img/user8-128x128.jpg" alt="User Avatar">
                                                    <div class="contacts-list-info"> <span class="contacts-list-name">
                                                            Kenneth M.
                                                            <small class="contacts-list-date float-end">
                                                                1/4/2023
                                                            </small> </span> <span class="contacts-list-msg">
                                                            Never mind I found...
                                                        </span> </div> <!-- /.contacts-list-info -->
                                                </a> </li> <!-- End Contact Item -->
                                        </ul> <!-- /.contacts-list -->
                                    </div> <!-- /.direct-chat-pane -->
                                </div> <!-- /.card-body -->
                                <div class="card-footer">
                                    <form action="#" method="post">
                                        <div class="input-group"> <input type="text" name="message" placeholder="Type Message ..." class="form-control"> <span class="input-group-append"> <button type="button" class="btn btn-primary">
                                                    Send
                                                </button> </span> </div>
                                    </form>
                                </div> <!-- /.card-footer-->
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Atención!</h5>
                                </div>
                                <div class="modal-body col-12">
                                    <p class="bg-danger text-white text-center p-2 rounded mb-1">La fecha seleccionada no es válida</p>
                                    <p class="text-center p-2 m-0">Por favor, seleccione una fecha valida</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main-->

        <!--begin::Footer-->
        <?php include_once("footer.php"); ?>
        <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="./js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!-- OPTIONAL SCRIPTS --> <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script> <!-- sortablejs -->
    <script>
        const connectedSortables =
            document.querySelectorAll(".connectedSortable");
        connectedSortables.forEach((connectedSortable) => {
            let sortable = new Sortable(connectedSortable, {
                group: "shared",
                handle: ".card-header",
            });
        });

        const cardHeaders = document.querySelectorAll(
            ".connectedSortable .card-header",
        );
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = "move";
        });
    </script> <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script> <!-- ChartJS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script>
        let fechaActual = moment();
        let fechaInicio = fechaActual.startOf('month').format('YYYY-MM-DD');
        let fechaFin = fechaActual.endOf('month').format('YYYY-MM-DD');

        $('#fecha_inicio').val(fechaInicio);
        $('#fecha_fin').val(fechaFin);

        let diasEnElMes = moment().daysInMonth();
        let dia1 = 1;
        let dia2 = Math.floor(diasEnElMes / 5) + 1;
        let dia3 = Math.floor(diasEnElMes / 5) * 2 + 1;
        let dia4 = Math.floor(diasEnElMes / 5) * 3 + 1;
        let dia5 = Math.floor(diasEnElMes / 5) * 4 + 1;
        let dia6 = diasEnElMes;

        let fecha1 = fechaActual.date(dia1).format('YYYY-MM-DD');
        let fecha2 = fechaActual.date(dia2).format('YYYY-MM-DD');
        let fecha3 = fechaActual.date(dia3).format('YYYY-MM-DD');
        let fecha4 = fechaActual.date(dia4).format('YYYY-MM-DD');
        let fecha5 = fechaActual.date(dia5).format('YYYY-MM-DD');
        let fecha6 = fechaActual.date(dia6).format('YYYY-MM-DD');

        let fechasCategorias = [fecha1, fecha2, fecha3, fecha4, fecha5, fecha6];
        let tema = '';
        let color = '';

        const storedTheme = localStorage.getItem('theme');

        if (storedTheme === 'light') {
            tema = 'light';
            color = '#595959';
        } else {
            tema = 'dark';
            color = '#d7d7d7';
        }

        let clientes = [];
        let total = [];
        $.ajax({
            type: "POST",
            url: "./ajax_handler/dashboard.php",
            data: {
                action: 'updateChart'
            },
            success: function(data) {
                $('#grafico_torta').text('Plantas por Cliente');
                data.forEach(function(cliente) {
                    clientes.push(cliente.nombre)
                    total.push(cliente.total_plantas)
                });

                pie_chart.resetSeries();

                pie_chart.updateOptions({
                    labels: clientes,
                    series: total
                })
            },
            error: function(data) {
                console.log(data)
            }
        });

        const sales_chart_options = {
            series: [{
                    name: "Cliente 1",
                    data: [28, 48, 40, 19, 1, 27],
                },
                {
                    name: "Cliente 2",
                    data: [6, 5, 8, 8, 5, 5],
                },
                {
                    name: "Cliente 3",
                    data: [9, 2, 4, 6, 5, 4],
                },
                {
                    name: "Cliente 4",
                    data: [7, 6, 45, 3, 23, 6],
                },
                {
                    name: "Cliente 5",
                    data: [8, 48, 12, 3, 45, 9],
                },
                {
                    name: "Cliente 6",
                    data: [9, 7, 6, 48, 8, 9],
                },
            ],
            chart: {
                height: 305,
                type: "area",
                toolbar: {
                    show: true,
                },
            },
            legend: {
                show: true,
                position: 'bottom',
                labels: {
                    colors: ["#fff", "#222936"],
                },
                fontSize: '18px',
                offsetY: 27,
            },
            theme: {
                palette: 'palette4'
            },
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                labels: {
                    show: true,
                    style: {
                        colors: color,
                        fontSize: '14px'
                    }
                },
                type: "datetime",
                categories: fechasCategorias,
            },
            yaxis: {
                show: true,
                min: 0,
                max: 50,
                labels: {
                    show: true,
                    style: {
                        colors: color,
                        fontSize: '14px'
                    }
                },
            },
            tooltip: {
                theme: tema,
                x: {
                    format: "MMMM yyyy",
                },
                y: {
                    formatter: function(val) {
                        return val + " eventos"
                    }
                }
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector("#revenue-chart"),
            sales_chart_options,
        );
        sales_chart.render();

        //PIE CHART

        const pie_chart_options = {
            series: [43],
            chart: {
                type: "pie",
                height: 397,
                toolbar: {
                    show: true,
                }
            },
            labels: ['cliente'],
            dataLabels: {
                style: {
                    colors: ['#fff'],
                }
            },
            theme: {
                palette: 'palette4',
            },
            tooltip: {
                theme: tema
            },
            legend: {
                position: 'bottom',
                labels: {
                    colors: ["#fff", "#222936"],
                },
                fontSize: '18px',
                offsetY: 12,
            }
        };

        const pie_chart = new ApexCharts(
            document.querySelector("#pie-chart"),
            pie_chart_options,
        );
        pie_chart.render();

        //BAR CHART

        var seriesRobos = [3, 4, 2, 5, 6];
        var seriesInternet = [1, 2, 3, 4, 5];
        var seriesEnergia = [2, 1, 4, 3, 2];

        var optionsBar = {
            chart: {
                type: 'bar',
                stacked: true,
                height: 350
            },
            series: [{
                    name: 'Robos',
                    data: seriesRobos
                },
                {
                    name: 'Cortes Internet',
                    data: seriesInternet
                },
                {
                    name: 'Cortes Energía',
                    data: seriesEnergia
                }
            ],
            xaxis: {
                categories: fechasCategorias,
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Eventos',
                },
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px'
                    }
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    colors: ["#fff", "#222936"],
                    padding: 20,
                },
                fontSize: '18px',
                offsetY: 25,
            },
            tooltip: {
                theme: tema,
                y: {
                    formatter: function(val) {
                        return val + " eventos"
                    }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false
                }
            }
        };

        var chartBar = new ApexCharts(document.querySelector("#chart-bar"), optionsBar);
        chartBar.render();

        //LINE CHART

        var optionsLine = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [{
                    name: 'Robos',
                    data: seriesRobos
                },
                {
                    name: 'Cortes Internet',
                    data: seriesInternet
                },
                {
                    name: 'Cortes Energía',
                    data: seriesEnergia
                }
            ],
            xaxis: {
                categories: fechasCategorias,
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Eventos'
                },
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px'
                    }
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    colors: ['#fff', '#222936'],
                },
                fontSize: '18px',
                offsetY: 25,
            },
            tooltip: {
                theme: tema,
                y: {
                    formatter: function(val) {
                        return val + " eventos";
                    }
                }
            }
        };

        var chartLine = new ApexCharts(document.querySelector("#chart-line"), optionsLine);
        chartLine.render();
    </script> <!-- jsvectormap -->
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script> <!-- jsvectormap -->
    <script>
        $.ajax({
            type: "POST",
            url: "./ajax_handler/dashboard.php",
            data: {
                action: 'updateCardsWithoutCliente'
            },
            dataType: "json",
            success: function(data) {
                console.log(data)
                $('#countUsers').text(data.countUsers);
                $('#countPlantas').text(data.countPlantas);
                $('#total_reportes').text(data.countReportes);
                $('#porcentaje').text(data.porcentaje);
            },
            error: function(data) {
                console.log('Usuarios activos: ', data);
            }
        })

        $('#id_cliente').change(function() {
            let id = $(this).val();
            $('#id_planta').prop('disabled', false);

            $.ajax({
                type: "POST",
                url: "./ajax_handler/dashboard.php",
                data: {
                    action: 'updateChartClientes',
                    id: id
                },
                datatype: "json",
                success: function(data) {
                    console.log(data)
                    let reportes = [];
                    let plantas = [];
                    let contadorReportes = 0;
                    $('#id_planta').empty();
                    $('#id_planta').append('<option value="">Seleccionar</option>');

                    let plantasData = Array.isArray(data) ? data : Object.values(data).filter(item => typeof item === 'object');

                    plantasData.forEach(function(planta) {
                        $('#id_planta').append('<option value="' + planta.id + '">' + planta.nombre + '</option>');
                        plantas.push(planta.nombre)
                        reportes.push(planta.reportes)
                        contadorReportes += planta.contadorReporte
                    });

                    $('#grafico_torta').text('Reportes por Planta');

                    $('#total_reportes').text(contadorReportes);
                    $('#countPlantas').text(data.countPlantas);
                    $('#porcentaje').text(data.porcentaje);


                    pie_chart.updateOptions({
                        labels: plantas,
                        series: reportes
                    })
                },
                error: function(data) {
                    console.log(data);
                }
            })
        });

        $('#id_planta').on('change', function() {
            let id_planta = $('#id_planta').val();

            $.ajax({
                url: "./ajax_handler/dashboard.php",
                method: "POST",
                data: {
                    id_planta: id_planta,
                    action: 'updateChartWithoutFecha'
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    let robos = data[0].robos;
                    let internet = data[0].cortes_internet;
                    let energia = data[0].cortes_energia;
                    let newData = [robos, internet, energia];

                    pie_chart.updateOptions({
                        series: newData,
                        labels: ["Robos", "Cortes Internet", "Cortes Energía"]
                    });

                    sales_chart.updateOptions({
                        series: [{
                            name: ['Robos', 'Cortes Internet', 'Cortes Energía'],
                            data: newData
                        }]
                    });

                    if (data.countReportes == false) {
                        $('#total_reportes').text(0);
                    } else {
                        $('#total_reportes').text(data.countReportes);
                    };
                    if (data.porcentaje == null) {
                        $('#porcentaje').text(0);
                    } else {
                        $('#porcentaje').text(data.porcentaje);
                    };
                }
            })
        });

        $('#id_planta, #fecha_inicio, #fecha_fin').on('change', function() {
            let id_planta = $('#id_planta').val();
            let fecha_inicio = $('#fecha_inicio').val() + ' 00:00:00';
            let fecha_fin = $('#fecha_fin').val() + ' 23:59:59';

            let fechaInicioVal = moment($('#fecha_inicio').val());
            let fechaFinVal = moment($('#fecha_fin').val());

            if (fechaFinVal.isBefore(fechaInicioVal)) {
                $('#warningModal').modal('show');
                $('#fecha_inicio').val(fechaInicio);
                $('#fecha_fin').val(fechaFin);
            }

            $.ajax({
                url: "./ajax_handler/dashboard.php",
                method: "POST",
                data: {
                    id_planta: id_planta,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin,
                    action: 'updateChartWithFecha'
                },
                dataType: 'json',
                success: function(data) {
                    let fechasRobos = data[0].fechas_robos ? data[0].fechas_robos.split(',') : [];
                    let fechasCortesInternet = data[0].fechas_internet ? data[0].fechas_internet.split(',') : [];
                    let fechasCortesEnergia = data[0].fechas_energia ? data[0].fechas_energia.split(',') : [];

                    let contarPorFecha = function(fechas) {
                        let contador = {};
                        fechas.forEach(function(fecha) {
                            let fechaSimple = fecha.slice(0, 10);
                            if (contador[fechaSimple]) {
                                contador[fechaSimple]++;
                            } else {
                                contador[fechaSimple] = 1;
                            }
                        });
                        return contador;
                    };

                    let robosPorFecha = contarPorFecha(fechasRobos);
                    let internetPorFecha = contarPorFecha(fechasCortesInternet);
                    let energiaPorFecha = contarPorFecha(fechasCortesEnergia);

                    let fechasUnicas = [...new Set([...Object.keys(robosPorFecha), ...Object.keys(internetPorFecha), ...Object.keys(energiaPorFecha)])].sort();

                    let seriesRobos = fechasUnicas.map(fecha => robosPorFecha[fecha] || 0);
                    let seriesInternet = fechasUnicas.map(fecha => internetPorFecha[fecha] || 0);
                    let seriesEnergia = fechasUnicas.map(fecha => energiaPorFecha[fecha] || 0);

                    sales_chart.updateOptions({
                        series: [{
                                name: 'Robos',
                                data: seriesRobos
                            },
                            {
                                name: 'Cortes Internet',
                                data: seriesInternet
                            },
                            {
                                name: 'Cortes Energía',
                                data: seriesEnergia
                            }
                        ],
                        xaxis: {
                            categories: fechasUnicas
                        },
                        yaxis: {
                            title: {
                                text: 'Eventos'
                            },
                            min: 0,
                            max: Math.max(...seriesRobos, ...seriesInternet, ...seriesEnergia)
                        }
                    });

                    chartBar.updateOptions({
                        series: [{
                                name: 'Robos',
                                data: seriesRobos
                            },
                            {
                                name: 'Cortes Internet',
                                data: seriesInternet
                            },
                            {
                                name: 'Cortes Energía',
                                data: seriesEnergia
                            }
                        ],
                        xaxis: {
                            categories: fechasUnicas
                        }
                    });

                    chartLine.updateOptions({
                        series: [{
                                name: 'Robos',
                                data: seriesRobos
                            },
                            {
                                name: 'Cortes Internet',
                                data: seriesInternet
                            },
                            {
                                name: 'Cortes Energía',
                                data: seriesEnergia
                            }
                        ],
                        xaxis: {
                            categories: fechasUnicas
                        }
                    });

                    if (data.countReportes == false) {
                        $('#total_reportes').text(0);
                    } else {
                        $('#total_reportes').text(data.countReportes);
                    };
                    if (data.porcentaje == null) {
                        $('#porcentaje').text(0);
                    } else {
                        $('#porcentaje').text(data.porcentaje);
                    };
                }
            });
        });
    </script>
    <script>
        const visitorsData = {
            US: 398, // USA
            SA: 400, // Saudi Arabia
            CA: 1000, // Canada
            DE: 500, // Germany
            FR: 760, // France
            CN: 300, // China
            AU: 700, // Australia
            BR: 600, // Brazil
            IN: 800, // India
            GB: 320, // Great Britain
            RU: 3000, // Russia
        };

        // World map by jsVectorMap
        const map = new jsVectorMap({
            selector: "#world-map",
            map: "world",
        });

        // Sparkline charts
        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline1 = new ApexCharts(
            document.querySelector("#sparkline-1"),
            option_sparkline1,
        );
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline2 = new ApexCharts(
            document.querySelector("#sparkline-2"),
            option_sparkline2,
        );
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline3 = new ApexCharts(
            document.querySelector("#sparkline-3"),
            option_sparkline3,
        );
        sparkline3.render();
    </script>

    <script>
        (() => {
            "use strict";

            const storedTheme = localStorage.getItem("theme");

            const getPreferredTheme = () => {
                if (storedTheme) {
                    return storedTheme;
                }

                return window.matchMedia("(prefers-color-scheme: dark)").matches ?
                    "dark" :
                    "light";
            };

            const setTheme = function(theme) {
                if (
                    theme === "auto" &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches
                ) {
                    document.documentElement.setAttribute("data-bs-theme", "dark");
                } else {
                    document.documentElement.setAttribute("data-bs-theme", theme);
                }
            };

            setTheme(getPreferredTheme());

            const showActiveTheme = (theme, focus = false) => {
                const themeSwitcher = document.querySelector("#bd-theme");

                if (!themeSwitcher) {
                    return;
                }

                const themeSwitcherText = document.querySelector("#bd-theme-text");
                const activeThemeIcon = document.querySelector(".theme-icon-active i");
                const btnToActive = document.querySelector(
                    `[data-bs-theme-value="${theme}"]`
                );
                const svgOfActiveBtn = btnToActive.querySelector("i").getAttribute("class");

                for (const element of document.querySelectorAll("[data-bs-theme-value]")) {
                    element.classList.remove("active");
                    element.setAttribute("aria-pressed", "false");
                }

                btnToActive.classList.add("active");
                btnToActive.setAttribute("aria-pressed", "true");
                activeThemeIcon.setAttribute("class", svgOfActiveBtn);
                const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;
                themeSwitcher.setAttribute("aria-label", themeSwitcherLabel);

                if (focus) {
                    themeSwitcher.focus();
                }
            };

            window
                .matchMedia("(prefers-color-scheme: dark)")
                .addEventListener("change", () => {
                    if (storedTheme !== "light" || storedTheme !== "dark") {
                        setTheme(getPreferredTheme());
                    }
                });

            window.addEventListener("DOMContentLoaded", () => {
                showActiveTheme(getPreferredTheme());

                for (const toggle of document.querySelectorAll("[data-bs-theme-value]")) {
                    toggle.addEventListener("click", () => {
                        const theme = toggle.getAttribute("data-bs-theme-value");
                        localStorage.setItem("theme", theme);
                        setTheme(theme);
                        showActiveTheme(theme, true);
                    });
                }
            });
        })();
    </script>
    <!--end::Script-->
</body><!--end::Body-->

</html>