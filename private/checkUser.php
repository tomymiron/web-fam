<?php
if(!isset($_SESSION['user']) or !isset($_SESSION['pass'])){
    if(isset($_COOKIE['user']) && isset($_COOKIE['pass'])){
        if($_COOKIE['user'] != "" && $_COOKIE['pass'] != ""){
            $cookieUser = mysqli_real_escape_string($conn, $_COOKIE['user']);
            $cookiePass = mysqli_real_escape_string($conn, $_COOKIE['pass']);
            $sql = " select * from  athletes where dni='$cookieUser' and password='$cookiePass' ";
            $query = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($query);
            if($row == 1){
                $_SESSION['user'] = $cookieUser;
                $_SESSION['pass'] = $cookiePass;
            }else{
                header('location: ../login');
            }
        }else{
            header('location: ../login');
        }
    }else{
        header('location: ../login');
    }
}
if($_SESSION['user'] > 100 and $_SESSION['user'] <= 5000){
	header('location: ../club');
}else if($_SESSION['user'] > 5000){
    header('location: ../perfil');
}

$sql = "select * from  athletes where dni = " . $_SESSION['user'];
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($query)){
    $user = $row;
}
?>