<?php
include("../includes/Database.class.php");
include("../includes/RCompleto.class.php");
include("../includes/Camaras.class.php");

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'get_plantas':
            $id_cliente = $_POST['id_cliente'];

            $response = ReporteCompleto::get_plantas($id_cliente);

            echo json_encode($response);
            break;

        case 'updateClienteSelect':
            $id = $_POST['id'];

            $response = Camaras::get_plantas_by_cliente_id($id);

            echo json_encode($response);
            break;

        case 'get_plantas_camaras':
            $id_plantas = $_POST['id_plantas'];

            $response = ReporteCompleto::get_plantas_camaras($id_plantas);

            echo json_encode($response);
            break;

        case 'guardarReportes':
            $id_camara = $_POST['id_camara'];
            $id_operador = $_POST['id_operador'];
            $estado = $_POST['estado'];
            $visual = $_POST['visual'];
            $analiticas = $_POST['analiticas'];
            $recorrido = $_POST['recorrido'];
            $evento = $_POST['evento'];
            $grabaciones = $_POST['grabaciones'];
            $observacion = $_POST['observacion'];
            $id_reporte = $_POST['id_insertado'];

            $response = ReporteCompleto::create_reporte($id_reporte, $id_operador, $id_camara, $estado, $visual, $analiticas, $recorrido, $evento, $grabaciones, $observacion);

            echo json_encode($response);
            break;

        case 'guardarReportesGral':
            $id_planta = $_POST['planta_id'];
            $fecha = $_POST['fecha'];
            $usuario_id = $_POST['usuario_id'];

            $response = ReporteCompleto::create_reporteGral($id_planta, $fecha, $usuario_id);

            echo json_encode($response);
            break;

        case 'get_reportes':

            $id_planta = isset($_POST['planta']) ? $_POST['planta'] : null;
            $id_cliente = isset($_POST['cliente']) ? $_POST['cliente'] : null;
            $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;

            $response = ReporteCompleto::get_reportes($id_planta, $id_cliente, $fecha);

            echo json_encode($response);
            break;

        case 'edit_reporte':
            $id = $_POST['id'];
            $id_operador = $_POST['id_operador'];
            $estado = $_POST['estado'];
            $visual = $_POST['visual'];
            $analiticas = $_POST['analiticas'];
            $recorrido = $_POST['recorrido'];
            $evento = $_POST['evento'];
            $grabaciones = $_POST['grabaciones'];
            $observacion = $_POST['observacion'];

            $response = ReporteCompleto::edit_reporte($id, $id_operador, $estado, $visual, $analiticas, $recorrido, $evento, $grabaciones, $observacion);

            echo json_encode($response);
            break;

        case 'delete_reporte':
            $id = $_POST['id'];

            $response = ReporteCompleto::delete_reporte($id);

            echo json_encode($response);
            break;

        default:
            echo 'Fail';
            break;
    }
}
