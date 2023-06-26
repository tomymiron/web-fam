<?php
include('../private/database/db.php');

if(isset($_POST["image"])){
    $ID_athlete = 1;
    $data = $_POST["image"];
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
    $imageName = time() . '.png';
    file_put_contents($imageName, $data);
    $image_file = addslashes(file_get_contents($imageName));

    $query = "INSERT INTO images(image, ID_athlete) VALUES ('".$image_file."', '" . $ID_athlete . "')";
    $statement = $conn->prepare($query);
    if($statement->execute()){
        echo 'Image save into database';
        unlink($imageName);
    }
}
?>
