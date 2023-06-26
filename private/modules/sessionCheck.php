<?php
if(!isset($_SESSION['user'])){
    if(isset($_COOKIE['pass']) && isset($_COOKIE['pass'])){
        if($_COOKIE['user'] != "" && $_COOKIE['pass'] != ""){
            $cookieUser = mysqli_real_escape_string($conn, $_COOKIE['user']);
            $cookiePass = mysqli_real_escape_string($conn, $_COOKIE['pass']);
            $sql = " select * from  athletes where dni='$cookieUser' and password='$cookiePass' ";
            $query = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($query);
            if($row == 1){
                $_SESSION['user'] = $cookieUser;
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
if($_SESSION['user'] <= 100){
	header('location: ..');
}
?>