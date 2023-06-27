<?php
require_once('inc/header.php');

// Obtener los datos de los estudiantes y los útiles entregados
$sqlEstudiantes = "SELECT E.ID, E.NombreEstudiante, G.Grado, L.Nombre AS Util, L.Cantidad
                   FROM estudiantes E
                   LEFT JOIN grados G ON E.GradoID = G.ID
                   LEFT JOIN listadeutiles L ON G.ID = L.GradoID";
$resultEstudiantes = $conn->query($sqlEstudiantes);

?>

<div class="container mb-4">
    <h2>Lista de Estudiantes y Útiles Entregados</h2>
    <table class="lista-estudiantes table-responsive" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true">
        <thead>
            <tr>
                <th class="text-center">Nombre del Estudiante</th>
                <th class="text-center">Grado</th>
                <th class="text-center">Útiles Entregados</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Agrega esta función fuera del bucle while
            function obtenerMaterialesFaltantes($estudianteID)
            {
                global $conn;
                $sqlFaltantes = "SELECT L.Nombre AS MaterialFaltante
                                 FROM listadeutiles L
                                 LEFT JOIN utilesestudiante UE ON L.ID = UE.UtilID
                                 WHERE UE.EstudianteID = $estudianteID AND UE.UtilID IS NULL";
                $resultFaltantes = $conn->query($sqlFaltantes);
                $faltantes = array();

                while ($rowFaltantes = $resultFaltantes->fetch_assoc()) {
                    $faltantes[] = $rowFaltantes['MaterialFaltante'];
                }

                return $faltantes;
            }

            // Recorrer los estudiantes y verificar los útiles entregados
            while ($row = $resultEstudiantes->fetch_assoc()) {
                $estudianteID = $row['ID'];
                $nombreEstudiante = $row['NombreEstudiante'];
                $grado = $row['Grado'];
                $util = $row['Util'];
                $cantidad = $row['Cantidad'];

                // Verificar si al estudiante le faltan útiles
                $sqlFaltantes = "SELECT COUNT(*) AS Faltantes
                                FROM utilesestudiante UE
                                WHERE UE.EstudianteID = $estudianteID";
                $resultFaltantes = $conn->query($sqlFaltantes);
                $rowFaltantes = $resultFaltantes->fetch_assoc();
                $faltantes = $rowFaltantes['Faltantes'];

                // Calcular el estado del estudiante
                $estado = ($faltantes > 0) ? "Pendiente" : "Completo";
                $estadoColor = ($faltantes > 0) ? "text-warning" : "text-success";

                // Modifica esta línea en la columna "Estado"
                echo "<tr>";
                echo "<td>$nombreEstudiante</td>";
                echo "<td>$grado</td>";
                echo "<td>$util ($cantidad)</td>";
                echo "<td class='text-center $estadoColor'>";
                if ($estado == "Pendiente") {
                    $faltantes = obtenerMaterialesFaltantes($estudianteID);
                    $faltantesHtml = implode("<br>", $faltantes);
                    echo "<button type='button' class='btn btn-warning' data-bs-toggle='popover' data-bs-placement='top' data-bs-html='true' data-bs-content='$faltantesHtml'>$estado</button>";
                } else {
                    echo $estado;
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>

<?php require_once('inc/footer.php'); ?>