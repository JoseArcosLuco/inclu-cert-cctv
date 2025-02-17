<?php
require('fpdf.php');
require_once('includes/Informes.class.php');
require_once('jpgraph/src/jpgraph.php'); // Ruta a jpgraph
require_once('jpgraph/src/jpgraph_pie.php'); // Ruta a jpgraph para gráficos circulares

$fecha = $_GET['fecha'];
$hora = $_GET['hora'];

$fullDate = $fecha . ' ' . $hora;

$data = Informes::get_periodicos_by_date($fullDate);

if (empty($data)) {
    echo 'No hay datos para el reporte';
    exit;
}

class PDF extends FPDF
{
    function generatePieChart($camaras, $camaras_online, $tempFilePath)
    {
        $data = array($camaras_online, $camaras - $camaras_online);

        $graph = new PieGraph(260, 220);

        $pieplot = new PiePlot($data);
        $pieplot->SetSliceColors(array('green', 'lightblue'));
        $pieplot->SetLegends(array('Cámaras Online', 'Cámaras Offline'));

        $pieplot->SetLabels(array($camaras, $camaras - $camaras_online));

        $graph->Add($pieplot);

        $graph->Stroke($tempFilePath);
    }

    function renderEstado($data) {
        $estados = [
            1 => 'En Linea',
            2 => 'Intermitente/ Baja señal',
            3 => 'Reconector Abierto',
            4 => 'Pérdida De Red',
            5 => 'Pérdida De Conexión / Sin Confirmar'
        ];
        return $estados[$data] ?? 'Desconocido';
    }

    function Header()
    {
        $this->Image('./assets/img/inclusive-group-logo.jpg', 10, 10, 80, 30);
        $this->Cell(80, 30, '', 0, 0, 'C', false);
        $this->SetFont('Arial', 'B', 24);
        $this->SetFillColor(255, 150, 15);
        $this->Cell(190, 30, utf8_decode('Reporte de Estado de CCTV'), 1, 1, 'C', true);
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function CreateTable($header, $data)
    {
        $cliente = $data[0]['cliente'];
        $fechaFormateada = date("d/m/Y", strtotime($data[0]['fecha']));
        $horaFormateada = date("H:i", strtotime($data[0]['fecha']));

        if (empty($cliente)) {
            return;
        }

        $this->SetFillColor(255, 150, 15);
        $this->SetTextColor(0);
        $this->SetFont('Arial', 'B', 14);

        $this->Cell(array_sum($this->GetColumnWidths($header)), 10, "Cliente: " . utf8_decode($cliente) . " | Fecha: " . $fechaFormateada . " | Hora: " . $horaFormateada, 'TLR', 1, 'L', true);

        $this->SetFillColor(255, 150, 15);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.1);
        $this->SetFont('Arial', 'B', 12);

        $w = $this->GetColumnWidths($header);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 11);

        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 50, $row['id'], 'LBT', 0, 'C', $fill);
            $this->Cell($w[1], 50, $row['camaras'], 'LBT', 0, 'C', $fill);
            $this->Cell($w[2], 50, $row['camaras_online'], 'LBT', 0, 'C', $fill);
            $this->Cell($w[3], 50, utf8_decode($this->renderEstado($row['canal'])), 'LBT', 0, 'C', $fill);
            $this->Cell($w[4], 50, utf8_decode($row['observacion']), 'LBT', 0, 'C', $fill);
            $this->Cell($w[5], 50, utf8_decode($row['planta']), 'LBT', 0, 'C', $fill);
            if ($row['camaras'] > 0) {
                $tempFilePath = tempnam(sys_get_temp_dir(), 'chart') . '.png';
                $this->generatePieChart($row['camaras'], $row['camaras_online'], $tempFilePath);
                $this->Image($tempFilePath, $this->GetX() + 1, $this->GetY() + 1, 61, 50);
                $this->Cell($w[6], 50, '', 'LRBT', 0, 'C', false);
                unlink($tempFilePath);
            } else {
                $this->Cell($w[6], 50, utf8_decode('Sin cámaras'), 'LRBT', 0, 'L', $fill);
            }

            $this->Ln();
            $fill = !$fill;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }

    function GetColumnWidths($header) {
        return array(10, 20, 25, 43, 65, 45, 62);
    }
}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$header = array('ID', utf8_decode('Cámaras'), utf8_decode('Cám Online'), 'Estado', utf8_decode('Observación'), 'Planta', utf8_decode('Gráfico'));

$pdf->CreateTable($header, $data);

$pdf->Output();
?>