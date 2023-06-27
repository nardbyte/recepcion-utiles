<?php
require_once('inc/header.php');

// Obtener la lista de grados
$sqlGrados = "SELECT ID, Grado FROM Grados";
$resultGrados = $conn->query($sqlGrados);
?>

<div class="container">
    <h2>Registro de Recepción de Materiales:</h2>
    <form action="index.php" method="POST">
        <div class="mb-3">
            <label for="nombre_estudiante" class="form-label">Nombre del Estudiante:</label>
            <input type="text" name="nombre_estudiante" id="nombre_estudiante" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="grado" class="form-label">Grado:</label>
            <select name="grado" id="grado" class="form-select" onchange="fetchUtiles(this.value)">
                <option value="">Selecciona un grado</option>
                <?php
                while ($rowGrado = $resultGrados->fetch_assoc()) {
                    echo "<option value='" . $rowGrado['ID'] . "'>" . $rowGrado['Grado'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div id="utilesContainer"></div>
        <input type="submit" value="Registrar Recepción" class="btn btn-primary">
    </form>
</div>

<script>
    function fetchUtiles(gradoID) {
        const utilesContainer = document.getElementById('utilesContainer');

        if (gradoID !== '') {
            // Obtener los útiles para el grado seleccionado
            fetch(`fetch_utiles.php?gradoID=${gradoID}`)
                .then(response => response.text())
                .then(data => {
                    utilesContainer.innerHTML = data;
                });
        } else {
            utilesContainer.innerHTML = '';
        }
    }
</script>

<?php
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

        echo '<div class="alert alert-success" role="alert">Recepción de materiales registrada con éxito.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error al registrar la recepción de materiales: ' . $conn->error . '</div>';
    }
}
?>

<?php require_once('inc/footer.php'); ?>