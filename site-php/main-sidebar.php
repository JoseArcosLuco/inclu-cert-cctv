<?php 
include("config.php");
if (isset($_SESSION["token"])) {
    $token =$_SESSION['token'];
}else{
    $token = '';
}

//limpiamos las variables
$menuActiveD = '';
$menuActiveFr = '';
$menuActiveI = '';
$menuActiveU = '';
$menuActiveTp = '';
$menuActiveC = '';
$menuActiveP = '';
$menuActiveJ = '';
$menuActiveCam = '';
$menuActivePerfil = '';
$menuActiveClientes = '';
$menuActiveTurnos = '';
$form = '';

if (isset($_GET['form'])) {
    $form = $_GET['form']; 

    


    switch ($form) {    
        case "formularioreporte":
            $menuActiveFr = 'active';
            break;
        case "informe":
            $menuActiveI = 'active';
            break;
        case "usuarios":
            $menuActiveU = 'active';
            break;
        case "tipoplanta":
            $menuActiveTp = 'active';
            break;
        case "comisarias":
            $menuActiveC = 'active';
            break;
        case "plantas":
            $menuActiveP = 'active';
            break;
        case "jornadas":
            $menuActiveJ = 'active';
            break;
        case "dashboard":
            $menuActiveD = 'active';
            break;
        case "camaras":
            $menuActiveCam = 'active';
            break;
        case "perfil":
            $menuActivePerfil = 'active';
            break;
        case "clientes":
            $menuActiveClientes = 'active';
            break;
        case "turnos":
            $menuActiveTurnos = 'active';
            break;
    }
}

