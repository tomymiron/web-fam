<?php
setcookie('user', '',time() + (365 * 24 * 60 * 60), '/');
setcookie('pass', '',time() + (365 * 24 * 60 * 60), '/');
session_start();
session_destroy();
sleep(.4);
header('Location: ../../');
?>