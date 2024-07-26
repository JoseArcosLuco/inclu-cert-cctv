<?php
require('fpdf.php');
require_once('includes/Informes.class.php');

$id = isset($_GET['id_gestion_plantas']) ? $_GET['id_gestion_plantas'] : 1;
$datosCliente = Informes::get_client_by_plant_id($id);
$camaras = Informes::get_informe_camaras($id);

$arrayCamaras = [];

foreach ($camaras as $camara) {
    $arrayCamaras[] = [
        'nombrecamara' => $camara['nombrecamara'],
        'operatividad' => $camara['estadocamara'],
        'observacion' => $camara['observacion']
    ];
}

// Datos del cliente
$cliente = [
    'nombre' => $datosCliente['nombrecliente'],
    'planta' => $datosCliente['planta'],
    'nombreusuario' => $datosCliente['nombreusuario'],
    'turno' => $datosCliente['turno'],
    'horario' => $datosCliente['horario'],
    'fecha_registro' => $datosCliente['fecha_gestion'],
    'observaciones' => $datosCliente['observaciones'],
    'camaras' => $arrayCamaras
];

// Datos adicionales del cliente
$datosAdicionales = [
    'planta_en_linea' => $datosCliente['planta_en_linea'],
    'camarasintermitencia' => $datosCliente['camarasintermitencia'],
    'camaras_sin_conexion' => $datosCliente['camaras_sin_conexion'],
    'camaras_totales' => $datosCliente['camaras_totales'],
    'fecha_registro' => $datosCliente['fecha_gestion'],
    'observaciones' => $datosCliente['observaciones']
];

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('./assets/img/AdminLTEFullLogo.png', 10, 6, 30);
        $this->Image('./assets/img/AdminLTELogo.png', 250, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Mover a la derecha
        $this->Cell(100);
        // Título
        $this->Cell(70, 10, utf8_decode('Reporte de Cámaras CCTV'), 0, 1, 'C');
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
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
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
        $w = [45, 45, 45, 45, 45, 45]; // Anchuras de las columnas
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos del cliente
        $this->Cell($w[0], 6, utf8_decode($cliente['nombre']), 'LR', 0, 'L');
        $this->Cell($w[1], 6, utf8_decode($cliente['planta']), 'LR', 0, 'L');
        $this->Cell($w[2], 6, utf8_decode($cliente['nombreusuario']), 'LR', 0, 'L');
        $this->Cell($w[3], 6, utf8_decode($cliente['turno']), 'LR', 0, 'L');
        $this->Cell($w[4], 6, utf8_decode($cliente['horario']), 'LR', 0, 'L');
        $this->Cell($w[5], 6, utf8_decode($cliente['fecha_registro']), 'LR', 0, 'L');
        $this->Ln();
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Tabla de datos adicionales
    function TablaDatosAdicionales($header, $datosAdicionales)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(0, 128, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 100, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $w = [55, 55, 55, 55, 55, 55]; // Anchuras de las columnas
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos adicionales del cliente
        $this->Cell($w[0], 6, utf8_decode($datosAdicionales['planta_en_linea']), 'LR', 0, 'L');
        $this->Cell($w[1], 6, utf8_decode($datosAdicionales['camarasintermitencia']), 'LR', 0, 'L');
        $this->Cell($w[2], 6, utf8_decode($datosAdicionales['camaras_sin_conexion']), 'LR', 0, 'L');
        $this->Cell($w[3], 6, utf8_decode($datosAdicionales['camaras_totales']), 'LR', 0, 'L');
        $this->Cell($w[4], 6, utf8_decode($datosAdicionales['fecha_registro']), 'LR', 0, 'L');
        $this->Cell($w[5], 6, utf8_decode($datosAdicionales['observaciones']), 'LR', 0, 'L');
        $this->Ln();
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
        $w = [90, 90, 90]; // Anchuras de las columnas
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos de las cámaras
        $fill = false;
        foreach ($camaras as $cam) {
            $this->Cell($w[0], 6, utf8_decode($cam['nombrecamara']), 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, utf8_decode($cam['operatividad']), 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, utf8_decode($cam['observacion']), 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Crear el PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

// Tabla del cliente
$headerCliente = ['Cliente', 'Planta', 'Usuario', 'Turno', 'Horario', 'Fecha Registro'];
$pdf->TablaCliente($headerCliente, $cliente);

// Salto de línea
$pdf->Ln(10);

// Tabla de datos adicionales
$headerDatosAdicionales = ['Planta en Línea', 'Cámaras Intermitencia', 'Cámaras sin Conexión', 'Cámaras Totales', 'Fecha Registro', 'Observaciones'];
$pdf->TablaDatosAdicionales($headerDatosAdicionales, $datosAdicionales);

// Salto de línea
$pdf->Ln(10);

// Tabla de cámaras
$headerCamaras = ['Cámara', 'Operatividad', 'Observación'];
$pdf->TablaCamaras($headerCamaras, $cliente['camaras']);

// Salida del PDF
$pdf->Output();


?>
