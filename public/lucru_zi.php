<?php
require_once "../includes/layout/session.php";
$title = "Lucrul pe zile";
$page="lucru_zi";
$j=0;
?>
<?php
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
?>

    <main class="container">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <label class="h4">Raport din <u><?= $start = date('d m Y', strtotime("-6 days"));?></u> pana <u><?= $stop = date('d m Y');?></u></label>
            </div>
            <?php
            $i=0;
            while ($i<6){
                $date = date('d - n - Y', strtotime("-$i days"));
                $datas = list_day_work($date);
                ?>
                <table id="" class="table table-striped">
                    <thead class="thead-inverse tbl-accordion-section"  onclick=toggleClass(this)>
                    <tr><th colspan="4"><?= $date ?> </th></td></tr>
                    </thead>
                    <tbody class="">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Nume prenume</th>
                        <th>Activitate</th>
                        <th colspan="2">Comentarii</th>
                    </tr>
                    <?php foreach ($datas as $key => $row){
                        $key++ ?>
                        <tr class="thead">
                            <td class="col-lg-1">
                                <!-- Formul de stergere a angajatilor din work_days -->
                                <form action="../includes/delete.php" method="get" name="<?php echo $key."x".$date?>" >
                                    <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['id_work_days']?>" style="display: none">
                                    <input type="submit" name="submits" value="submited" style="display: none">
                                    <span onclick="submitOnClick(this)" class="glyphicon glyphicon-remove red" id="<?php echo $key."x".$date?>"></span> <?= $key; ?>
                                </form>
                            </td>
                            <td class="col-lg-3"><?= $row['nume']; ?></td>
                            <td class="col-lg-3"><?= $row['loc_activitate']; ?></td>
                            <td class="col-lg-5"><?= $row['comment']; ?></td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
                <?php
                $i++;
            }
            ?>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>