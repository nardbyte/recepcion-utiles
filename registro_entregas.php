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
    <table class="lista-estudiantes table-responsive" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-click-to-select="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-side-pagination="client">
        <thead>
            <tr>
                <th class="text-center" data-field="estudiante" data-filter-control="input" data-sortable="true">Estudiante</th>
                <th class="text-center" data-field="grado" data-filter-control="input" data-sortable="true">Grado</th>
                <th class="text-center" data-field="entregados" data-filter-control="input" data-sortable="true">Útiles Entregados</th>
                <th class="text-center" data-field="faltantes" data-filter-control="input" data-sortable="true">Útiles Faltantes</th>
                <th class="text-center" data-field="estado" data-filter-control="input" data-sortable="true">Estado</th>
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
                $cantidadRequerida = $row['Cantidad'];

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
                $sqlEntregados = "SELECT SUM(UE.Cantidad) AS UtilesEntregados
                                  FROM utilesestudiante UE
                                  INNER JOIN listadeutiles L ON UE.UtilID = L.ID
                                  WHERE UE.EstudianteID = $estudianteID
                                  AND L.Nombre = '$util'
                                  AND L.GradoID = (SELECT ID FROM grados WHERE Grado = '$grado')";
                $resultEntregados = $conn->query($sqlEntregados);
                $rowEntregados = $resultEntregados->fetch_assoc();
                $utilesEntregadosCount = $rowEntregados['UtilesEntregados'];

                // Calcular la cantidad de útiles faltantes para el estudiante actual
                $utilesFaltantesCount = $cantidadRequerida - $utilesEntregadosCount;
                $utilesFaltantesCount = ($utilesFaltantesCount > 0) ? $utilesFaltantesCount : 0;

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
                $estado = (empty($student['faltantes'])) ? '<span class="text-success">Completo</span>' : '<span class="text-warning">Faltantes</span>';

                // Verificar si no hay útiles faltantes
                $mensaje = (empty($student['faltantes'])) ? '<span class="text-success">No hay pendientes</span>' : $utilesFaltantes;

                echo "<tr>";
                echo "<td>$nombreEstudiante</td>";
                echo "<td>$grado</td>";
                echo "<td>$utilesEntregados</td>";
                echo "<td>$mensaje</td>";
                echo "<td class='text-center'>$estado</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require_once('inc/footer.php'); ?>