<?php
session_start();
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 31-May-17
 * Time: 9:16 PM
 */
$title = "Inregistrare";
$page = "register";
$status_icon['user_name'] = $status_icon['user'] = $status_icon['email'] = $status_icon['pass'] = $status_icon['pass_con'] = "";
require_once "../classes/Database.php";
require_once "../includes/function.php";
require_once "../includes/add_user.php";
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap3.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/login.css">
        <title><?= $title ?></title>
    </head>
<body>
<header class="bgimage">
    <div class="container">
        <div class="col-xs-5 col-xs-offset-1">
            <a href="index.php"><img class="logo-sm img-responsive img-thumbnail" src="../image/logo.jpg"
                                     alt="logo"></a>
        </div>
        <div class="col-xs-6">
            <div class="logo-sm">
            </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <div class="widget">
                    <p id="time"></p>
                </div>
            </div>
            <div class="row">
                <div class="widget">
                    <p id="date"></p>
                </div>
            </div>
        </div>
    </div>
</header>
<hr/>

<main class="container">
    <?php if (isset($_POST["submit"])) {
        ; ?>
        <div style="margin-bottom: -52px;" class="alert alert-<?= $alert['status']; ?>" role="alert"
             onclick="removeStatus(this)" id="baloon">
            <span class="glyphicon glyphicon-<?= $alert['icon']; ?>" aria-hidden="true"></span>
            <?php if ($errors) {
                echo "A aparut o eroare la creare contului:";
            }
            echo $alert["message"];
            print_r($errors) ?>
            <span class="sr-only">Error:</span>
        </div>
    <?php } ?>
    <div class="panel  panel-default" style="max-width: 720px; margin: 100px auto;">
        <div class="panel-heading" id="panel">
            <label for="panel">Inregistrare utilizator</label></div>
        <form class="form-horizontal" action='<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="POST">
            <div class="form-group" style="margin: 20px auto;">
                <!-- Prenume, Nume -->
                <div class="form-group <?php if (isset($_POST['submit'])) {
                    echo $status['user_surname'];
                } ?>">
                    <!-- Username -->
                    <label class="control-label col-xs-12 col-sm-3" for="username">Prenume, Nume:</label>
                    <div class="controls col-xs-12 col-sm-4">
                        <input type="text" id="user_surname" name="user_surname" placeholder="Prenume"
                               class="form-control <?php if (isset($status['user_surname'])) {
                                   echo $status['user_surname'];
                               } ?>"
                               value="<?php if (isset($user_surname)) {
                                   echo $user_surname;
                               } ?>">
                        <p class="help-block text-muted h6"><i>Se accepta doar litere</i></p>
                    </div>
                    <div class="controls col-xs-12 col-sm-4">
                        <input type="text" id="user_name" name="user_name" placeholder="Nume"
                               class="form-control <?php if (isset($status['user_name'])) {
                                   echo $status['user_name'];
                               } ?>"
                               value="<?php if (isset($user_name)) {
                                   echo $user_name;
                               } ?>">
                        <p class="help-block text-muted h6"><i>Doar litere</i></p>
                    </div>
                    <span class="col-sm-1 glyphicon <?= $status_icon['user_name']; ?>"></span>
                </div>
                <!-- Nume utilizator -->
                <div class="form-group <?php if (isset($_POST['submit'])) {
                    echo $status['user'];
                } ?>">
                    <!-- Username -->
                    <label class="col-xs-12 col-sm-3 control-label" for="username">Ultilizator:</label>
                    <div class="controls col-xs-12 col-sm-8">
                        <input type="text" id="user" name="user" placeholder="Nume utilizator"
                               class="form-control <?php if (isset($status['user'])) {
                                   echo $status['user'];
                               } ?>"
                               value="<?php if (isset($user)) {
                                   echo $user;
                               } ?>">
                        <p class="help-block text-muted h6"><i>Numele de ultilizator poate contine doar litere fara
                                spatii</i></p>
                    </div>
                    <span class="col-sm-1 glyphicon <?= $status_icon['user']; ?>"></span>
                </div>
                <!-- Email -->
                <div class="form-group <?php if (isset($_POST['submit'])) {
                    echo $status['email'];
                } ?>">
                    <!-- E-mail -->
                    <label class="control-label col-xs-12 col-sm-3" for="email">Adresa e-mail:</label>
                    <div class="controls col-xs-12 col-sm-8">
                        <input type="email" id="email" name="email" placeholder="Adresa email"
                               class="form-control <?php if (isset($status['email'])) {
                                   echo $status['email'];
                               } ?>"
                               value="<?php if (isset($email)) {
                                   echo $email;
                               } ?>">
                        <p class="help-block  h6"><i>Pentru inregistrare este nevoie de adresa de e-mail</i></p>
                    </div>
                    <span class="col-sm-1 glyphicon <?= $status_icon['email']; ?>"></span>
                </div>
                <!-- Parola initiala -->
                <div id="pass_field" class="form-group <?php if (isset($_POST['submit'])) {
                    echo $status['pass'];
                } ?>">
                    <!-- Password-->
                    <label class="control-label col-xs-12 col-sm-3" for="password">Parola:</label>
                    <div class="controls col-xs-12 col-sm-8">
                        <input type="password" id="pass" name="pass" placeholder="Parola"
                               class="form-control <?php if (isset($status['pass'])) {
                                   echo $status['pass'];
                               } ?>">
                        <p class="help-block  h6"><i>Parola trebuie sa contine cel putin 6 caractere</i></p>
                    </div>
                    <span class="pass-icon col-sm-1 glyphicon"></span>
                </div>
                <!-- Confirmare parola -->
                <div id="pass_con_field" class="form-group <?php if (isset($_POST['submit'])) {
                    echo $status['pass_con'];
                } ?>">
                    <!-- Password -->
                    <label class="control-label col-xs-12 col-sm-3" for="pass_con">Confirma parola:</label>
                    <div class="col-xs-12 col-sm-8">
                        <input type="password" id="pass_con" name="pass_con"
                               placeholder="Parola pentru confirmare"
                               class="form-control <?php if (isset($status['submit'])) {
                                   echo $status['pass_con'];
                               } ?>" onblur="checkPass()">
                        <p class="help-block h6" id="pass_err"><i>Reintroduceti parola pentru confirmare</i></p>
                    </div>
                    <span class=" pass-icon col-sm-1 glyphicon"></span>
                </div>
                <!-- Submint button sau foc la ghete -->
                <div class="form-group ">
                    <!-- Button -->
                    <div class="controls col-xs-12">
                        <button id="submit_butt" type="submit" name="submit" class="btn btn-success btn-group-justified"
                                value="submit" disabled>
                            Foc la ghete!
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<?php require "../includes/layout/bottom_page.php" ?>