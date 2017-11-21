<?php
$url = 'http://127.0.0.1/api/compartment/read.php';
$json = file_get_contents($url);
$result = json_decode($json);
if (count($result->records)) {
    echo '<table border=1>';
    echo '<tr>';
    foreach ($result->records as $idx => $value) {
        echo "<th>$value->comp_id</th>";
    }
    echo '</tr>';
    echo '<tr>';
    foreach ($result->records as $idx => $value) {
        echo "<td>$value->status</td>";
    }
    echo '</tr>';
    echo '</table>';
}
