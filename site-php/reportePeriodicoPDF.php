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
    protected $clientData;
    protected $headerTitles;

    function setClientData($data) {
        $this->clientData = $data;
    }
    
    function setHeaderTitles($titles) {
        $this->headerTitles = $titles;
    }

    function generatePieChart($camaras, $camaras_online, $tempFilePath)
    {
        $data = array($camaras_online, $camaras - $camaras_online);

        $graph = new PieGraph(260, 220);
        $graph->SetShadow();
        $pieplot = new PiePlot($data);
        
        $pieplot->SetSliceColors(array('MediumAquamarine', 'PeachPuff'));
        $pieplot->SetLegends(array('Cámaras Online', 'Cámaras Offline'));

        $pieplot->SetLabels(array($camaras, $camaras - $camaras_online));
        $pieplot->SetTheme("earth");
        $graph->Add($pieplot);

        $graph->Stroke($tempFilePath);
    }

    function renderEstado($data) {
        $estados = [
            1 => 'En Linea',
            2 => 'Intermitente / Baja señal',
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
        
        if (!empty($this->clientData)) {
            $cliente = $this->clientData[0]['cliente'];
            $fechaFormateada = date("d/m/Y", strtotime($this->clientData[0]['fecha']));
            $horaFormateada = date("H:i", strtotime($this->clientData[0]['fecha']));
            
            if (!empty($cliente)) {
                $this->SetFillColor(255, 150, 15);
                $this->SetTextColor(0);
                $this->SetFont('Arial', 'B', 14);
                
                $w = $this->GetColumnWidths($this->headerTitles);
                
                $this->Cell(array_sum($w), 10, "Cliente: " . utf8_decode($cliente) . " | Fecha: " . $fechaFormateada . " | Hora: " . $horaFormateada, 'TLR', 1, 'L', true);
                
                // Añadir los títulos de las columnas
                if (!empty($this->headerTitles)) {
                    $this->SetFillColor(255, 150, 15);
                    $this->SetTextColor(0);
                    $this->SetDrawColor(0);
                    $this->SetLineWidth(.1);
                    $this->SetFont('Arial', 'B', 12);
                    
                    for ($i = 0; $i < count($this->headerTitles); $i++)
                        $this->Cell($w[$i], 7, $this->headerTitles[$i], 1, 0, 'C', true);
                    $this->Ln();
                }
            }
        }
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function CreateTable($header, $data)
    {
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 11);

        $w = $this->GetColumnWidths($header);
        $maxHeight = 50; // Altura estándar de las celdas
        $rowsPerPage = floor(($this->h - $this->GetY() - 15) / $maxHeight);
        $rowCounter = 0;

        foreach ($data as $row) {
            if ($rowCounter >= $rowsPerPage) {
                $this->AddPage();
                $rowCounter = 0;
                $rowsPerPage = floor(($this->h - $this->GetY() - 15) / $maxHeight);
            }

            $startY = $this->GetY();
            $startX = $this->GetX();

            $x = $startX;
            $y = $startY;
            $plantaWidth = $w[0];
            
            $textPlanta = str_replace(["\r", "\n"], ' ', $row['planta']);
            $textPlanta = mb_convert_encoding($textPlanta, 'ISO-8859-1', 'UTF-8');
            
            $this->Rect($x, $y, $plantaWidth, $maxHeight, 'LBT');
            
            $lines = $this->GetWrappedLines($textPlanta, $plantaWidth);
            $lineHeight = 5;
            $totalTextHeight = count($lines) * $lineHeight;
            $vertOffset = max(0, ($maxHeight - $totalTextHeight) / 2);
            
            $this->SetXY($x, $y + $vertOffset);
            
            $this->MultiCell($plantaWidth, $lineHeight, $textPlanta, 0, 'C');
            
            $this->SetXY($x + $plantaWidth, $y);

            // Fila Total Cámaras
            $this->Cell($w[1], $maxHeight, $row['camaras'], 'LBT', 0, 'C');

            // Fila Cámaras Online
            $this->Cell($w[2], $maxHeight, $row['camaras_online'], 'LBT', 0, 'C');

            // Fila Estado
            //Cambio de color de la celda según el estado
            if ($row['canal'] === 1) {
                $this->SetTextColor(16, 164, 18); //Verde
            } elseif ($row['canal'] === 2 || $row['canal'] === 3) {
                $this->SetTextColor(198, 131, 0); //Naranja
            } elseif ($row['canal'] === 4 || $row['canal'] === 5) {
                $this->SetTextColor(191, 17, 17); //Rojo
            }
            $this->Cell($w[3], $maxHeight, utf8_decode($this->renderEstado($row['canal'])), 1, 0, 'C');

            $this->SetTextColor(0);

            // Fila Observación
            $x = $this->GetX();
            $y = $this->GetY();     
            $obsWidth = $w[4];

            $textObs = str_replace(["\r", "\n"], ' ', $row['observacion']);
            $textObs = mb_convert_encoding($textObs, 'ISO-8859-1', 'UTF-8');

            $this->Rect($x, $y, $obsWidth, $maxHeight, 'DF');
            
            $obsLines = $this->GetWrappedLines($textObs, $obsWidth);
            $obsTextHeight = count($obsLines) * $lineHeight;
            $obsVertOffset = max(0, ($maxHeight - $obsTextHeight) / 2);
            
            $this->SetXY($x, $y + $obsVertOffset);
            $this->MultiCell($obsWidth, $lineHeight, $textObs, 0, 'L');
            
            $this->SetXY($x + $obsWidth, $y);
            
            // Fila Gráfico
            if ($row['camaras'] > 0) {
                $tempFilePath = tempnam(sys_get_temp_dir(), 'chart') . '.png';
                $this->generatePieChart($row['camaras'], $row['camaras_online'], $tempFilePath);
                $this->Image($tempFilePath, $this->GetX() + 1, $this->GetY() + 1, 61, $maxHeight - 2);
                $this->Cell($w[5], $maxHeight, '', 'LRBT', 0, 'C', false);
                unlink($tempFilePath);
            } else {
                $this->Cell($w[5], $maxHeight, utf8_decode('Sin cámaras'), 'LRBT', 0, 'C');
            }

            $this->SetY($startY + $maxHeight);
            $this->SetX($startX);
            $rowCounter++;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Función auxiliar para calcular cuántas líneas ocupará un texto
    function GetWrappedLines($text, $width) {
        $this->SetFont('Arial', '', 11);
        $lines = [];
        $words = explode(' ', $text);
        $line = '';
        
        foreach ($words as $word) {
            $testLine = $line . ' ' . $word;
            $testLine = trim($testLine);
            
            if ($this->GetStringWidth($testLine) <= $width) {
                $line = $testLine;
            } else {
                if ($line) {
                    $lines[] = $line;
                }
                $line = $word;
            }
        }
        
        if ($line) {
            $lines[] = $line;
        }
        
        return $lines;
    }

    function GetColumnWidths($header) {
        return array(35, 30, 30, 45, 60, 70);
    }
}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();

$header = array('Planta', utf8_decode('Total Cámaras'), utf8_decode('Cám Online'), 'Estado', utf8_decode('Observación'),  utf8_decode('% de Visualización'));
$pdf->setHeaderTitles($header);
$pdf->setClientData($data);

$pdf->AddPage();

$pdf->CreateTable($header, $data);

$pdf->Output();
?>