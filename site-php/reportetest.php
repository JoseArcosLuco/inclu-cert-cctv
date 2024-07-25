<?php
require('fpdf.php');
require_once('includes/Informes.class.php');
require_once('includes/Camaras.class.php');
$id = isset($_GET['id_gestion_plantas']);
$datosCliente = Informes::get_client_by_plant_id($id);
$planta = Informes::get_plantas_by_informe_id($id);
$informe = Informes::get_informe($id);
$camaras = Camaras::get_all_camaras($planta['id']);
$arrayCamaras = [];
foreach ($camaras as $camara) {
    $arrayCamaras[] = [
        'id' => $camara['nombre'],
        'operatividad' => $camara['estado'] ? 'Operativa' : 'No Operativa',
    ];
}

// Datos de ejemplo para un cliente
$cliente = [
    'nombre' => $datosCliente['nombre'],
    'planta' => $planta['nombre'],
    'fecha_registro' => $informe['fecha_registro'],
    'camaras' => $arrayCamaras
];

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('./assets/img/AdminLTEFullLogo.png', 10, 6, 30);
        $this->Image('./assets/img/AdminLTELogo.png', 170, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Mover a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Reporte de Camaras CCTV', 0, 1, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Tabla del cliente
    function TablaCliente($header, $cliente)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $w = [60, 60, 60]; // Anchuras de las columnas
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos del cliente
        $this->Cell($w[0], 6, $cliente['nombre'], 'LR', 0, 'L');
        $this->Cell($w[1], 6, $cliente['planta'], 'LR', 0, 'L');
        $this->Cell($w[2], 6, $cliente['fecha_registro'], 'LR', 0, 'L');
        $this->Ln();
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Tabla de cámaras
    function TablaCamaras($header, $camaras)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(0, 128, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 100, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $w = [60, 60]; // Anchuras de las columnas
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos de las cámaras
        $fill = false;
        foreach ($camaras as $cam) {
            $this->Cell($w[0], 6, 'Camara ' . $cam['id'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $cam['operatividad'], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Tabla del cliente
$headerCliente = ['Cliente', 'Planta', 'Fecha Registro'];
$pdf->TablaCliente($headerCliente, $cliente);

// Salto de línea
$pdf->Ln(10);

// Tabla de cámaras
$headerCamaras = ['Camara', 'Operatividad'];
$pdf->TablaCamaras($headerCamaras, $cliente['camaras']);

// Agregar observación
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Observaciones:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $informe['observaciones']);

// Salida del PDF
$pdf->Output();
?>
