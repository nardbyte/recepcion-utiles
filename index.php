<?php
require_once('inc/header.php');
// Obtener la lista de grados
$sqlGrados = "SELECT ID, Grado FROM Grados";
$resultGrados = $conn->query($sqlGrados);

// Procesar el formulario de recepción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEstudiante = $_POST['nombre_estudiante'];
    $gradoID = $_POST['grado'];
    $utiles = isset($_POST['utiles']) ? $_POST['utiles'] : array();

    // Insertar registro en la tabla Estudiantes
    $sqlInsertEstudiante = "INSERT INTO Estudiantes (NombreEstudiante, GradoID) VALUES ('$nombreEstudiante', '$gradoID')";
    if ($conn->query($sqlInsertEstudiante) === TRUE) {
        $estudianteID = $conn->insert_id;

        // Insertar registros en la tabla UtilesEstudiante
        foreach ($utiles as $utilID) {
            $cantidad = $_POST['cantidad_' . $utilID];
            $sqlInsertUtil = "INSERT INTO UtilesEstudiante (EstudianteID, UtilID, Cantidad, Timestamp) VALUES ('$estudianteID', '$utilID', '$cantidad', CURRENT_TIMESTAMP)";
            $conn->query($sqlInsertUtil);
        }

        echo "Recepción de materiales registrada con éxito.";
    } else {
        echo "Error al registrar la recepción de materiales: " . $conn->error;
    }
}
?>

<h1>Recepción de Materiales Escolares</h1>

<h2>Listado de Útiles por Grado:</h2>
<?php
while ($rowGrado = $resultGrados->fetch_assoc()) {
    $gradoID = $rowGrado['ID'];
    $grado = $rowGrado['Grado'];

    echo "<h3>Grado: " . $grado . "</h3>";

    // Obtener los útiles para el grado actual
    $sqlUtiles = "SELECT ID, Nombre, Descripcion FROM ListaDeUtiles WHERE GradoID = $gradoID";
    $resultUtiles = $conn->query($sqlUtiles);

    echo "<form action='index.php' method='POST'>";
    echo "<input type='hidden' name='grado' value='$gradoID'>";

    while ($rowUtil = $resultUtiles->fetch_assoc()) {
        $utilID = $rowUtil['ID'];
        $nombre = $rowUtil['Nombre'];
        $descripcion = $rowUtil['Descripcion'];

        echo "<input type='checkbox' name='utiles[]' value='$utilID'> $nombre - $descripcion<br>";
        echo "Cantidad: <input type='number' name='cantidad_$utilID' value='1' min='1'><br><br>";
    }

    echo "<hr>";
}
?>

<h2>Registro de Recepción de Materiales:</h2>
<form action="index.php" method="POST">
    <label for="nombre_estudiante">Nombre del Estudiante:</label>
    <input type="text" name="nombre_estudiante" id="nombre_estudiante" required>
    <br><br>
    <label for="grado">Grado:</label>
    <select name="grado" id="grado">
        <?php
        $resultGrados->data_seek(0); // Reiniciar el puntero del resultado

        while ($rowGrado = $resultGrados->fetch_assoc()) {
            echo "<option value='" . $rowGrado['ID'] . "'>" . $rowGrado['Grado'] . "</option>";
        }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Registrar Recepción">
</form>

</div>
<?php require_once('inc/footer.php'); ?>