<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST['event'])){
    $event = $conn->real_escape_string($_POST['event']);
    $sql = "call deleteEvent('$event')";
    $conn->query($sql);
    echo "Evento eliminado correctamente!";
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>