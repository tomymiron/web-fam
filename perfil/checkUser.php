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

if($_SESSION['user'] <= 100){
	header('location: ../private');
}else if($_SESSION['user'] > 100 and $_SESSION['user'] <= 5000){
    header('location: ../club');
}

$sql = "select athletes.ID_athlete, athletes.born, categories.name as 'category', athletes.email, athletes.password, athletes.name, athletes.dni, clubs.name as 'club' from  athletes left join clubs on clubs.ID_club = athletes.ID_club left join categories on 2023 - year(athletes.born) >= categories.minAge and 2023 - year(athletes.born) < categories.limitAge  where athletes.dni = " . $_SESSION['user'] . " and athletes.password = '" . $_SESSION['pass'] . "';";
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($query)){
    $user = $row;
}
?>