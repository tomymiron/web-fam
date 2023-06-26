<?php
include('../../private/database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$results = array();
$query = "select competitions.name as 'competition', count(inscriptions.ID_inscription) as 'inscriptions' from inscriptions left join events on events.ID_event = inscriptions.ID_event left join competitions on competitions.ID_competition = events.ID_competition group by competitions.ID_competition limit 10;";
$result = $conn->query($query);
while($row = $result->fetch_assoc()){
    $results[$row['competition']] = $row['inscriptions'];
}
echo json_encode($results);