<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 07-Jun-17
 * Time: 12:10 PM
 */
if (isset($_POST['submit'])) {
    $alert["message"] = null;
    $errors = null;
    foreach ($_POST as $key => $value) {
        if ($value == "") {
            $status[$key] = "has-error";
            $status_icon[$key] = " glyphicon-warning-sign ";
            $errors = 1;
        } else {
            $status[$key] = "has-success";
        }
        $$key = test_input($value);
    }
    $user = validate_string($user);
    $user_name = validate_string($user_name);
    $user_surname = validate_string($user_surname);
    if (email_format($email) === false) {
        $errors['email'] = "<br>adresa de email este gresita";
    }
    if (!$errors) {
        if (($pass !== $pass_con) OR (empty($pass) or empty($pass_con))) {
            $status['pass'] = "has-error";
            $status['pass_con'] = "has-error";
        }else{
            $pass = password_hash($pass, PASSWORD_DEFAULT);
        }
        $query = "SELECT user FROM login WHERE user='$user' LIMIT 1";
        $result = Database::getInstance()->getConnection()->query($query);
        if (!$result) {
            $status_text = Database::getInstance()->getConnection()->error;
            ?>
            <p id="status_baloon" class="bg-danger alert h3 container"><?= $status_text ?></p> <?php
            die();
        }
        if (Database::getInstance()->getConnection()->affected_rows == 1) {
            $alert["message"] .= "<br>- exista un utilizator cu acest nume!";
            $status['user'] = "has-error";
            $errors = 2;
        }
        $query = "SELECT email FROM login WHERE email='$email' LIMIT 1";
        $result = Database::getInstance()->getConnection()->query($query);
        if (!$result) {
            $status_text = Database::getInstance()->getConnection()->error;
            ?>
            <p id="status_baloon" class="bg-danger alert h3 container"><?= $status_text ?></p> <?php
            die();
        }
        if (Database::getInstance()->getConnection()->affected_rows == 1) {
            $alert["message"] .= "<br>- exista un utilizator cu aceasta adresa de email!";
            $status['email'] = "has-error";
            $errors = 3;
        }
        if (!$errors) {
            $query = "INSERT INTO `login`(`name`, `surname`, `user`, `email`, `hash`, `pin`) VALUES ('$user_surname', '$user_name', '$user', '$email', '$pass', 1111)";
            $result = (Database::getInstance()->getConnection()->query($query));
            if (!$result) {
                $status_text = Database::getInstance()->getConnection()->error;
                ?>
                <p id="status_baloon" class="bg-danger alert h3 container"><?= $status_text ?></p> <?php
                die();
            }
            header("Location: http://localhost/cozagro/public/success.php");
            exit();
        }
        $alert["status"] = "danger";
        $alert["icon"] = "exclamation-sign";
    } else {
        $alert["message"] = "A aparut o eroare la crearea contului!";
        $alert["message"] .= " Nu au fost completate unul sau mai multe campuri!";
        $alert["status"] = "danger";
        $alert["icon"] = "exclamation-sign";
    }
}