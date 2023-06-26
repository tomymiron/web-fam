<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$eventsToInscript = $conn->real_escape_string($_POST['eventsToInscript']);
$eventsToInscriptDecoded = json_decode(stripslashes($eventsToInscript));
if(count($eventsToInscriptDecoded) > 0 && !empty($_POST['competition']) && !empty($_POST['athlete'])){

    $competition = $conn->real_escape_string($_POST['competition']);
    $athlete = $conn->real_escape_string($_POST['athlete']);

    for($i = 0; $i < count($eventsToInscriptDecoded); $i++){
        $inscriptionSql = 'call newInscription2( '.$athlete.','.$eventsToInscriptDecoded[$i].','.$competition.' )';
        $result = $conn->query($inscriptionSql);
        while($resultItem = $result->fetch_assoc()) {
            if($resultItem['MSG'] != "ok"){
                echo "Algo salio mal :(";
                break;
            }
        }
        mysqli_next_result($conn);
    }
    echo "Inscripcion realizada con exito!";

}else{
    echo "Seleccione una prueba";
}
$conn->close();
?>