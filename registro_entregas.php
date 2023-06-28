<?php
require_once('inc/header.php');

// Obtener los datos de los estudiantes y los útiles entregados
$sqlEstudiantes = "SELECT E.ID, E.NombreEstudiante, G.Grado, L.Nombre AS Util, L.Cantidad
                   FROM estudiantes E
                   LEFT JOIN grados G ON E.GradoID = G.ID
                   LEFT JOIN listadeutiles L ON G.ID = L.GradoID";
$resultEstudiantes = $conn->query($sqlEstudiantes);

?>

<div class="container bg-body p-4 mb-4">
    <h2>Lista de entregas por estudiante</h2>
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
            // Recorrer los estudiantes y verificar los útiles entregados
            $currentStudentID = null;
            while ($row = $resultEstudiantes->fetch_assoc()) {
                $estudianteID = $row['ID'];
                $nombreEstudiante = $row['NombreEstudiante'];
                $grado = $row['Grado'];
                $util = $row['Util'];
                $cantidad = $row['Cantidad'];

                // Verificar si es el mismo estudiante que el anterior
                if ($estudianteID === $currentStudentID) {
                    // Agregar el útil entregado al listado
                    echo "<li>$util ($cantidad)</li>";
                } else {
                    // Es un nuevo estudiante, mostrar los datos
                    if ($currentStudentID !== null) {
                        // Cerrar la lista de útiles entregados del estudiante anterior
                        echo "</ul>";

                        // Verificar el estado de los útiles entregados
                        $sqlEstado = "SELECT COUNT(*) AS TotalUtiles
                                      FROM listadeutiles L
                                      WHERE L.GradoID = (SELECT GradoID FROM estudiantes WHERE ID = $currentStudentID)";
                        $resultEstado = $conn->query($sqlEstado);
                        $rowEstado = $resultEstado->fetch_assoc();
                        $totalUtiles = $rowEstado['TotalUtiles'];

                        $sqlEntregados = "SELECT COUNT(*) AS UtilesEntregados
                                          FROM utilesestudiante UE
                                          WHERE UE.EstudianteID = $currentStudentID";
                        $resultEntregados = $conn->query($sqlEntregados);
                        $rowEntregados = $resultEntregados->fetch_assoc();
                        $utilesEntregados = $rowEntregados['UtilesEntregados'];

                        $estado = ($utilesEntregados === $totalUtiles) ? "Completo" : "Pendiente";
                        $estadoColor = ($utilesEntregados === $totalUtiles) ? "text-success" : "text-warning";

                        echo "<td class='text-center $estadoColor'>$estado</td>";
                        echo "</tr>";
                    }

                    $currentStudentID = $estudianteID;

                    // Mostrar los datos del estudiante y los útiles entregados
                    echo "<tr>";
                    echo "<td>$nombreEstudiante</td>";
                    echo "<td>$grado</td>";
                    echo "<td>";
                    echo "<ul class='listado'>";  // Iniciar la lista de útiles entregados
                    echo "<li>$util ($cantidad)</li>";
                }
            }

            // Cerrar la lista de útiles entregados del último estudiante y mostrar el estado
            if ($currentStudentID !== null) {
                echo "</ul>";

                // Verificar el estado de los útiles entregados
                $sqlEstado = "SELECT COUNT(*) AS TotalUtiles
                              FROM listadeutiles L
                              WHERE L.GradoID = (SELECT GradoID FROM estudiantes WHERE ID = $currentStudentID)";
                $resultEstado = $conn->query($sqlEstado);
                $rowEstado = $resultEstado->fetch_assoc();
                $totalUtiles = $rowEstado['TotalUtiles'];

                $sqlEntregados = "SELECT COUNT(*) AS UtilesEntregados
                                  FROM utilesestudiante UE
                                  WHERE UE.EstudianteID = $currentStudentID";
                $resultEntregados = $conn->query($sqlEntregados);
                $rowEntregados = $resultEntregados->fetch_assoc();
                $utilesEntregados = $rowEntregados['UtilesEntregados'];

                $estado = ($utilesEntregados === $totalUtiles) ? "Completo" : "Pendiente";
                $estadoColor = ($utilesEntregados === $totalUtiles) ? "text-success" : "text-warning";

                echo "<td class='text-center $estadoColor'>$estado</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require_once('inc/footer.php'); ?>