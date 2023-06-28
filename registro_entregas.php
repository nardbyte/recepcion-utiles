<?php
require_once('inc/header.php');

// Obtener los datos de los estudiantes y los útiles entregados
$sqlEstudiantes = "SELECT E.ID, E.NombreEstudiante, G.Grado, L.Descripcion AS Util, L.Cantidad
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
                <th class="text-center">Útiles Faltantes</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $studentsData = array();

            while ($row = $resultEstudiantes->fetch_assoc()) {
                $estudianteID = $row['ID'];
                $nombreEstudiante = $row['NombreEstudiante'];
                $grado = $row['Grado'];
                $util = $row['Util'];
                $cantidad = $row['Cantidad'];

                if (!isset($studentsData[$estudianteID])) {
                    // Inicializar los datos del estudiante
                    $studentsData[$estudianteID] = array(
                        'nombre' => $nombreEstudiante,
                        'grado' => $grado,
                        'entregados' => array(),
                        'faltantes' => array(),
                    );
                }

                // Obtener la cantidad de útiles entregados para el estudiante actual
                $sqlEntregados = "SELECT COUNT(*) AS UtilesEntregados
                                  FROM utilesestudiante UE
                                  WHERE UE.EstudianteID = $estudianteID
                                  AND UE.UtilID IN (SELECT ID FROM listadeutiles WHERE Descripcion = '$util')";
                $resultEntregados = $conn->query($sqlEntregados);
                $rowEntregados = $resultEntregados->fetch_assoc();
                $utilesEntregadosCount = $rowEntregados['UtilesEntregados'];

                // Calcular la cantidad de útiles faltantes para el estudiante actual
                $utilesFaltantesCount = $cantidad - $utilesEntregadosCount;

                if ($utilesEntregadosCount > 0) {
                    $studentsData[$estudianteID]['entregados'][] = "$util ($utilesEntregadosCount)";
                }

                if ($utilesFaltantesCount > 0) {
                    $studentsData[$estudianteID]['faltantes'][] = "$util ($utilesFaltantesCount)";
                }
            }

            // Mostrar los datos de los estudiantes
            foreach ($studentsData as $student) {
                $nombreEstudiante = $student['nombre'];
                $grado = $student['grado'];
                $utilesEntregados = implode('<br>', $student['entregados']);
                $utilesFaltantes = implode('<br>', $student['faltantes']);
                $estado = empty($student['faltantes']) ? '<span class="text-success">Completo</span>' : '<span class="text-warning">Faltantes</span>';

                echo "<tr>";
                echo "<td>$nombreEstudiante</td>";
                echo "<td>$grado</td>";
                echo "<td>$utilesEntregados</td>";
                echo "<td>$utilesFaltantes</td>";
                echo "<td class='text-center'>$estado</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require_once('inc/footer.php'); ?>