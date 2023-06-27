<?php
require_once 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estudianteID = $_POST['estudiante'];
    $utilID = $_POST['util'];
    $cantidad = $_POST['cantidad'];

    $sqlInsert = "INSERT INTO UtilesEstudiante (EstudianteID, UtilID, Cantidad, Timestamp) VALUES ('$estudianteID', '$utilID', '$cantidad', CURRENT_TIMESTAMP)";
    if ($conn->query($sqlInsert) === TRUE) {
        echo "Recepción de material registrada con éxito.";
    } else {
        echo "Error al registrar la recepción de material: " . $conn->error;
    }
}
