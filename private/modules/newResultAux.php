<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!empty($_POST['newResultDNI']) && !empty($_POST['newResultEvent']) && !empty($_POST['newResultResult'])){
    $newResultDNI = $conn->real_escape_string($_POST['newResultDNI']);
    $newResultEvent = $conn->real_escape_string($_POST['newResultEvent']);
    $newResultResult = $conn->real_escape_string($_POST['newResultResult']);
    $newResultWind = $conn->real_escape_string($_POST['newResultWind']);
    
    $newResultAuxQuery = "call newResultAux('$newResultDNI', '$newResultEvent', '$newResultResult', '$newResultWind')";
    $newResultAuxResult = $conn->query($newResultAuxQuery);
    while($newResultAux = $newResultAuxResult->fetch_assoc()){
        if($newResultAux['MSG'] == "ok"){
            echo "Ingresado correctamente";
        }else{
            echo "Ocurrio un error!";
        }
    }
    
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>