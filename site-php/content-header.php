<?php
$formAccion = isset($_GET["form"]) ? $_GET["form"] : '';
$tituloFormulario='';
switch( $formAccion ) {
    case "formularioreporte":
        $tituloFormulario = 'Formulario Reporte';
        break;
    case "informe":
        $tituloFormulario = 'Informe Reportes';
        break;
    case "usuarios":
        $tituloFormulario = 'Registro de Usuarios';
        break;
    case "tipoplanta":
        $tituloFormulario = 'Registro de Tipos Plantas';
        break;
    case "comisarias":
        $tituloFormulario = 'Registro de Comisarias';
        break;
    case "jornadas":
        $tituloFormulario = 'Registro de Jornadas';
        break;
    case "plantas":
        $tituloFormulario = 'Registro de Plantas';
        break;
    case "camaras":
        $tituloFormulario = 'Registro de Cámaras';
        break;
    case "perfil":
        $tituloFormulario = 'Registro de Perfiles';
        break;
    case "clientes":
        $tituloFormulario = 'Registro de Clientes';
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
                <h3 class="mb-0"><?php echo $tituloFormulario;?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="./dashboard.php?token=<?php echo $token ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php echo $tituloFormulario;?>
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>