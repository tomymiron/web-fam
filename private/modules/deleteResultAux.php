<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!empty($_POST['competitionLog'])){
    $competitionLog = $conn->real_escape_string($_POST['competitionLog']);
    
    $deleteResultAuxQuery = "call deleteResultAux('$competitionLog')";
    $deleteResultAuxResult = $conn->query($deleteResultAuxQuery);
    while($deleteResultAux = $deleteResultAuxResult->fetch_assoc()){
        if($deleteResultAux['MSG'] == "ok"){
            echo "Eliminado correctamente";
        }else{
            echo "Ocurrio un error!";
        }
    }
    
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>