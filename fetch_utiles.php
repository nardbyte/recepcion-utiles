<?php
require_once('inc/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['gradoID'])) {
    $gradoID = $_GET['gradoID'];

    // Obtener los útiles para el grado seleccionado
    $sqlUtiles = "SELECT ID, Nombre, Descripcion FROM ListaDeUtiles WHERE GradoID = $gradoID";
    $resultUtiles = $conn->query($sqlUtiles);

    if ($resultUtiles->num_rows > 0) {
        $utilesContainer = '<h2>Listado de Útiles:</h2>';

        while ($rowUtil = $resultUtiles->fetch_assoc()) {
            $utilID = $rowUtil['ID'];
            $nombre = $rowUtil['Nombre'];
            $descripcion = $rowUtil['Descripcion'];

            $utilesContainer .= '<div class="form-check">';
            $utilesContainer .= '<input class="form-check-input" type="checkbox" name="utiles[]" value="' . $utilID . '" id="util_' . $utilID . '">';
            $utilesContainer .= '<label class="form-check-label" for="util_' . $utilID . '">' . $nombre . ' - ' . $descripcion . '</label>';
            $utilesContainer .= '</div>';
            $utilesContainer .= '<div class="mb-3">';
            $utilesContainer .= '<label for="cantidad_' . $utilID . '" class="form-label">Cantidad:</label>';
            $utilesContainer .= '<input type="number" name="cantidad_' . $utilID . '" id="cantidad_' . $utilID . '" class="form-control" value="1" min="1">';
            $utilesContainer .= '</div>';
        }

        echo $utilesContainer;
    } else {
        echo '<p>No se encontraron útiles para este grado.</p>';
    }
}
