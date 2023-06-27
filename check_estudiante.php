<?php
require_once('inc/config.php');
// Obtener los datos enviados por la solicitud
$nombreEstudiante = $_GET['nombre'];
$gradoID = $_GET['gradoID'];

// Realizar la verificación en la base de datos (adapta el código según tu estructura de base de datos)
// Aquí se asume que tienes una conexión a la base de datos establecida en el archivo 'inc/header.php'
$sqlVerificarEstudiante = "SELECT COUNT(*) AS total FROM Estudiantes WHERE NombreEstudiante = '$nombreEstudiante' AND GradoID = '$gradoID'";
$resultado = $conn->query($sqlVerificarEstudiante);

if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $existeEstudiante = $fila['total'] > 0;
} else {
    $existeEstudiante = false;
}

// Devolver la respuesta JSON
$response = array(
    'exists' => $existeEstudiante
);
header('Content-Type: application/json');
echo json_encode($response);
