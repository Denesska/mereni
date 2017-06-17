<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 07-Jun-17
 * Time: 5:30 PM
 */
if (isset($_POST['submit'])) {
    //  print_r($_POST['data']);
    $data = $_POST['data'];
    $dat = date("Y-m-d");
    $query = "";
    foreach ($data as $id => $sume) {
        if (!isset($sume['check'])) {
            $ids = $id;
            $salarii = $sume['sal'];
            $creante = $sume['cre'];
            $platit = $sume['pla'];
            $rest = $sume['res'] + $sume['sal'] - $sume['cre'] - $sume['pla'];

            $query = "INSERT INTO cozagro_db.lichidare (id_angajat, salarii, creante, platit, rest, data) 
              VALUES ($id, $salarii, $creante, $platit, $rest, '$dat'); ";
            $result = Database::getInstance()->getConnection()->multi_query($query);
            if (!$result) {
                die("Nu au fost introduse datele in lichidari" . Database::getInstance()->getConnection()->error);
            }
        } else {
            continue;
        }
    }
}