<?php
if (isset($_POST))
$title = "Success";
$page = "success";
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
            <a href="index.php"><img class="logo-sm img-responsive img-thumbnail" src="../image/logo.jpg" alt="logo"></a>
        </div>
        <div class="col-xs-6">
            <div class="logo-sm" >
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
        <div class="jumbotron" style="margin: 50px auto 300px;">
            <h1>Success!</h1>
            <p>Contul este aproape creat! </p>
            <p>In scurt timp vei primi un email cu pasii care urmeaza sa-i parcurgi.</p>
            <p>Mult success!!!</p>
        </div>
    </main>
<hr/>
<footer class="container">
    <div class="">
        <p>Copyright &copy; <?= date("Y")?> toate drepturile sunt rezervate de Denis Gandzii pentru socri.</p>
    </div>
</footer>
<script src="../public/js/jquery-3.1.1.min.js"></script>
<script src="../public/js/bootstrap.min.js"></script>
<script src="../public/js/script.js"></script>
</body>
</html>