<?php
require_once('../includes/Charts.class.php');
require_once('../includes/Users.class.php');
require_once('../includes/Plantas.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'updateChart':
            $response = ChartData::obtenerChartData();
            echo json_encode($response);
            break;
        
        case 'updateCardsWithoutCliente':
            $id_cliente = '';
            $id_planta = '';
            $response['countUsers'] = Users::countUsers();
            $response['countPlantas'] = Plantas::countPlantas($id_cliente);
            $response['countReportes'] = ChartData::countReportesPlantas($id_planta, '', '');
            $response['porcentaje'] = ChartData::porcentajeReportes($id_cliente, $id_planta);
            echo json_encode($response);
            break;

        case 'updateChartClientes':
            $id_planta = '';
            $id_cliente = $_POST['id'];
            $response = ChartData::obtenerDatosClientes($id_cliente);
            $response['countPlantas'] = Plantas::countPlantas($id_cliente);
            $response['porcentaje'] = ChartData::porcentajeReportes($id_cliente, $id_planta);
            echo json_encode($response);
            break;

        case 'updateChartWithoutFecha':

            $id_cliente = '';
            $id_planta = $_POST['id_planta'];

            $chart_data = ChartData::obtenerDatosWithoutFecha($id_planta);
            $chart_data['countReportes'] = ChartData::countReportesPlantas($id_planta, '', '');
            $chart_data['porcentaje'] = ChartData::porcentajeReportes($id_cliente, $id_planta);

            echo json_encode($chart_data);
            break;

        case 'updateChartWithFecha':

            $id_cliente = '';
            $id_planta = $_POST['id_planta'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];

            $chart_data = ChartData::obtenerDatosWithFecha($id_planta, $fecha_inicio, $fecha_fin);
            $chart_data['countReportes'] = ChartData::countReportesPlantas($id_planta, $fecha_inicio, $fecha_fin);
            $chart_data['porcentaje'] = ChartData::porcentajeReportes($id_cliente, $id_planta, $fecha_inicio, $fecha_fin);

            echo json_encode($chart_data);
            break;
    }
}
