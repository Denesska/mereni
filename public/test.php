<?php
require_once "../includes/layout/session.php";
require_once "../classes/Database.php";
$page = "test";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../includes/function.php";

if (isset($_POST['submit'])){
    $activity = escaped_str($_POST['activity']);
    $now = date("Y-m-d H:i:s");
        $query = "INSERT INTO loc_activitate (locatie, added) VALUES ('$activity', '$now' )";
        $result = Database::getInstance()->getConnection()->query($query);
    if (!$result){
        $_SESSION['message'] = "<br>Eroare la adaugare activitate: ".Database::getInstance()->getConnection()->error;
        $_SESSION['status'] = "danger";
        $_SESSION['icon'] = "exclamation-sign";
        echo status_baloon();
        die("mort!!");
    }
    $_SESSION['message'] = "Activitatea a fost adaugata cu success";
    $_SESSION['status'] = "success";
    $_SESSION['icon'] = "ok";

    echo status_baloon();
}
?>
<main class="container">
    <div class="form">
        <form method="post" name="add_day">
            <div class="panel panel-default">
                <div class="panel-heading overflow-auto ">
                    <label class="h4 control-label" for="add_activity">Adauga activitate noua</label>
                </div>
                <!-- Tabelul principal -->
                <table id="add_activity" class="table">

                    <!-- Continutul tabelului cu angajati si loc activitate -->
                    <thead class="thead-inverse">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Locatie</th>
                    </tr>
                    </thead>
                    <!-- Continutul tabelului cu angajati si loc activitate -->
                    <tbody id="tbody_1">
                    <tr class="tbody input_row" id="1">
                        <td class="row_nr">1</td>
                        <td><input type="text" name="activity" class="form-control" placeholder="Scrie o activitate"></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">
                            <div class="col-lg-12">
                                <button class="btn btn-default btn-success btn-group-justified" type="submit" name="submit" value="submit">Adauga activitatea
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </div>
</main>

<?php require "../includes/layout/bottom_page.php";
?>

