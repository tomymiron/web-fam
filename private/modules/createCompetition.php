<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST['name']) && !empty($_POST['date']) && !empty($_POST['place'])){
    $name = $conn->real_escape_string($_POST['name']);
    $date = $conn->real_escape_string($_POST['date']);
    $place = $conn->real_escape_string($_POST['place']);
    
    $sql = "call newCompetition('$name','$date','$place')";
    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        echo $row['MSG'];
    }
}else{
    echo "Completa todos los campos!";
}
$conn->close();
?>