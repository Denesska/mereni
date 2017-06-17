<?php
session_start();
if (isset($_SESSION['user'])){
    header("Location: http://localhost/cozagro/public/index.php");
    exit();
}
$title = "Logare";
$page = "Pagina de logare";
require_once "../includes/layout/top_page.php";
if (isset($_POST["submit"])){
    login($_POST['user'], $_POST['pass']);
}?>
    <main class="container" style="margin: 60px auto 140px; ">
        <?= status_baloon()?>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" id="login">
                        <label for="login">Logheazate pentru continuare:</label>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                            <fieldset>
                                <div class="row">
                                    <div class="center-block">
                                        <img class="profile-img"
                                             src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <div class="form-group">
                                            <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
                                                <input class="form-control" placeholder="Username" name="user" type="text" autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
                                                <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Logare">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="panel-footer ">
                        Daca nu ai un cont: <a href="register.php" onClick=""> Da click aici!</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

<?php require "../includes/layout/bottom_page.php" ?>