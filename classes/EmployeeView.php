<?php
require_once "../classes/Database.php";
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 28-May-17
 * Time: 6:16 PM
 */
class EmployeeView
{
     public function getEmployeeSelect($i, $backup_array)
    {
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        ?> <select name="data[<?= $i ?>][employee]" class="form-control" onchange="addRows(this)" title="">
        <option value="0">Alege un candidat</option>
        <?php
        $query = "SELECT id, surname, name FROM cozagro_db.angajati ";
        $query .= "ORDER BY surname ASC ";
        $result =  $mysqli->query($query);
        if (!$result) {
            die("Errore in baza de date.");
        }
        while ($candidat = $result->fetch_assoc()) {
            $selected = selected($candidat["id"], $i, "employee", $backup_array);
            echo "<option $selected value='{$candidat['id']}'>{$candidat['surname']} {$candidat['name']} </option> ";
        } ?>
        </select><?php
    }
}