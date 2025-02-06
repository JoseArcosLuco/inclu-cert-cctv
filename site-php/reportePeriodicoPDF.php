<?php
require('fpdf.php');
require_once('includes/Informes.class.php');

$fecha = $_GET['fecha'];
$hora = $_GET['hora'];

$fullDate = $fecha . ' ' . $hora;

$data = Informes::get_periodicos_by_date($fullDate);


class PDF extends FPDF
{
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
        $this->Image('./assets/img/AdminLTEFullLogo.png', 10, 6, 30);
        $this->Image('./assets/img/AdminLTELogo.png', 250, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100);
        $this->Cell(70, 10, utf8_decode('Reporte de Cámaras CCTV'), 0, 1, 'C');
        $this->Ln(20);
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

        $this->SetFillColor(200, 220, 255);
        $this->SetTextColor(0);
        $this->SetFont('', 'B');

        $this->Cell(array_sum($this->GetColumnWidths($header)), 10, "Cliente: " . utf8_decode($cliente) . " | Fecha: " . $fechaFormateada . " | Hora: " . $horaFormateada, 1, 1, 'L', true);
        $this->Ln(5);

        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        $w = $this->GetColumnWidths($header);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['id'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['camaras'], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $row['camaras_online'], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, utf8_decode($this->renderEstado($row['canal'])), 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, utf8_decode($row['observacion']), 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, $row['planta'], 'LR', 0, 'L', $fill);
            $this->Cell($w[6], 6, $row['operador'], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }

    function GetColumnWidths($header) {
        return array(10, 30, 30, 60, 65, 45, 35);
    }
}



$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$header = array('ID', utf8_decode('Cámaras'), utf8_decode('Cám Online'), 'Estado', utf8_decode('Observación'), 'Planta', 'Operador');

$pdf->CreateTable($header, $data);

$pdf->Output();
?>