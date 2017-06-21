<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 07-Jun-17
 * Time: 5:53 PM
 */


if (isset($_POST['submit'])){
    $user = test_input($_POST['user']);
    $pass = test_input($_POST['pass']);
    $query = "SELECT * FROM login WHERE user='$user' AND BINARY parola='$pass' LIMIT 1";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        $status_text = Database::getInstance()->getConnection()->error;
        ?>
        <p id="status_baloon" class="bg-danger alert h3"><?= $status_text ?></p> <?php
        die();
    }
    if (Database::getInstance()->getConnection()->affected_rows ==1){
        setcookie('user', $user, time()+3600);
        session_start();
        $_SESSION['user'] = ucfirst($user);
        $_SESSION['time'] = time();
        header('Location: http://localhost/cozagro/public/index.php');
        exit();
    }else{
        $status_text = "Numele de utilizator sau parola sunt incorecte";
        $status_type = "danger"; ?>
        <p id="status_baloon" class="bg-<?= $status_type ?> alert h3"><?= $status_text ?></p>
        <?php
    }
}