<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!empty($_POST['inscription'])){
    $inscription = $conn->real_escape_string($_POST['inscription']);
    
    $deleteInscriptionAuxQuery = "call deleteInscriptionAux('$inscription')";
    $deleteInscriptionAuxResult = $conn->query($deleteInscriptionAuxQuery);
    while($deleteInscriptionAux = $deleteInscriptionAuxResult->fetch_assoc()){
        if($deleteInscriptionAux['MSG'] == "ok"){
            echo "Eliminado correctamente!";
        }else{
            echo $deleteInscriptionAux['MSG'];
        }
    }
    
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>