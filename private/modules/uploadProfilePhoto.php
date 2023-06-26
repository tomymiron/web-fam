<?php
include('../database/db.php');

if(isset($_POST["image"]) && isset($_POST['ID_athlete']) && isset($_POST['password'])){
    $ID_athlete = $conn->real_escape_string($_POST['ID_athlete']);
    $password = $conn->real_escape_string($_POST['password']);
    
    $sql = "select ID_athlete from athletes where password = '" . $password . "' and ID_athlete = '" . $ID_athlete . "'";
    $result = $conn->query($sql);
    if(mysqli_num_rows($result) > 0){
        $data = $_POST["image"];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = time() . '.png';
        file_put_contents($imageName, $data);
        $image_file = addslashes(file_get_contents($imageName));
    
        $query = "call newProfilePhoto('".$image_file."', '" . $ID_athlete . "')";
        $statement = $conn->prepare($query);
        if($statement->execute()){
            echo 'Actualizada correctamente!';
            unlink($imageName);
        }
    }
}else{
    echo 'Ocurrio un error';
}
?>
