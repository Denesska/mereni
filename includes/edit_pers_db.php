<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 10-Jun-17
 * Time: 3:24 PM
 */
require_once "../classes/Database.php";

$errors = 0;
$missing = [];
$mandatory = ["surname", "name", "hire_dat", "type_em"];
$str_validate = [ "middle","cities", "insurance", "gender", "bday", "numar"];
if (isset($_POST["submit"])) {
    foreach ($_POST as $field => $Value) {
        if (in_array($field, $str_validate) && !empty($Value)) {
            $status[$field] = "has-success";
            $Value = validate_string($Value);
        }
        $$field = $Value;
        if (in_array($field, $mandatory) && !empty($Value)) {
            $status[$field] = "has-success";
        } elseif (in_array($field, $mandatory) && empty($Value)) {
            $missing[] = $field;
            $status[$field] = "has-error";
            $_SESSION['message'] = "Nu ai complectat toate campurile obligatorii!";
            $_SESSION['status'] = "danger";
            $_SESSION['icon'] = "glyphicon-exclamation-sign";
        }
    }

    if ((isset($tel['mob']) && !empty($tel['mob']))) {
        $tel_form = validate_phone_num($tel['mob']);
        $status['tel_mob'] = $tel_form['sta'];
        $tel['mob'] = $tel_form['tel'];
        $errors +=$tel_form['err'];
    }
    if ((isset($tel['fix']) && !empty($tel['fix']))) {
        $tel_form = validate_phone_num($tel['fix']);
        $status['tel_fix'] = $tel_form['sta'];
        $tel['fix'] = $tel_form['tel'];
        $errors += $tel_form['err'];
    }
    if (!$errors && !$missing) {
        $id_angajat = escaped_str($_GET['id']);
        $query = "UPDATE cozagro_db.angajati SET surname='$surname', middle='$middle', name='$name', cnp='$numar', gender='$gender', birth_day='$bday', telefon='". $tel['mob'] .
                            "', tel_fix='" . $tel['fix'] . "', insurance='$insurance', hire_date='$hire_dat', type_em='$type_em', cities='$cities', comments='$comment'
                             WHERE id='$id_angajat' LIMIT 1";
        $result = Database::getInstance()->getConnection()->multi_query($query);
        if (!$result) {
            die("Data base query FAILED!" . Database::getInstance()->getConnection()->error);
        } else {
            foreach ($_POST as $field => $Value) {
                $$field = null;
            }
            foreach ($fields as $field) {
                $status[$field] = " ";
            }
            $_SESSION['message'] = "Datele au fost modificate cu success";
            $_SESSION['status'] = "success";
            $_SESSION['icon'] = "glyphicon-ok";
            header("Location: /angajati.php?id=$id_angajat");
        }
    }
}