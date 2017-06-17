<?php
require_once "../classes/Database.php";
/**
 * Created by Denis.
 * User: denesska
 * Date: 3/20/2017
 * Time: 3:31 PM
 */
$fields = array('surname', 'middle', 'name', 'numar', 'gender', 'bday', 'tel_mob', 'tel_fix', 'insurance', 'type_em', 'hire_dat', 'cities');
foreach ($fields as $field) {
    $status[$field] = " ";
}

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

    if ((isset($tel['mob']) || !empty($tel['mob'])) && (isset($tel['fix']) || !empty($tel['fix']))) {
        foreach ($tel as $type => $nr) {
            $number = extract_num($nr);
            $lenght = check_lenght($number);
            $tel[$type] = phone_format($number);

            if (!$lenght) {
                $status["tel_" . $type] = "has-warning";
                $errors++;
                $_SESSION['message'] = "Antemtie! Numarul de telefon nu este completat corect\"";
                $_SESSION['status'] = "warning";
                $_SESSION['icon'] = "glyphicon-phone-alt";
            } else {
                $status["tel_" . $type] = "has-success";
            }
        }
    }
    if (!$errors && !$missing) {
        $date = date('Y-m-d');
        $query = "INSERT INTO cozagro_db.angajati (surname, middle, name, cnp, gender, birth_day, telefon, tel_fix, insurance, hire_date, type_em, cities, comments, create_date) 
                   VALUES ('$surname', '$middle', '$name', '$numar', '$gender', '$bday', '" . $tel['mob'] . "', '" . $tel['fix'] . "', '$insurance', '$hire_dat', '$type_em', '$cities', '$comment', '$date'); ";
        $query .= " INSERT INTO cozagro_db.lichidare (id_angajat, salarii, creante, platit, rest, data, comment ) 
                    VALUES (LAST_INSERT_ID(), 0, 0, 0, 0, '$date', 'inregistrare' )";
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
            $_SESSION['message'] = "Datele au fost adaugate cu success";
            $_SESSION['status'] = "success";
            $_SESSION['icon'] = "glyphicon-ok";
        }
    }
}
?>