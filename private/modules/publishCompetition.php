<?php
include('../database/db.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!empty($_POST['competition'])){
    $competition = $conn->real_escape_string($_POST['competition']);
    
    $sql = "call publishCompetition('$competition')";
    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()) {
        echo $row['MSG'];
    }
}else{
    echo "Completa todos los campos!";
}
$conn->close();
?>