<?php
require_once "../includes/layout/session.php";
$title = "Salarii angajati";
$page = "salarii";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../includes/add_sallary.php";
?>

    <main class="container">
        <!-- Status la operatiune SUCCESS/ERROR -->
        <?= status_baloon() ?>

        <form class="" name="salarii" method="post">
            <div class="panel panel-default">
                <div class="panel-heading" id="panel"><label for="panel">Alege o zi pentru prelucrare:</label></div>
                <!-- Creaza tabel -->
                <table id="" class="table">
                    <thead class="">
                    <tr>
                        <th>
                            <div class="input-group" role="group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"
                                                                  aria-hidden="true"></span></span>
                                <select name="date" id="select_date" class="form-control"
                                        onchange="incarcaAngajatiiDupaData(this, '../includes/ajax_salarii.php')"
                                        title="Alege una zilele ne procesate">
                                    <option value="0">Alege o data...</option>
                                    <?php
                                    $salary_date = s_d_salarii_platit();
                                    // afiseaza datele si trasnforma data in alt stil.
                                    foreach ($salary_date as $date_db) {
                                        if (isset($_POST['date']) && $_POST['date'] == $date_db[0]) {
                                            $selected = 'selected';
                                            $date = $date_db[1];
                                        }
                                        echo "<option $selected value='$date_db[0]'>$date_db[1]</option>";
                                        $selected = null;
                                    } ?>
                                </select>
                            </div>
                        </th>
                        <th>
                            <div class="input-group">
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                  </span>
                                <input type="date" id="calendar_date" name="cal-dat" class="form-control"
                                       onchange="incarcaAngajatiiDupaData(this, '../includes/ajax_salarii.php')"
                                       value="<?php if (isset($_POST['cal-dat'])) {
                                           echo $_POST['cal-dat'];
                                       } ?>" title="">
                            </div>
                        </th>
                    </tr>
                    </thead>
                </table>
                <form class="" name="ang_rulaj">
                    <table id="for_replace" class="table table-striped table-hover table-bordered auto">
                    </table>
                </form>
            </div>
        </form>
    </main>
<?php echo "trebuie sa incarca bottom";require "../includes/layout/bottom_page.php" ?>

