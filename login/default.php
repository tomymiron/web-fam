<?php include('../private/database/db.php');?>
<?php
if(!isset($_SESSION['status'])){
    $_SESSION['status'] = "pending";
}
if(!isset($_SESSION['user'])){
    if(isset($_COOKIE['user']) && isset($_COOKIE['pass'])){
        if($_COOKIE['user'] != "" && $_COOKIE['pass'] != ""){
            $cookieUser = mysqli_real_escape_string($conn, $_COOKIE['user']);
            $cookiePass = mysqli_real_escape_string($conn, $_COOKIE['pass']);
            $sql = " select * from  athletes where dni='$cookieUser' and password='$cookiePass' ";
            $query = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($query);
            if($row == 1){
                $_SESSION['user'] = $cookieUser;
                if($_SESSION['user'] <= 100){
                    header('location: ../private');
                }elseif($_SESSION['user'] > 100 and $_SESSION['user'] <= 5000){
                    header('location: ../club');
                }else{
                    header('location: ../perfil');
                }
            }
        }
    }
}
?>

<?php include('../public/pages/header.html'); ?>
<title>LogIn</title>
<style><?php include('../public/resources/css/logIn.css')?></style>
</head>
<body>
<div id="particles-js"></div>

<?php
if($_SESSION['status'] == "wrong"){
    ?>
    <div id="statusMessage"><p>Credenciales incorrectas!</p></div>
    <?php
}
?>
<div class="row" id="mainContainer">
    <svg id="famLogo" class="d-none d-lg-block col-6" width="520" height="520" viewBox="0 0 520 520" fill="none">
        <circle cx="259.675" cy="259.675" r="192.725" stroke="#1A355E" stroke-width="19.5"/>
        <g clip-path="url(#clip0_1_13721)">
            <path d="M222.802 383.168L138.211 215.423C124.239 187.715 144.378 155.005 175.409 155.005L344.591 155.005C375.623 155.005 395.762 187.715 381.789 215.423L297.198 383.168C281.8 413.704 238.201 413.704 222.802 383.168Z" stroke="#1A355E" stroke-width="19.8382"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M236.229 178.681C236.229 177.804 235.519 177.094 234.642 177.094H165.999C157.599 177.094 152.06 185.842 155.654 193.435L233.208 357.304C233.932 358.835 236.229 358.319 236.229 356.625V178.681ZM284.651 354.764C284.651 356.458 286.949 356.974 287.673 355.443L364.346 193.435C367.94 185.842 362.401 177.094 354.001 177.094H286.238C285.362 177.094 284.651 177.804 284.651 178.681V354.764Z" fill="#1A355E"/>
        </g>
        <defs>
            <clipPath id="clip0_1_13721"><rect width="313.444" height="312.65" fill="white" transform="translate(103.35 122.2)"/></clipPath>
        </defs>
    </svg>
    <div class="col-12 col-lg-6" id="contentContainer" novalidate>
        <h1>Bienvenido de nuevo!</h1>
        <form action="../private/modules/loginCheck.php" method="POST" spellcheck="false" novalidate class="needs-validation">
            
            <div class="auxiliar">
                <input class="inputMain" type="number" id="dni" name="dni" placeholder="Ingrese su dni" autocomplete="off" required>
                <p class="invalid-feedback">Por favor, Ingresa tu dni</p>
            </div>
            <div class="auxiliar">
                <input class="inputMain" type="password" id="pass" name="pass" placeholder="Ingrese su contraseña" autocomplete="off" required>
                <div id="buttonHide">
                    <svg id="eye-1" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path d="M22.6562 12.5C22.6562 14.8438 18.1091 19.5312 12.5 19.5312C6.89086 19.5312 2.34375 14.8438 2.34375 12.5C2.34375 10.1562 6.89086 5.46875 12.5 5.46875C18.1091 5.46875 22.6562 10.1562 22.6562 12.5Z" stroke="white" stroke-linejoin="round"/>
                        <path d="M16.4062 12.5C16.4062 14.6574 14.6574 16.4062 12.5 16.4062C10.3426 16.4062 8.59375 14.6574 8.59375 12.5C8.59375 10.3426 10.3426 8.59375 12.5 8.59375C14.6574 8.59375 16.4062 10.3426 16.4062 12.5Z" stroke="white" stroke-linejoin="round"/>
                    </svg>
                    <svg id="eye-2" style="display: none" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path d="M16.4062 12.5C16.4062 14.6574 14.6574 16.4062 12.5 16.4062M8.59375 12.5C8.59375 10.3426 10.3426 8.59375 12.5 8.59375M10.1562 19.2613C10.9086 19.4343 11.6933 19.5312 12.5 19.5312C18.1091 19.5312 22.6562 14.8438 22.6562 12.5C22.6562 11.4559 21.7538 9.94653 20.257 8.59375M15.2344 5.83601C14.3644 5.60246 13.4473 5.46875 12.5 5.46875C6.89086 5.46875 2.34375 10.1562 2.34375 12.5C2.34375 13.5312 3.22393 15.016 4.6875 16.3557M5.46875 19.5312L19.5312 5.46875" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </div>
                <p class="invalid-feedback">Por favor, ingresa tu contraseña</p>
            </div>

            <input type="checkbox" id="remember" name="remember"/>
            <label id="rememberLabel" for="remember" data-bs-toggle="collapse" data-bs-target="#ItemForm1-1"><span>Recordarme</span></label>
            
            <input type="submit" id="submit" value="Login" name="submit">
        </form>
        <a href="">Olvidaste la contraseña?</a>
    </div>
</div>

<script>
(function() {

  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if(!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()

document.getElementById("buttonHide").addEventListener("click", ()=>{
    if(document.getElementById("pass").type == "password"){
        document.getElementById("pass").type = "text";
        document.getElementById("eye-1").style.display = "block";
        document.getElementById("eye-2").style.display = "none";
    }else{
        document.getElementById("pass").type = "password";
        document.getElementById("eye-1").style.display = "none";
        document.getElementById("eye-2").style.display = "block";
    }
});

addEventListener("load", ()=>{
    setTimeout(()=>{
        try{
            document.getElementById("statusMessage").style.height = 0;
        }catch{

        }
    },2000);
});
</script>

<script src="jsdeliver.js"></script>
<script src="threejs.js"></script>
<script src="../public/resources/js/login.js"></script>
<?php include('../public/pages/footer.html');?>