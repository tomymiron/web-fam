<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$athletes = $_POST['athletes'];
$athletesDecoded = json_decode($athletes, true);
if(!empty($_POST['event'])){
    $event = $conn->real_escape_string($_POST['event']);
    $wind = $conn->real_escape_string($_POST['wind']);
    
    foreach($athletesDecoded as $index => $value){
        $sendSql = "call logResult('$index', '$event', '$value', '$wind')";
        $resultSend = $conn->query($sendSql);
        while($sendRow = $resultSend->fetch_assoc()){
            if($sendRow['MSG'] != "ok"){
                echo "Algo salio mal :(";
                break;
            }
        }
        mysqli_next_result($conn);
    }
    echo "Actualizado correctamente!";
}else{
    echo "Ocurrio un error!";
}
$conn->close();
?>