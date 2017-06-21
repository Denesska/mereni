<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/css/bootstrap3.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/login.css">
    <title><?= $title ?></title>
</head>
<?php
require_once "../includes/function.php";
?>
<body>
<!-- Imagine header  -->
<header class="bgimage">
    <div class="container">
        <!-- Logo organizatie -->
        <div class="col-xs-5 col-xs-offset-1">
            <a href="index.php"><img class="logo-sm img-responsive img-thumbnail" src="/image/logo.jpg"
                                     alt="logo"></a>
        </div>
        <!-- Afiseaza ora -->
        <div class="col-xs-3">
            <div class="row">
                <div class="widget">
                    <p id="time"></p>
                </div>
            </div>
            <!-- Afiseaza data -->
            <div class="row">
                <div class="widget">
                    <p id="date"></p>
                </div>
            </div>
        </div><?php if(isset($_SESSION['user'])){?>
            <p style="float: right; margin-top: 100px; color: white;">Buna <?= $_SESSION['user']; ?>&nbsp;&nbsp;
                <br> <a class="white" href="/logout.php"> Delogare</a></p>
        <?php } ?>
    </div>
</header>
<hr/>