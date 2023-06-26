<?php
include('../private/database/db.php');

if(isset($_POST["description"]) && isset($_POST['place']) && isset($_POST['president']) && isset($_POST['dniClub']) && isset($_POST['password'])){
    $description = $conn->real_escape_string($_POST['description']);
    $place = $conn->real_escape_string($_POST['place']);
    $president = $conn->real_escape_string($_POST['president']);
    $dniClub = $conn->real_escape_string($_POST['dniClub']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "call updateClub($dniClub, '$password', '$description', '$place', '$president')";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        if($row['MSG'] == "ok"){
            $response_array['status'] = 'success';
            $response_array['message'] = 'Actualizado correctamente!';
        }else{
            $response_array['status'] = 'error';
            $response_array['message'] = $row['MSG'];
        }
        echo json_encode($response_array);
    }
}else{
    $response_array['status'] = 'error';
    $response_array['message'] = 'Completa todos los campos!';
    echo json_encode($response_array);
}
?>
