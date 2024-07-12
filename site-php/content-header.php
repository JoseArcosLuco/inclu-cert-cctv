<?php
$formAccion = isset($_GET["form"]) ? $_GET["form"] : '';
switch( $formAccion ) {
    case "formularioreporte":
        $tituloFormulario = 'Formulario Reporte';
        break;
    case "informe":
        $tituloFormulario = 'Informe Reportes';
        break;
    case "":
        $tituloFormulario = 'Dashboard';
        break;
}
?>

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0"><?echo $tituloFormulario;?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?echo $tituloFormulario;?>
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>