<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: http://localhost/cozagro/public/login.php");
    exit();
}
if ($_SESSION['expire'] < time()) {
    $_SESSION['user'] = null;
    $_SESSION['message'] = "Sesiune expirata:
                            <br> - Au trecut mai mult de 30 min de la ultima vizita, trebuie sa va logati din nou:";
    $_SESSION['icon'] = "glyphicon-exclamtion-sign";
    $_SESSION['status'] = "warning";
    header("Location: http://localhost/cozagro/public/login.php");
    exit();
    //   $_SESSION['message'] =  $now." si expira ".$nows;
    //      print_r($_SESSION);

}
$_SESSION['expire'] = time() + (60 * 60);
require_once "../classes/Database.php" ?>
