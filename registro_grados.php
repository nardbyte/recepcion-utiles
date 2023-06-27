<?php
require_once('inc/header.php');

// Obtener la lista de grados
$sqlGrados = "SELECT ID, Grado FROM Grados";
$resultGrados = $conn->query($sqlGrados);

// Variables para mensajes de alerta
$successMessage = '';
$errorMessage = '';

// Procesar el formulario de registro de grados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grado = $_POST['grado'];

    // Verificar si el grado ya existe en la base de datos
    $sqlCheckGrado = "SELECT * FROM Grados WHERE Grado = '$grado'";
    $resultCheckGrado = $conn->query($sqlCheckGrado);

    if ($resultCheckGrado->num_rows > 0) {
        echo "<div class='alert alert-danger' role='alert'>El grado '$grado' ya está registrado.</div>";
    } else {
        // Insertar nuevo grado en la base de datos
        $sqlInsertGrado = "INSERT INTO Grados (Grado) VALUES ('$grado')";

        if ($conn->query($sqlInsertGrado) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>El grado '$grado' se registró exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al registrar el grado: " . $conn->error . "</div>";
        }
    }
}

// Procesar la eliminación de un grado
if (isset($_GET['delete']) && $_GET['delete'] === 'true' && isset($_GET['gradoID'])) {
    $gradoID = $_GET['gradoID'];

    // Eliminar el grado y los útiles asociados
    $sqlDeleteGrado = "DELETE FROM Grados WHERE ID = '$gradoID'";
    $sqlDeleteUtiles = "DELETE FROM ListaDeUtiles WHERE GradoID = '$gradoID'";

    if ($conn->query($sqlDeleteGrado) === TRUE && $conn->query($sqlDeleteUtiles) === TRUE) {
        $successMessage = "Se ha eliminado el grado y los útiles asociados.";
    } else {
        $errorMessage = "Al eliminar el grado: " . $conn->error;
    }
}
?>

<div class="container mb-4">
    <h2>Registro de Grados</h2>
    <form action="registro_grados.php" method="POST" class="row g-3">
        <div class="row mb-3 justify-content-center align-items-end">
            <div class="col-md-4">
                <label for="grado" class="form-label">Grado:</label>
                <input type="text" name="grado" id="grado" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success">Registrar Grado</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <h2>Grados Registrados</h2>
            <table class="lista-grados" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" class="table-responsive">
                <thead>
                    <tr>
                        <th class='text-center'>ID</th>
                        <th class='text-center'>Grado</th>
                        <th class='text-center'>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlGrados = "SELECT ID, Grado FROM Grados";
                    $resultGrados = $conn->query($sqlGrados);

                    if ($resultGrados->num_rows > 0) {
                        while ($rowGrado = $resultGrados->fetch_assoc()) {
                            $gradoID = $rowGrado['ID'];
                            $grado = $rowGrado['Grado'];

                            echo "<tr>";
                            echo "<td>$gradoID</td>";
                            echo "<td>$grado</td>";
                            echo "<td>
                                    <a href='registro_grados.php?delete=true&gradoID=$gradoID' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de eliminar este grado y los útiles asociados?\")'>
                                        <i class='bi bi-trash'></i> Eliminar
                                    </a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron grados registrados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('inc/footer.php'); ?>