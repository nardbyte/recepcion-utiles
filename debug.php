<?php
require_once('inc/config.php');

// Función para limpiar tabla y reiniciar los IDs a 1
function limpiarTabla($tableName)
{
    global $conn;

    try {
        // Limpiar tabla
        $conn->query("DELETE FROM $tableName");

        // Reiniciar ID a 1
        $conn->query("ALTER TABLE $tableName AUTO_INCREMENT = 1");

        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Comprobar si se hizo clic en el botón "Limpiar tablas"
if (isset($_POST['limpiarTablas'])) {
    $tablas = array(
        "UtilesEstudiante",
        "Estudiantes",
        "ListaDeUtiles",
        "Grados"
    );

    $exitoso = true;

    foreach ($tablas as $tabla) {
        $resultado = limpiarTabla($tabla);

        if (!$resultado) {
            $exitoso = false;
            break;
        }
    }

    if ($exitoso) {
        $mensaje = "Las tablas se limpiaron y los IDs se reiniciaron a 1.";
    } else {
        $mensaje = "Error al limpiar las tablas.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Limpiar tablas y reiniciar IDs</title>
</head>

<body>
    <h2>Limpiar tablas y reiniciar IDs</h2>

    <?php if (isset($mensaje)) { ?>
        <p><?php echo $mensaje; ?></p>
    <?php } ?>

    <form method="POST" action="">
        <input type="hidden" name="limpiarTablas" value="true">
        <button type="submit">Limpiar tablas y reiniciar IDs</button>
    </form>
</body>

</html>