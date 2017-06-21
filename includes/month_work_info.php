<?php
require_once "../classes/Database.php";
require_once "function.php";
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 13-Jun-17
 * Time: 4:46 PM
 */
echo $id = $_GET['id'];
echo $month = $_GET['month'];
echo $tab =  $_GET['tab'];
$info = null;

if ($tab == 1){
    // Suntem in tabelul Lucrat
    $query = "SELECT DATE_FORMAT(submission_date, '%a, %d') AS day, loc_activitate.locatie, work_days.comment
                    FROM cozagro_db.work_days, loc_activitate 
                    WHERE work_days.deleted = 0 AND id_loc_activitate=loc_activitate.id AND id_angajat= $id AND DATE_FORMAT(submission_date, '%m') = $month
                    ORDER BY submission_date";
    $info = array( "z", "locatie", "comment");
}elseif ($tab == 2){
   // echo "Suntem in tabelul Salarii";
    $query = "SELECT DATE_FORMAT(data, '%a, %d') AS day,  motiv, suma, detalii
                    FROM cozagro_db.salarii
                    WHERE salarii.deleted = 0 AND id_angajat= $id AND DATE_FORMAT(data, '%m') = $month
                    ORDER BY data";
    $info =array('z','suma','detalii');
}elseif ($tab == 3) {
    // echo "Suntem in tabelul Creante";
    $query = "SELECT DATE_FORMAT(data, '%a, %d') AS day, DATE_FORMAT(data_adaugat, '%d . %m') AS adaugat, tip_creanta, sum_creanta
                    FROM cozagro_db.creante
                    WHERE creante.deleted = 0 AND id_angajat= $id AND DATE_FORMAT(data, '%m') = $month
                    ORDER BY data";
    $info = array('tip_creanta','sum_creanta','x');
}elseif ($tab == 4){
    // suntem in tabel cu Lichidare
    $query = "SELECT DATE_FORMAT(data, '%a, %d') AS day, platit, rest,  comment
                    FROM cozagro_db.lichidare
                    WHERE lichidare.deleted = 0 AND id_angajat= $id AND DATE_FORMAT(data, '%m') = $month
                    ORDER BY data";
    $info = array('z','platit','comment');

}else{
    header("Location: /angajati.php");
    exit();
}
$result = Database::getInstance()->getConnection()->query($query);
if (!$result) {
    die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
}
$zile_lucrate = [];
while ($x = $result->fetch_assoc()) {
    $x['z'] = "-";
    $x['x'] = " ";
    $zile_lucrate[] = array("zi" => $x['day'], "1" => $x[$info[0]], "2" => $x[$info[1]], "3" => $x[$info[2]]);
}
$result->free_result();
if ($zile_lucrate) {
    foreach ($zile_lucrate as $zi) {

        ?>
        <tr class="adaugat">
            <td> - </td>
            <th><?= $zi['zi'] ?></th>
            <td><?= $zi['1'] ?></td>
            <td> <?= $zi['2'] ?></td>
            <td> <?= $zi['3'] ?></td>
        </tr>
    <?php }
} else { ?>
    <tr class="adaugat">
        <th></th>
        <td colspan="5"> Nu sunt inregistrari pe luna selectata</td>
    </tr>
    <?php
}

