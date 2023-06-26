<?php
include('../database/db.php');

if(isset($_POST['id_new'])){
    $ID_new = $conn->real_escape_string($_POST['id_new']);
    
    $deleteSql = "delete from newsimg where newsimg.ID_new = " . $ID_new . ";";
    $deleteQuery = $conn->prepare($deleteSql);
    if($deleteQuery->execute()){
        mysqli_next_result($conn);
        $deleteSql2 = "delete from news where news.ID_new = " . $ID_new . ";";
        $deleteQuery2 = $conn->prepare($deleteSql2);
        if($deleteQuery2->execute()){
            $response_array['status'] = 'success';
            $response_array['message'] = 'Eliminado correctamente';
            echo json_encode($response_array);
        }
    }
        
}else{
    $response_array['status'] = 'error';
    $response_array['message'] = 'Ocurrio un error!';
    echo json_encode($response_array);
}
?>
