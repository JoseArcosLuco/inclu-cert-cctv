<?php

// Más información: https://help.wnpower.com/hc/es/articles/19296028017677

// Forzar mostrar errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['PRUEBA'])) {
    $valor=$_SESSION['PRUEBA'];
    echo "<br>Session ID: ".session_id();
    echo "<br>Valor de la variable guardada en la Session: ".$valor;
} else {
  echo "<br>Session no disponible. Haz <a href='?reload=true'>reload</a> para iniciar el testeo.";
  $_SESSION['PRUEBA']="Hola Mundo!";
}

?>