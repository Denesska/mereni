<?php
require_once "../includes/layout/session.php";
$title = "Achitare salarii";
$page = "achitare_nou";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../includes/for_ajax.php";
$i = 0;
require_once "../includes/add_payment.php";

$total = data_from_lichidari();
?>
    <main class="container">
        <div class="panel panel-default">
            <div class="panel-heading overflow-auto ">
                <label class="h4 control-label float-left" for="data_work">Introdu salariile angajatilor, daca este cazul alege o data : </label>
                <div class="col-sm-5 col-md-4 col-lg-3 form-group">
                    <input type="date" name="achitare_date" id="data_work" class="form-control"
                           value="<?php if (isset($_GET["data"])) {
                               echo $_POST["achitare_date"];
                           } else {
                               echo date("Y-m-d");
                           } ?>" title="">
                </div>
            </div>
            <form method="post" name="salarii">
                <table id="" class="table table-striped">
                    <thead class="thead-inverse tbl-accordion-section" onclick=toggleClass(this)>
                    <tr>
                        <th colspan="7">Plata salariilor :</th>
                        </td></tr>
                    </thead>
                    <tbody class="">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Nume prenume</th>
                        <th>Suma dorita pentru plata</th>
                        <th>Produs</th>
                        <th>Cumparat</th>
                        <th>Restant</th>
                        <th>Rest de plata</th>
                    </tr>
                    <?php $z = 0;
                    foreach ($total as $key => $row) {
                        $z++ ?>
                        <tr class="thead">
                            <td class="">
                                <!-- Lista angajatilor din lichidare -->
                                <?= $z; ?>
                            </td>
                            <td class="">
                                <div class="" role="alert">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    <?= " " . $row['num']; ?>
                                </div>
                            </td>
                            <td class="">
                                <div class="input-group" role="group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" name="data[<?= $key; ?>][check]"
                                               onclick="clickForEnable(this)" checked></span>
                                    <input type="number" class="form-control" name="data[<?= $key; ?>][pla]"
                                           placeholder="Debifeaza pentru activare" value="" disabled>
                                    <input type="number" name="data[<?= $key; ?>][dif]" style="display: none; "
                                           value="<?= $row['dif']; ?>"></div></td>
                            <td class="">
                                <input type="number" class="form-control" name="data[<?= $key; ?>][sal]"
                                       placeholder="Debifeaza pentru activare" value="<?= $row['sal']; ?>"
                                       style="display: none; ">
                                <?= $row['sal']; ?> MDL
                            </td>
                            <td class="">
                                <input type="number" class="form-control" name="data[<?= $key; ?>][cre]"
                                       placeholder="Debifeaza pentru activare" value="<?= $row['cre']; ?>"
                                       style="display: none; ">
                                <?= $row['cre']; ?> MDL
                            </td>
                            <td class="">
                                <input type="number" class="form-control" name="data[<?= $key; ?>][res]"
                                       placeholder="Debifeaza pentru activare" value="<?= $row['res']; ?>"
                                       style="display: none; ">
                                <?= $row['res']; ?> MDL
                            </td>
                            <td class="">
                                <?= $row['dif']; ?> MDL
                            </td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="col-lg-12">
                                <button class="btn btn-default btn-success btn-group-justified" type="submit"
                                        name="submit"
                                        value="submit">Adauga salariile introduse mai sus
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>