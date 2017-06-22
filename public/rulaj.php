<?php
require_once "../includes/layout/session.php";
$title = "Rulaj nou";
$page = "rulaj_zi_nou";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
?>
    <main class="container">
        <?php
        $selected = "";
        $dates = [];
        $date = null;
        $i = 0;
        $container = array();
        $error = "success";
        // executa formularul  FOC
        if (isset($_POST['submit'])) {
            $backup_array = $_POST['data'];
            if ($_POST['date'] == 0) {
                $date = $_POST['cal-dat'];
            } else {
                $date = $_POST['date'];
            }
            $_SESSION['message'] = "Datele au fost adaugate cu success";
            $_SESSION['status'] = "success";
            $_SESSION['icon'] = "glyphicon-ok";
            $errors = 0;
            $element_number = count($_POST['data']);
            foreach ($_POST['data'] as $key_row => $rows) {
                $i++;
                $j = 0;
                if ($rows['sum_avans'] == 0) {
                    $j++;
                    $backup_array[$key_row]['sum'] = ["alert" => " has-error ", "icon" => " glyphicon-exclamation-sign "];
                } else {
                    $backup_array[$key_row]['sum'] = ["alert" => " has-success ", "icon" => " glyphicon-ok "];
                }
                if ($rows['angajat'] == 0) {
                    $j++;
                    $backup_array[$key_row]['ang'] = ["alert" => " has-error ", "icon" => " glyphicon-exclamation-sign "];
                } else {
                    $backup_array[$key_row]['ang'] = ["alert" => " has-success ", "icon" => " glyphicon-ok "];
                }
                if ($rows['detalii'] == null) {
                    $j++;
                    $backup_array[$key_row]['det'] = ["alert" => " has-error ", "icon" => " glyphicon-exclamation-sign "];
                } else {
                    $backup_array[$key_row]['det'] = ["alert" => " has-success ", "icon" => " glyphicon-ok "];
                }

                if ($j != 3 && $j != 0) {
                    $error = "backup";
                    $errors = 1;
                    $_SESSION['message'] = "A fost o erroare ";
                    $_SESSION['status'] = "danger";
                    $_SESSION['icon'] = "glyphicon-exclamation-sign";
                    // elimina randurile care nu aveau setat nici o valoare.
                } elseif ($j == 3) {
                    unset($backup_array[$key_row]);
                }
            }
            // se ataseaza ultimul rand care de obiecei este gol
            $backup_array[$key_row] = $_POST['data'][$key_row];
            $backup_array[$key_row]['sum'] = ["alert" => " ", "icon" => " "];
            $backup_array[$key_row]['det'] = ["alert" => " ", "icon" => " "];
            $backup_array[$key_row]['ang'] = ["alert" => " ", "icon" => " "];
            if (count($backup_array) == 1){
                $_SESSION['message'] = "Nu ai completat nici un camp";
                $_SESSION['status'] = "warning";
                $_SESSION['icon'] = "glyphicon-question-sign";
            }elseif ($errors != 1 && $error == "success") {
                $x = $_POST['data'];
                for ($i = 1; $i < $element_number; $i++) {
                    if ($x[$i]['angajat'] == 0) {
                        continue(1);
                    }
                    $query = "INSERT INTO `creante` (`id_angajat`, `tip_creanta`, `sum_creanta`, data, `data_adaugat`) 
                              VALUES ('" . $x[$i]['angajat'] . "', '" . $x[$i]['detalii'] . "', '" . $x[$i]['sum_avans'] . "', '" . $date . "', '" . date("Y-m-d") . "')";
                    $result = Database::getInstance()->getConnection()->query($query);
                    if (!$result) {
                        die("erroare la conectare DB la adaugarea date in revenue" . Database::getInstance()->getConnection()->error);
                    }
                    $_POST['submit'] = "success";

                }
            }
        }
        ?>
        <!-- Status la operatiune SUCCESS/ERROR -->
        <?= status_baloon(); ?>

        <form class="" name="ang_rulaj" method="post">
            <div class="panel panel-default">
                <div class="panel-heading" id="panel"><label for="panel">Alege o data pentru a adauga creante(produse
                        proprii):</label></div>
                <!-- Creaza tabel -->
                <table id="" class="table ">
                    <thead class="">
                    <tr class="">
                        <th>
                            <div class="input-group" role="group">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                <select name="date" id="select_date" class="form-control"
                                        onchange="incarcaAngajatiiDupaData(this, '../includes/ajax_rulaj.php')"
                                        title="Alege o data pentru a adauga creante(avans)">
                                    <option value="0">Alege o data...</option>
                                    <?php
                                    $submission_date = format_data_out_db('submission_date');
                                    $query_data = "SELECT DISTINCT $submission_date AS date_db 
                                                    FROM cozagro_db.work_days 
                                                    WHERE DATE_SUB(CURDATE(),INTERVAL 6 DAY) <= submission_date  AND deleted = 0
                                                    ORDER BY submission_date DESC ";
                                    echo "<h1>$query_data</h1>";
                                    $result_data = Database::getInstance()->getConnection()->query($query_data);
                                    if (!$result_data) {
                                        die("Nu s-a reusit conexiunea la DB selectarea zilelor de munca" . Database::getInstance()->getConnection()->error);
                                    }
                                    while ($dates = $result_data->fetch_assoc()) {
                                        $container[] = [remove_day_from_date_and_format($dates['date_db']), translate_date_to_ro($dates['date_db'])];
                                    }
                                    echo $date;
                                    foreach ($container as $date_db) {
                                        if (isset($date) && $date == $date_db[0]) {
                                            $selected = 'selected';
                                        }
                                        echo "<option $selected value='$date_db[0]'>$date_db[1]</option>";
                                        $selected = null;
                                        ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </th>
                        <th>
                            <div class="input-group">
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                  </span>
                                <input type="date" name="cal-dat" id="calendar_date" class="form-control"
                                       onchange="incarcaAngajatiiDupaData(this, '../includes/ajax_rulaj.php')"
                                       value="<?php if (isset($date)) {
                                           echo $date;
                                       } ?>"
                                       title="alege o data din calendar..." placeholder="Nu merge FireFox">
                            </div>
                        </th>
                    </tr>
                    </thead>
                </table>
                <table id="for_replace" class="table table-striped table-hover table-bordered">
                    <?php if (isset($errors) && $errors == 1) {
                        require "../includes/ajax_rulaj.php";
                    }
                    if ($error == "success") {
                        $backup_array = [];
                    } ?></table>
            </div>
        </form>
    </main>
<?php require_once "../includes/layout/bottom_page.php" ?>