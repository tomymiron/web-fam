<?php
include('../private/database/db.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$output = '<div class="row">';

$sql = "SELECT * FROM images";
$query = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($query)){
    $output .= '
        <div class="col-md-2" style="margin-bottom:16px;">
            <img src="data:image/png;base64,'.base64_encode($row['image']).'" class="img-thumbnail" />
        </div>
    ';
}

$output .= '</div>';
echo $output;
?>
