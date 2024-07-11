<?php
function getMensajeAlerta($codigo) {
    $output = '';

    //el match funciona mejor que el switch a mi gusto
    match (true) {
        $codigo == 1 => $output = "<div class='alert alert-danger'><strong>ERROR!</strong> Sin autorización</div>",
        $codigo == 2 => $output = "<div class='alert alert-success' style='color: #FFFFFF;background-color: #498C2D;border-color: #d6e9c6'><strong>Correcto!</strong> Sesión Cerrada</div>",
        $codigo == 3 => $output = "<div class='alert alert-info' style='color: #FFFFFF;background-color: #076480;border-color: #bce8f1'>
            <strong>ATENCIÓN! </strong>Para un correcto funcionamiento de la aplicación se recomienda utilizar Google Chrome <a href='https://www.google.com/intl/es-419/chrome/browser/desktop/index.html' target='_blank'><img src='../img/google-chrome.ico' width='32' height='32'></a>
            </div>",
        default => $output = '',
    };

    return $output;
}
?>