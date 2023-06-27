<?php
require_once('inc/header.php');
// Obtener la lista de grados
$sqlGrados = "SELECT ID, Grado FROM Grados";
$resultGrados = $conn->query($sqlGrados);

// Variables para mensajes de alerta
$successMessage = '';
$errorMessage = '';

// Procesar el formulario de registro de útiles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gradoID = $_POST['grado'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    // Verificar si ya existe un registro con el mismo nombre y grado
    $sqlExist = "SELECT ID FROM ListaDeUtiles WHERE GradoID = '$gradoID' AND Nombre = '$nombre'";
    $resultExist = $conn->query($sqlExist);

    if ($resultExist->num_rows > 0) {
        // Actualizar el registro existente
        $rowExist = $resultExist->fetch_assoc();
        $utilID = $rowExist['ID'];

        $sqlUpdate = "UPDATE ListaDeUtiles SET Descripcion = '$descripcion', Cantidad = '$cantidad' WHERE ID = '$utilID'";
        if ($conn->query($sqlUpdate) === TRUE) {
            $successMessage = "Se ha actualizado el útil.";
        } else {
            $errorMessage = "Al actualizar el útil: " . $conn->error;
        }
    } else {
        // Insertar un nuevo útil en la tabla ListaDeUtiles
        $sqlInsert = "INSERT INTO ListaDeUtiles (GradoID, Nombre, Descripcion, Cantidad) VALUES ('$gradoID', '$nombre', '$descripcion', '$cantidad')";
        if ($conn->query($sqlInsert) === TRUE) {
            $successMessage = "Nuevo útil agregado.";
        } else {
            $errorMessage = "Al agregar el nuevo útil: " . $conn->error;
        }
    }
}

// Procesar la eliminación de un útil
if (isset($_GET['delete']) && $_GET['delete'] === 'true' && isset($_GET['utilID'])) {
    $utilID = $_GET['utilID'];

    // Eliminar el útil de la tabla ListaDeUtiles
    $sqlDelete = "DELETE FROM ListaDeUtiles WHERE ID = '$utilID'";
    if ($conn->query($sqlDelete) === TRUE) {
        $successMessage = "Se ha eliminado el útil.";
    } else {
        $errorMessage = "Al eliminar el útil: " . $conn->error;
    }
}
?>

<div>
    <?php
    if (!empty($successMessage)) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>¡Éxito!</strong> " . $successMessage . "
                </div>";
    }
    if (!empty($errorMessage)) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>¡Error!</strong> " . $errorMessage . "
                </div>";
    }
    ?>
</div>
<h2>Registrar Útiles</h2>
<form action="registro_utiles.php" method="POST">
    <div class="row mb-3 align-items-end">
        <div class="col-md-1">
            <label for="grado" class="form-label">Grado:</label>
            <select name="grado" id="grado" class="form-select" required>
                <?php
                $resultGrados->data_seek(0); // Reiniciar el puntero del resultado

                while ($rowGrado = $resultGrados->fetch_assoc()) {
                    echo "<option value='" . $rowGrado['ID'] . "'>" . $rowGrado['Grado'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="cantidad" class="form-label">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required min="0">
        </div>
        <div class="col-md-2">
            <div class="d-grid">
                <input type="submit" value="Agregar Útil" class="btn btn-success">
            </div>
        </div>
    </div>
</form>

<h2>Útiles Registrados</h2>
<table class="lista-utiles" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" class="table-responsive">
    <thead>
        <tr>
            <th class='text-center' data-field="grado" data-filter-control="input" data-sortable="true">Grado</th>
            <th data-field="nombre" data-filter-control="input" data-sortable="true">Nombre</th>
            <th class='text-center' data-field="descripcion" data-filter-control="input" data-sortable="true">Descripción</th>
            <th class='text-center' data-field="cantidad" data-filter-control="input" data-sortable="true">Cantidad</th>
            <th class='text-center' data-field="acciones">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqlUtiles = "SELECT LU.ID, G.Grado, LU.Nombre, LU.Descripcion, LU.Cantidad FROM ListaDeUtiles LU INNER JOIN Grados G ON LU.GradoID = G.ID";
        $resultUtiles = $conn->query($sqlUtiles);

        if ($resultUtiles->num_rows > 0) {
            while ($rowUtil = $resultUtiles->fetch_assoc()) {
                $utilID = $rowUtil['ID'];
                $grado = $rowUtil['Grado'];
                $nombre = $rowUtil['Nombre'];
                $descripcion = $rowUtil['Descripcion'];
                $cantidad = $rowUtil['Cantidad'];

                echo "<tr>";
                echo "<td class='text-center'>" . $grado . "</td>";
                echo "<td>" . $nombre . "</td>";
                echo "<td>" . $descripcion . "</td>";
                echo "<td class='text-center'>" . $cantidad . "</td>";
                echo "<td class='text-center'>";
                echo "<a href='registro_utiles.php?delete=true&utilID=" . $utilID . "' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este útil?\")'><i class='bi bi-trash'></i> Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron útiles registrados.</td></tr>";
        }
        ?>
    </tbody>
</table>
</div>
<?php require_once('inc/footer.php'); ?>