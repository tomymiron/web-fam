<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST['competition'])){
    $competition = $conn->real_escape_string($_POST['competition']);
    $sql = "call deleteAllCompetition('$competition')";
    $conn->query($sql);
    echo "Competencia eliminada correctamente!";
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>