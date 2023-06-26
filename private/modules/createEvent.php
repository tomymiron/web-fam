<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$categories = $conn->real_escape_string($_POST['categories']);
$categoriesDecoded = json_decode(stripslashes($categories));
if(!empty($_POST['competition']) && !empty($_POST['time']) && !empty($_POST['discipline']) && count($categoriesDecoded) > 0){
    $competition = $conn->real_escape_string($_POST['competition']);
    $time = $conn->real_escape_string($_POST['time']);
    $discipline = $conn->real_escape_string($_POST['discipline']);
    $gender = $conn->real_escape_string($_POST['gender']);
    
    $eventID;
    $sql = "call newEvent('$discipline','$competition','$time','$gender')";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $eventID = $row['MSG'];
    }
    mysqli_next_result($conn);
    for($i = 0; $i < count($categoriesDecoded); $i++){
        $setSql = "call setEventCategory('$categoriesDecoded[$i]', '$eventID')";
        $resultSet = $conn->query($setSql);
        while($setCategoryItem = $resultSet->fetch_assoc()) {
            if($setCategoryItem['MSG'] != "ok"){
                echo "Algo salio mal :(";
                break;
            }
        }
        mysqli_next_result($conn);
    }
    echo "Evento creado correctamente!";

}else{
    echo "Completa todos los campos!";
}
$conn->close();
?>