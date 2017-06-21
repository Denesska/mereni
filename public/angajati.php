<?php
require_once "../includes/layout/session.php";
$title = "Angajati";
$page = "angajati";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../includes/function.php";
?>
    <main class="container">
        <?= status_baloon();?>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading"><p class="h4">Lista angajatilor si detaliile despre ei: </p></div>
                <div class="list-menu list-group col-xs-4 col-sm-3 col-md-2">
                    <?php
                    $employees = select_all_employee();
                    echo display_list_emp($employees);
                    ?>
                </div>
                <div class="content col-xs-8 col-sm-9 col-md-10">
                    <?php display_emp_personal_data(); ?>
                </div>
                <div class="content col-xs-8 col-sm-9 col-md-10" id="for_replace">

                </div>
            </div>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php";
if (isset($_GET['id'])) {
    echo "<script>displayActivityTabs(0)</script>";
} ?>