?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="<?php echo $base_url?>/dashboard.php?token=<?php echo $token;?>" class="brand-link"> <!--begin::Brand Image--> <img src="<?php echo $base_url?>/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text--> <span class="brand-text fw-light">InclusiveCCTV</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item <?php if($menuActiveD!='' || $menuActiveI!='' || $menuActiveFr!=''){echo 'menu-open';}?>"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Dashboard
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="<?php echo $base_url?>/dashboard.php?form=dashboard&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveD;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Dashboard</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="<?php echo $base_url?>/formularios.php?form=informe&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveI;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Informes</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="<?php echo $base_url?>/formularios.php?form=formularioreporte&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveFr;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Reportes CCTV</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item <?php if($menuActiveClientes!='' || $menuActiveTp!='' || $menuActiveC!='' || $menuActiveP!='' || $menuActiveU!='' || $menuActiveJ!=''|| $menuActiveCam!=''|| $menuActivePerfil!=''|| $menuActiveTurnos!=''){echo 'menu-open';}?>"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>
                                    Administración
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> 
                                    <a href="<?php echo $base_url?>/formularios.php?form=perfil&token=<?php echo $token;?>" class="nav-link <?php echo $menuActivePerfil;?>"> 
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Perfiles</p>
                                    </a> 
                                </li>
                                <li class="nav-item"> <a href="<?php echo $base_url?>/formularios.php?form=tipoplanta&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveTp;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Tipo Planta</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="<?php echo $base_url?>/formularios.php?form=comisarias&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveC;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Comisarias</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="<?php echo $base_url?>/formularios.php?form=jornadas&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveJ;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Jornadas</p>
                                    </a> </li>
                                <li class="nav-item"> 
                                    <a href="<?php echo $base_url?>/formularios.php?form=turnos&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveTurnos;?>"> 
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Turnos</p>
                                    </a> 
                                </li>
                                <li class="nav-item"> <a href="<?php echo $base_url?>/formularios.php?form=clientes&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveClientes;?>"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Clientes</p>
                                    </a> </li>
                                <li class="nav-item"> 
                                    <a href="./formularios.php?form=plantas&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveP;?>"> 
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Plantas</p>
                                    </a> 
                                </li>
                                <!-- <li class="nav-item"> <a href="./admCiudades.php?token=<?php echo $token;?>" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Ciudades</p>
                                    </a> </li> -->
                                <li class="nav-item">
                                    <a href="./formularios.php?form=usuarios&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveU;?>">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Usuarios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="./formularios.php?form=camaras&token=<?php echo $token;?>" class="nav-link <?php echo $menuActiveCam;?>">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Admin Cámaras</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                                <p>
                                    Layout Options
                                    <span class="nav-badge badge text-bg-secondary me-3">6</span> <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./layout/unfixed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Default Sidebar</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./layout/fixed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Fixed Sidebar</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./layout/fixed-complete.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Fixed Complete</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./layout/sidebar-mini.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Sidebar Mini</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./layout/collapsed-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Sidebar Mini <small>+ Collapsed</small></p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./layout/logo-switch.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Sidebar Mini <small>+ Logo Switch</small></p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./layout/layout-rtl.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Layout RTL</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                                <p>
                                    UI Elements
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./UI/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>General</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./UI/timeline.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Timeline</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                                <p>
                                    Forms
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./forms/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>General Elements</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                                <p>
                                    Tables
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./tables/simple.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Simple Tables</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-header">EXAMPLES</li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                    Auth
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                        <p>
                                            Version 1
                                            <i class="nav-arrow bi bi-chevron-right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item"> <a href="./examples/login.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                                <p>Login</p>
                                            </a> </li>
                                        <li class="nav-item"> <a href="./examples/register.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                                <p>Register</p>
                                            </a> </li>
                                    </ul>
                                </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                        <p>
                                            Version 2
                                            <i class="nav-arrow bi bi-chevron-right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item"> <a href="./examples/login-v2.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                                <p>Login</p>
                                            </a> </li>
                                        <li class="nav-item"> <a href="./examples/register-v2.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                                <p>Register</p>
                                            </a> </li>
                                    </ul>
                                </li>
                                <li class="nav-item"> <a href="./examples/lockscreen.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Lockscreen</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-header">DOCUMENTATIONS</li>
                        <li class="nav-item"> <a href="./docs/introduction.html" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                                <p>Installation</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/layout.html" class="nav-link"> <i class="nav-icon bi bi-grip-horizontal"></i>
                                <p>Layout</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/color-mode.html" class="nav-link"> <i class="nav-icon bi bi-star-half"></i>
                                <p>Color Mode</p>
                            </a> </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-ui-checks-grid"></i>
                                <p>
                                    Components
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./docs/components/main-header.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Main Header</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./docs/components/main-sidebar.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Main Sidebar</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-filetype-js"></i>
                                <p>
                                    Javascript
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./docs/javascript/treeview.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Treeview</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="./docs/browser-support.html" class="nav-link"> <i class="nav-icon bi bi-browser-edge"></i>
                                <p>Browser Support</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/how-to-contribute.html" class="nav-link"> <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                                <p>How To Contribute</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/faq.html" class="nav-link"> <i class="nav-icon bi bi-question-circle-fill"></i>
                                <p>FAQ</p>
                            </a> </li>
                        <li class="nav-item"> <a href="./docs/license.html" class="nav-link"> <i class="nav-icon bi bi-patch-check-fill"></i>
                                <p>License</p>
                            </a> </li>
                        <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Level 1</p>
                            </a> </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                                <p>
                                    Level 1
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Level 2</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>
                                            Level 2
                                            <i class="nav-arrow bi bi-chevron-right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-record-circle-fill"></i>
                                                <p>Level 3</p>
                                            </a> </li>
                                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-record-circle-fill"></i>
                                                <p>Level 3</p>
                                            </a> </li>
                                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-record-circle-fill"></i>
                                                <p>Level 3</p>
                                            </a> </li>
                                    </ul>
                                </li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Level 2</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                                <p>Level 1</p>
                            </a> </li>
                        <li class="nav-header">LABELS</li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-danger"></i>
                                <p class="text">Important</p>
                            </a> </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-warning"></i>
                                <p>Warning</p>
                            </a> </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-info"></i>
                                <p>Informational</p>
                            </a> </li> -->
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> 