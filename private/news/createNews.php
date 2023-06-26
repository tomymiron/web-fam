<?php
include('../database/db.php');

$newImages = $conn->real_escape_string($_POST['newImages']);
$newImagesDecoded = json_decode(stripslashes($newImages));

if(isset($_POST["title"]) && isset($_POST['mainNewImg']) && isset($_POST['subTitle']) && isset($_POST['body'])){
    $title = $conn->real_escape_string($_POST['title']);
    $subTitle = $conn->real_escape_string($_POST['subTitle']);
    $body = $conn->real_escape_string($_POST['body']);
    
    $data = $_POST["mainNewImg"];
    $image_array_1 = explode(";", $data);
    $image_array_2 = explode(",", $image_array_1[1]);
    $data = base64_decode($image_array_2[1]);
    $imageName = time() . '.png';
    file_put_contents($imageName, $data);
    $image_file = addslashes(file_get_contents($imageName));

    $query = "call newNews('" . $title . "', '" . $subTitle . "', '" . $body . "', '" . $image_file . "')";
    $statement = $conn->prepare($query);
    if($statement->execute()){
        unlink($imageName);
        for($i = 0; $i < count($newImagesDecoded); $i++){
            $data = $newImagesDecoded[$i];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $imageName = time() . '.png';
            file_put_contents($imageName, $data);
            $image_file = addslashes(file_get_contents($imageName));
            $query = "INSERT INTO `newsImg` (`ID_newImg`, `image`, `ID_new`) VALUES (NULL, '" . $image_file . "', (select news.ID_new from news order by news.ID_new DESC limit 1));";
            $statement = $conn->prepare($query);
            if($statement->execute()){
                unlink($imageName);
                continue;
            }
        }
        $sql = "select news.ID_new from news order by news.ID_new DESC limit 1;";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($result)){
            $response_array['status'] = 'success';
            $response_array['message'] = $row['ID_new'];
        }
        echo json_encode($response_array);
    }
}else{
    $response_array['status'] = 'error';
    $response_array['message'] = 'Completa todos los campos!';
    echo json_encode($response_array);
}

?>
