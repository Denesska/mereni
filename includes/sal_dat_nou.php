<?php
require "../includes/for_ajax.php";
if (isset($_POST["date"])){
    $date = $_POST['date'];
    $i = 0;

    // Conecteaza la baza de date
    $dbhost = "localhost";
    $dbuser = "admin";
    $dbpass = "123Hello";
    $dbname = "cozagro_db";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    };
    $total = calc_total($connection);

    ?>
    <thead class="thead-inverse">
    <tr>
        <th><strong>#</strong></th>
        <th>Nume prenume</th>
        <th>Prezenta si explicatii</th>
        <th>Salariu</th>
        <th>Salar - Creante</th>
        <th>Diferenta</th>
    </tr>
    </thead>
    <!-- Continutul tabelului -->
    <form class="" name="ang_rulaj">
        <tbody id="tbody_1">
        <?php
        $query1 = "SELECT work_days.id, angajati.id, angajati.surname, angajati.name FROM work_days ";
        $query1 .= "INNER JOIN angajati ON work_days.id_angajat=angajati.id ";
        $query1 .= "WHERE submission_date = '$date' AND work_days.deleted='0' ";
        $query1 .= "ORDER BY angajati.surname ASC ";
        $result1 = mysqli_query($connection, $query1);
        if (!$result1) {
            die("Errore in baza de date la crearea listei de angajati pentru rulaj_zi_noua".mysqli_error($connection));
        };
        $x = [] ;
        while ($candidat = mysqli_fetch_assoc($result1)) {
        if (in_array($candidat['id'], $x)){
            continue;
        }
        $x[] = $candidat['id'];
        $i++;
        ?>
        <tr class="tbody input_row "  id="<?= $i ?>">
            <!-- Prezenta si explicatii -->
            <td class="td1"><?= $i ?></td>
            <!-- Nume candidat -->
            <?php ?>
            <td class="h3"><p ><?= $candidat['surname']." ".$candidat['name'];?><input type="number" name="data[<?=$i?>][id]" style="display: none" value="<?= $candidat['id']?>"></p></td>
            <!-- Prezenta  -->
            <td class=""><div class="input-group">
                      <span class="input-group-addon">
                          <!-- nemotivat -->
                        <input name="data[<?=$i?>][abs]" type="checkbox" title="absent nemotivat" onchange="addDisabled(this)">
                      </span>
                    <input type="text" name="data[<?= $i ?>][exp]" class="form-control" title="detalii referitor la prezenta sau absenta">
                </div></td>

            <!-- Salariu -->
            <td class=""><div class="input-group">
                    <input type="number" name="data[<?= $i ?>][sal]" class="form-control salar" title="Salariu pentru ziua curenta" value="300">
                    <span class="input-group-addon">
                            MDL
                      </span>
                </div></td>

            <!-- Total  -->
            <td class="" colspan=""><span class="form-control">
                <?= "<strong>".$total[$candidat['id']]["sal"]."</strong> <span class=\"glyphicon-minus glyphicon\"></span> <strong>".$total[$candidat['id']]["cre"]."</strong> <span class=\"glyphicon-arrow-right glyphicon\"></span>"?></span>
            </td>
            <!-- Lichidare -->
            <td class="" colspan=""><span class="form-control">
                <?= "<strong> ".$total[$candidat['id']]["dif"]."  </strong> <span>MDL</span> <strong>"?>
            </td>

            <?php } ?>
        </tbody>
        <tfoot>
        <td colspan="6">
            <div class="col-lg-12">
                <button class="btn btn-default btn-success btn-group-justified" type="submit" name="submit"
                        value="submit">Adauga datele pentru toata ziua
                </button>
            </div><!-- /.col-lg-12 -->
        </td>
        </tfoot>
    </form>
<?php } ?>

