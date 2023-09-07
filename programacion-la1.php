<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,500;0,700;0,900;1,100;1,300;1,500;1,700;1,900&display=swap" rel="stylesheet">
<?php
// Obtener el JSON desde la URL
$json_data = file_get_contents('https://www.rtve.es/api/schedule/tv1.json?pastDays=0&nextDays=7');

// Decodificar el JSON
$data = json_decode($json_data, true);

// Función para formatear el campo "Begin Time"
function formatBeginTime($beginTime) {
    $hour = substr($beginTime, 8, 2);
    $minute = substr($beginTime, 10, 2);
    $second = substr($beginTime, 12, 2);

    return "{$hour}:{$minute}:{$second}";
}

// Función para obtener la fecha (día-mes-año) a partir de "begintime"
function getDateFromBeginTime($beginTime) {
    $year = substr($beginTime, 0, 4);
    $month = substr($beginTime, 4, 2);
    $day = substr($beginTime, 6, 2);

    return "{$day}-{$month}-{$year}";
}

// Obtener el elemento HTML donde se mostrará la tabla
echo '<div id="tabla-container">';

// Inicializar una variable para rastrear la fecha actual
$currentDate = '';

// Inicializar una variable para rastrear si se ha mostrado alguna tabla
$hasTable = false;

// Crear la tabla HTML con estilos CSS
echo '<style>';
echo 'table { border-collapse: collapse; width: 100%; font-family: Roboto;}';
echo 'th, td { padding: 10px; text-align: left; }';
echo 'tr:nth-child(even) { background-color: #f2f2f2; }';
echo 'tr:hover { background-color: #ddd; }';
echo '.date-header { font-family: Roboto; font-size: 20px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; }';
echo '</style>';

// Crear filas de datos
foreach ($data['items'] as $item) {
    $beginTime = $item['begintime'];
    $date = getDateFromBeginTime($beginTime);

    // Check if the time is between 00:00 and 05:59
    $hour = substr($beginTime, 8, 2);
    if ($hour >= '00' && $hour <= '05') {
        // If it's in the early morning, subtract one day from the date
        $date = date('d-m-Y', strtotime($date . ' -1 day'));
    }

    // Verificar si la fecha actual es diferente de la fecha del item actual
    if ($date !== $currentDate) {
        // Si se ha mostrado alguna tabla anteriormente, cerrar la tabla anterior
        if ($hasTable) {
            echo '</table>';
        }

        // Mostrar un título con la fecha al principio de cada día
        echo '<div class="date-header">' . $date . '</div>';
        echo '<table>';
        $currentDate = $date;
        $hasTable = true;
    }

    // Mostrar los detalles del programa
    echo '<tr>';
    echo '<td>';
    echo $item['name'];
    // Mostrar "original_episode_name" en cursiva
    if ($item['original_episode_name'] !== null) {
    echo '<br><i style="font-weight:300;">' . $item['original_episode_name'] . '</i>';
    }
    // Mostrar "episode_number" en letra pequeña si es diferente de 0
    if ($item['episode_number'] !== '0') {
         echo '<br><small style="font-weight:300;">' . $item['episode_number'] . '</small>';
    }
    if ($item['year'] !== null) {
    echo'<br><small style="font-weight:300;">' . $item['year'] . '</small>';
    }
    echo '</td>';
    echo '<td>' . formatBeginTime($beginTime) . '</td>';
    echo '<td style="font-weight:300;">' . $item['description'] . '</td>';
    echo '<td style="font-weight:300;">' . $item['casting'] . '</td>';
    echo '</tr>';
}

// Cerrar la última tabla si se ha mostrado alguna
if ($hasTable) {
    echo '</table>';
}

echo '</div>';
?>
