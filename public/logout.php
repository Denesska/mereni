<?php

session_start();
$_SESSION['user'] = null;
$_SESSION['status'] = "success";
$_SESSION['message'] = "Ai fost delogat cu success!";
$_SESSION['icon'] = "glyphicon-off";
if (isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time()-42000, '/');
}
header("Location: /login.php");
exit();