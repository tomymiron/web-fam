<?php
include('../database/db.php');

$newImages = $conn->real_escape_string($_POST['newImages']);
$newImagesDecoded = json_decode(stripslashes($newImages));

$deleteImages = $conn->real_escape_string($_POST['deleteImages']);
$deleteImagesDecoded = json_decode(stripslashes($deleteImages));

if(isset($_POST["title"]) && isset($_POST['mainNewImg']) && isset($_POST['subTitle']) && isset($_POST['body']) && isset($_POST['id_new'])){
    $title = $conn->real_escape_string($_POST['title']);
    $subTitle = $conn->real_escape_string($_POST['subTitle']);
    $body = $conn->real_escape_string($_POST['body']);
    $ID_new = $conn->real_escape_string($_POST['id_new']);
    
    $data = $_POST["mainNewImg"];
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
    $imageName = time() . '.png';
    file_put_contents($imageName, $data);
    $image_file = addslashes(file_get_contents($imageName));

    $query = "call updateNews(" . $ID_new . ", '" . $title . "', '" . $subTitle . "', '" . $body . "', '" . $image_file . "')";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        unlink($imageName);
        for($i = 0; $i < count($newImagesDecoded); $i++){
            mysqli_next_result($conn);
            $newImageDecodeAux = $newImagesDecoded[$i];
            $decodeAux1 = explode(";", $newImageDecodeAux);
            $decodeAux2 = explode(",", $decodeAux1[1]);
            $newImageDecodeAux = base64_decode($decodeAux2[1]);
            $decodedAuxName = time() . '.png';
            file_put_contents($decodedAuxName, $newImageDecodeAux);
            $decodedAuxFile = addslashes(file_get_contents($decodedAuxName));

            $uploadSql = "INSERT INTO `newsImg` (`ID_newImg`, `image`, `ID_new`) VALUES (NULL, '" . $decodedAuxFile . "', $ID_new);";
            $uploadQuery = $conn->prepare($uploadSql);
            if($uploadQuery->execute()){
                unlink($decodedAuxName);
            }
        }
        for($i = 0; $i < count($deleteImagesDecoded); $i++){
            mysqli_next_result($conn);
            $deleteSql = "delete from newsImg where newsImg.ID_newImg = " . $deleteImagesDecoded[$i] . ";";
            $deleteQuery = $conn->prepare($deleteSql);
            if($deleteQuery->execute()){
            }
        }
        $response_array['status'] = 'success';
        $response_array['message'] = 'Actualizado correctamente!';
        echo json_encode($response_array);
    }
}else{
    $response_array['status'] = 'error';
    $response_array['message'] = 'Completa todos los campos!';
    echo json_encode($response_array);
}
?>
