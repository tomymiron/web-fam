<?php
include('../database/db.php');
if(isset($_POST['submit'])){
	$dni = mysqli_real_escape_string($conn, $_POST['dni']);
	$password = mysqli_real_escape_string($conn, $_POST['pass']);
	if(isset($_POST['remember'])){
		$remember = 1;
	}else{
		$remember = 0;
	}
	
	$sql = " select * from  athletes where dni='$dni' and password='$password' ";
	$query = mysqli_query($conn,$sql);
	$row = mysqli_num_rows($query);

	if($row == 1){
		$_SESSION['status'] = "success";
		$_SESSION['user'] = $dni;
		$_SESSION['pass'] = $password;
		if($remember == 1){
			setcookie('user', $dni,time() + (365 * 24 * 60 * 60), '/');
    		setcookie('pass', $password,time() + (365 * 24 * 60 * 60), '/');   
		}
		if($dni <= 100){
			header('Location: ../');
		}elseif($dni > 100 and $dni <= 5000){
			header('Location: ../../club');
		}else{
			header('Location: ../../perfil');
		}

	}else{
		$_SESSION['status'] = "wrong";
		header('Location: ../../login');
	}
}
?>