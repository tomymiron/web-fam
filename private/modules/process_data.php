<?php
$conn = mysqli_connect('localhost', 'root', '', 'famdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST['title']) && !empty($_POST['title']) && !empty($_POST['title'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $Desc = $conn->real_escape_string($_POST['desc']);
    $query = "INSERT INTO `data_sample`( `name`, `author`, `description`)
         VALUES ('$title','$author','$Desc')";
    if ($conn->query($query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
} else {
    echo "Warning! fill all input fields";
}
$conn->close();
?>
