<?php
require_once "../includes/layout/session.php";
$page = "lucru_zi_nou";
$title = "Zi muncă nouă";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../classes/EmployeeView.php";
$result = [];
$last = 1;
$backup_array = 0;
$submitted = false;

if (isset($_POST['submit'])) {
    $submitted = true;
    require "../classes/NewWorkDayHandler.php";
    $handler = new NewWorkDayHandler();
    $result = $handler->createWorkDay($_POST['data'], $_POST['work_day_date']);
    $last = $result['last'];
}
?>
    <main class="container">
        <!-- Status la operatiune SUCCESS/ERROR -->
        <?= status_baloon()?>
        <form method="post" name="add_day">
            <div class="panel panel-default">
                <div class="panel-heading overflow-auto ">
                    <label class="h4 control-label float-left" for="data_work">Alege o data pentru a adauga activitati : </label>
                    <div class="col-sm-5 col-md-4 col-lg-3 form-group">
                    <input type="date" name="work_day_date" id="data_work" class="form-control"
                           value="<?php if ($submitted && $result['success'] == false) {
                               echo $_POST["work_day_date"];
                           } else {
                               echo date("Y-m-d");
                           } ?>" title="">
                </div>
                </div>
                <!-- Tabelul principal -->
                <table id="" class="table">

                    <!-- Continutul tabelului cu angajati si loc activitate -->
                    <thead class="thead-inverse">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Prenume Nume</th>
                        <th>Loc activitate</th>
                        <th colspan="2">Comentarii/Observatii</th>
                    </tr>
                    </thead>
                    <!-- Continutul tabelului cu angajati si loc activitate -->
                    <tbody id="tbody_1">
                    <?php
                    // Creaza array cu lista de activitiati
                    $locatie = select_activity();
                    // creaza numarul de linii selectate anterior
                    for ($i = 1; $i <= $last; $i++) { ?>
                        <tr class="tbody input_row" id="<?= $i ?>">
                            <td class="row_nr"><?= $i ?></td>
                            <!-- lista angajati -->
                            <td>
                                <div class="form-group <?php if ($submitted && $result['success'] == false && $i < $last ) {
                                    echo $result['status'][$i]['employee'];
                                } ?>">
                                    <?php if ($submitted && $result['success'] == false && isset($result['icon'][$i]['employee'])) {
                                        echo $result['icon'][$i]['employee'];
                                    }
                                    $select = new EmployeeView();
                                    $select->getEmployeeSelect($i, $result);
                                    ?>
                                </div>
                            </td>
                            <!-- lista loc activitate -->
                            <td>
                                <div class="form-group <?php if ($submitted && $result['success'] == false && $i < $last) {
                                    echo $result['status'][$i]['loc_activitate'];
                                } ?>">
                                    <?php if ($submitted && $result['success'] == false && isset($result['icon'][$i]['loc_activitate'])) {
                                        echo $result['icon'][$i]['loc_activitate'];
                                    } ?>
                                    <select name="data[<?= $i ?>][loc_activitate]" class="form-control"
                                            title="Alege loc activitate">
                                        <option value="0">Alege loc activitate</option>
                                        <?php
                                        foreach ($locatie as $id => $loc) {
                                            $selected = selected($id, $i, "loc_activitate", $result);
                                            echo "<option $selected value='{$id}'>{$loc} </option> ";
                                        } ?>
                                    </select></div>
                            </td>
                            <td colspan="2">
                            <textarea name="data[<?= $i ?>][comment]"
                                      class="form-control textarea-hight"
                                      placeholder="Adauga detalii..."><?php if ($submitted && $result['success'] == false) {
                                    echo $result[$i]["comment"];
                                } ?></textarea>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="col-lg-12">
                                <button class="btn btn-default btn-success btn-group-justified" type="submit"
                                        name="submit"
                                        value="submit">Adauga datele pentru toata ziua
                                </button>
                            </div><!-- /.col-lg-12 -->
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>