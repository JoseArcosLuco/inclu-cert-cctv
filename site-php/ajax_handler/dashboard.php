<?php
require_once('../includes/Charts.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'updateChart':
            $response = ChartData::obtenerChartData();
            echo json_encode($response);
            break;

        case 'updateChartClientes':
            $id = $_POST['id'];
            $response = ChartData::obtenerDatosClientes($id);
            echo json_encode($response);
            break;

        case 'updateChartWithoutFecha':

            $id_planta = $_POST['id_planta'];

            $chart_data = ChartData::obtenerDatosWithoutFecha($id_planta);

            echo json_encode($chart_data);
            break;

        case 'updateChartWithFecha':

            $id_planta = $_POST['id_planta'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];

            $chart_data = ChartData::obtenerDatosWithFecha($id_planta, $fecha_inicio, $fecha_fin);

            echo json_encode($chart_data);
            break;
    }
}
