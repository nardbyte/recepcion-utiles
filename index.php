<?php
require_once('inc/header.php');

// Obtener la lista de grados
$sqlGrados = "SELECT ID, Grado FROM Grados";
$resultGrados = $conn->query($sqlGrados);
?>

<div class="container principal">
    <h2>Recepción de Materiales</h2>
    <form action="index.php" method="POST" class="mt-4">
        <div class="row mb-3 align-items-end">
            <div class="col-md-4">
                <label for="documento" class="form-label">Nº de Documento:</label>
                <input type="text" name="documento" id="documento" class="form-control" required>
            </div>
            <div class="col-md-5">
                <label for="nombre_estudiante" class="form-label">Nombre completo del estudiante:</label>
                <input type="text" name="nombre_estudiante" id="nombre_estudiante" class="form-control" required>
            </div>
            <div class="col-md-3">
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
        </div>
        <div id="utilesContainer"></div>
        <input type="submit" value="Registrar Recepción" class="btn btn-success">
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
    $documentoEstudiante = $_POST['documento'];
    $gradoID = $_POST['grado'];
    $utiles = isset($_POST['utiles']) ? $_POST['utiles'] : array();

    // Verificar la existencia del estudiante
    $sqlCheckEstudiante = "SELECT ID FROM Estudiantes WHERE Documento = '$documentoEstudiante'";
    $resultCheckEstudiante = $conn->query($sqlCheckEstudiante);

    if ($resultCheckEstudiante->num_rows > 0) {
        // El estudiante ya existe, actualizar el registro
        $rowEstudiante = $resultCheckEstudiante->fetch_assoc();
        $estudianteID = $rowEstudiante['ID'];

        // Eliminar registros anteriores del estudiante en la tabla UtilesEstudiante
        $sqlDeleteUtilesEstudiante = "DELETE FROM UtilesEstudiante WHERE EstudianteID = '$estudianteID'";
        $conn->query($sqlDeleteUtilesEstudiante);
    } else {
        // El estudiante no existe, insertar un nuevo registro en Estudiantes
        $sqlInsertEstudiante = "INSERT INTO Estudiantes (NombreEstudiante, Documento, GradoID) VALUES ('$nombreEstudiante', '$documentoEstudiante', '$gradoID')";
        $conn->query($sqlInsertEstudiante);
        $estudianteID = $conn->insert_id;
    }

    // Insertar registros en la tabla UtilesEstudiante
    foreach ($utiles as $utilID) {
        $cantidad = $_POST['cantidad_' . $utilID];
        $sqlInsertUtil = "INSERT INTO UtilesEstudiante (EstudianteID, UtilID, Cantidad, Timestamp) VALUES ('$estudianteID', '$utilID', '$cantidad', CURRENT_TIMESTAMP)";
        $conn->query($sqlInsertUtil);
    }

    if ($conn->affected_rows > 0) {
        echo '<div class="alert alert-success" role="alert">Recepción de materiales registrada con éxito.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error al registrar la recepción de materiales. Por favor, verifica los datos ingresados.</div>';
    }
}
?>

<?php require_once('inc/footer.php'); ?>