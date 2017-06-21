<?php
require_once "../includes/layout/session.php";
$title = "Situatie financiara";
$page = "achitare";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once  "../includes/for_ajax.php";

$temp =147;
$temp2 = 1;
$key = 0;
$i = 0;

$total = data_from_lichidari();
?>
    <main class="container">
        <div class="panel panel-default">
            <div class="panel-heading " id="panel">
                <label for="panel" class="h4">Situatii salarii la zi:<span/>
            </div>
                <table id="" class="table table-striped">
                    <thead class="thead-inverse tbl-accordion-section"  onclick=toggleClass(this)>
                    <tr><th colspan="7">Informatii despre ultimul salariu platit fiecarui angajat</th></td></tr>
                    </thead>
                    <tbody class="">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Nume prenume</th>
                        <th>Bani produsi</th>
                        <th>Valoare bunuri</th>
                        <th>Rest de plata</th>
                        <th>Ultima plata</th>
                        <th>Data</th>
                    </tr>
                    <?php $z=0; foreach($total as $key => $row){ $z++?>

                        <tr class="thead">
                            <td class="">
                                <!-- Lista angajatilor din lichidare -->
                                <?= $z; ?>
                            </td>
                            <td class="">
                                <div class="" role="alert">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    <?= " ".$row['num']; ?>
                                </div></td>
                            <td class="">
                                <?= $row['sal']; ?> MDL</td>
                            <td class="">
                                <?= $row['cre']; ?> MDL</td>
                            <td class="">
                                <?= $row['dif']; ?> MDL</td>
                            <td class="">
                                <?= $row['pla']; ?> MDL</td>
                            <td class="">
                                <div class="" role="alert">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    <?=  translate_date_to_ro($row['vdt'])?>
                                </div></td>
                        </tr>
                    <?php  $key++; }; ?>
                    </tbody>
                </table>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>