<?php
include("./includes/Database.class.php");

 $servername = 'localhost';
 $username = 'ibdfohwj_cctv_inclusive';
 $password = 'r.vGf]kh?IN~';
 $dbname = 'ibdfohwj_cctv_inclusive';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$limit = $_GET['length'];
$offset = $_GET['start'];
$search = $_GET['search']['value'];
$order_column = $_GET['order'][0]['column'];
$order_dir = $_GET['order'][0]['dir'];

$columns = ["id", "planta", "nombreusuario", "turno", "horario", "planta_en_linea", "camarasintermitencia", "camaras_sin_conexion","camaras_totales","observaciones","fecha_gestion","fecha_registro","estadoreporte"];

$sql = "select gp.id,p.nombre as planta,concat(u.nombres,' ',u.apellidos) as nombreusuario,t.nombre as turno,gp.horario,";
$sql .= "(case when gp.planta_en_linea=1 Then 'Si' else 'No' end) as planta_en_linea, ";
$sql .= "gp.con_intermitencia as camarasintermitencia,gp.camaras_sin_conexion,gp.camaras_totales,gp.observaciones, gp.fecha_gestion,gp.fecha_registro, ";
$sql .= "(case when gp.estado=1 Then 'Aprobado' else 'Por Aprobar' end) as estadoreporte ";
$sql .= "from cctv_gestion_plantas as gp ";
$sql .= "inner join cctv_plantas as p on (p.id = gp.id_plantas) ";
$sql .= "inner join cctv_users as u on (u.id = gp.id_users) ";
$sql .= "inner join cctv_turnos as t on (t.id = gp.id_turno) WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (gp.id LIKE '%$search%' OR p.nombre LIKE '%$search%' OR concat(u.nombres,' ',u.apellidos) LIKE '%$search%' OR t.nombre LIKE '%$search%' OR gp.horario LIKE '%$search%' OR gp.fecha_gestion LIKE '%$search%')";
}

$total_data = $conn->query($sql)->num_rows;

$sql .= " ORDER BY " . $columns[$order_column] . " " . $order_dir . " LIMIT $limit OFFSET $offset";

$data = [];
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$response = [
    "draw" => intval($_GET['draw']),
    "recordsTotal" => $total_data,
    "recordsFiltered" => $total_data,
    "data" => $data
];

echo json_encode($response);


?>