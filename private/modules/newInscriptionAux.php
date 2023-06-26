<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!empty($_POST['newInscriptionDNI']) && !empty($_POST['newInscriptionCompetition']) && !empty($_POST['newInscriptionEvent'])){
    $newInscriptionDNI = $conn->real_escape_string($_POST['newInscriptionDNI']);
    $newInscriptionCompetition = $conn->real_escape_string($_POST['newInscriptionCompetition']);
    $newInscriptionEvent = $conn->real_escape_string($_POST['newInscriptionEvent']);
    
    $newInscriptionQuery = "call newInscriptionAux('$newInscriptionDNI', '$newInscriptionCompetition', '$newInscriptionEvent')";
    $newInscriptionAuxResult = $conn->query($newInscriptionQuery);
    while($newInscriptionAux = $newInscriptionAuxResult->fetch_assoc()){
        if($newInscriptionAux['MSG'] == "ok"){
            echo "Inscripto correctamente!";
        }else{
            echo $newInscriptionAux['MSG'];
        }
    }
    
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>