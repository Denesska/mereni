<?php
require_once "../includes/layout/session.php";
$title = "Acasă";
$page = "home";
require "../includes/layout/top_page.php";
require "../includes/layout/nav_bar.php";
?>
    <main class="container">
        <?= status_baloon() ?>
               <div class="content col-xs-12 col-md-10 col-lg-8 col-xs-offset-0 col-md-offset-1 col-lg-offset-2">
            <!-- Raport personal-->
            <div class="col-xs-2 col-sm-3 col-lg-2 ">
                <a href="lucru_zi.php"><img class="logo-sm" src="/image/work.png" alt="logo"></a>
            </div>
            <div class="col-sm-8 col-lg-9">
                <div class="">
                    <a href="angajati.php" class="h2">Lista angajati si informatii</a>
                    <p class="text-muted"><i>Aici poti vedea informatii despre fiecare angajat in parte, cat a
                            produs,
                            cat a cheltuit si cat a rpimit pe fiecare luna si inca ceva dar momentan nu stiu exact
                            ce si
                            de asta nu am scris..</i></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <!-- Calendar-->
            <div class="col-xs-2 col-sm-3 col-lg-2 ">
                <a href="calendar.php"><img class="logo-sm" src="/image/calendar.png" alt="logo"></a>
            </div>
            <div class="col-sm-8 col-lg-9">
                <div class="">
                    <a href="calendar.php" class="h1">Calendar si agenda</a>
                    <p class="text-muted"><i>Aici poți adăuga cate un angajat nou. De obicei se adauga la angajare
                            doar. Pentru o funcționalitate
                            mai bună preferabil să dispuneți de toate datele complete la completare.</i></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <!-- Adauga angajat-->
            <div class="col-xs-2 col-sm-3 col-lg-2 ">
                <a href="angajati.php"><img class="logo-sm" src="/image/personal.png" alt="logo"></a>
            </div>
            <div class="col-sm-8 col-lg-9">
                <div class="">
                    <a href="angajat_nou.php" class="h1">Adaugă un angajat nou în baza de date</a>
                    <p class="text-muted"><i>Aici poți adăuga cate un angajat nou. De obicei se adauga la angajare
                            doar. Pentru o funcționalitate mai bună preferabil să dispuneți de toate datele complete
                            la completare.</i></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>