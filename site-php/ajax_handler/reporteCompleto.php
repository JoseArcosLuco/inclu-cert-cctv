<?php
include("../includes/Database.class.php");
include("../includes/RCompleto.class.php");

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'get_plantas':
            $id_cliente = $_POST['id_cliente'];

            $response = ReporteCompleto::get_plantas($id_cliente);

            echo json_encode($response);
            break;

        case 'get_plantas_camaras':
            $id_plantas = $_POST['id_plantas'];

            $response = ReporteCompleto::get_plantas_camaras($id_plantas);

            echo json_encode($response);
            break;

        case 'guardarReportes':
            $id_planta = $_POST['id_planta'];
            $fecha = $_POST['fecha'];
            $id_camara = $_POST['id_camara'];
            $id_operador = $_POST['id_operador'];
            $estado = $_POST['estado'];
            $visual = $_POST['visual'];
            $analiticas = $_POST['analiticas'];
            $recorrido = $_POST['recorrido'];
            $evento = $_POST['evento'];
            $grabaciones = $_POST['grabaciones'];
            $observacion = $_POST['observacion'];

            $response = ReporteCompleto::create_reporte($id_planta, $id_operador, $id_camara ,$estado, $visual, $analiticas, $recorrido, $evento, $grabaciones, $observacion);

            echo json_encode($response);
            break;

        default:
            echo 'Fail';
            break;
    }
}
