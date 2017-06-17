<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 07-Jun-17
 * Time: 1:12 PM
 */
$selected = "";
$error = "success";
$errors = 0;
// executa formularul  FOC

if (isset($_POST['submit'])) {
    if (!empty($_POST['date'])) {
        $x = $_POST['data'];
        $dat = $_POST['date'];
        $today = date("Y-m-d");
        $element_number = count($_POST['data']);
        for ($i = 1; $i <= $element_number; $i++) {
            $prez[$i] = 1;
            $motiv[$i] = 0;
            if (!isset($x[$i]["sal"]) || $x[$i]['sal'] == 0) {
                $x[$i]['sal'] = 0;
                $prez[$i] = 0;
                if (isset($x[$i]['abs'])) {
                    $motiv[$i] = 1;
                }
            }
            //Insereaza valorile noi.
            $query = "INSERT INTO cozagro_db.salarii (`id_angajat`,`prezent`, `motiv`, `detalii`, `suma`, `data`, `data_adaugat`, platit) 
                          VALUES ('" . $x[$i]['id'] . "', '" . $prez[$i] . "', '" . $motiv[$i] . "', '" . $x[$i]['exp'] . "', '" . $x[$i]['sal'] . "', '" . $dat . "', '" . $today . "',1); ";
            $result = Database::getInstance()->getConnection()->query($query);
            if (!$result) {
                $status_text = Database::getInstance()->getConnection()->error;
                $status_baloon = "danger";
                ?>
                <p id="status_baloon" class="bg-<?= $status_baloon ?> alert h3"><?= $status_text ?></p> <?php
                die("erroare la conectare DB la adaugarea date in salarii");
            }
            $query = "UPDATE cozagro_db.work_days SET completed = 1 WHERE id_angajat=" . $x[$i]['id'] . " AND submission_date = '$dat'";
            $result = Database::getInstance()->getConnection()->query($query);
            if (!$result) {
                $status_text = Database::getInstance()->getConnection()->error;
                $status_baloon = "danger";
                ?>
                <p id="status_baloon" class="bg-<?= $status_baloon ?> alert h3"><?= $status_text ?></p> <?php
                die("erroare la conectare DB la adaugarea date in salarii");
            }
        }
        $date = DateTime::createFromFormat("Y-m-d",$_POST['date'])->format("D d m Y");
        $date = translate_date_to_ro($date);
        $_SESSION['message'] = "Salariile au fost inregistrate cu success pentru data $date ";
        $_SESSION['status'] = "success";
        $_SESSION['icon'] = "glyphicon-ok";
    } elseif (isset($_POST['cal-dat'])) {
        //Do update salarii table
        $x = $_POST['data'];
        $dat = $_POST['cal-dat'];
        $today = date("Y-m-d");
        $element_number = count($_POST['data']);
        for ($i = 1; $i <= $element_number; $i++) {
            $prez[$i] = 1;
            $motiv[$i] = 0;
            if (!isset($x[$i]["sal"]) || $x[$i]['sal'] == 0) {
                $x[$i]['sal'] = 0;
                $prez[$i] = 0;
                if (isset($x[$i]['abs'])) {
                    $motiv[$i] = 1;
                }
            }
            //Insereaza valorile noi.
            $query = "UPDATE cozagro_db.salarii SET `prezent`= $prez[$i], `motiv`= $motiv[$i], `detalii`= '" . $x[$i]['exp'] . "', `suma`=" . $x[$i]['sal'] . ",  `data_adaugat`='" . $today . "', platit=1 
                              WHERE id_angajat = " . $x[$i]['id'] . " AND data= '$dat' ";
            $result = Database::getInstance()->getConnection()->query($query);
            if (!$result) {
                $status_text = Database::getInstance()->getConnection()->error;
                $status_baloon = "danger";
                ?>
                <p id="status_baloon" class="bg-<?= $status_baloon ?> alert h3"><?= $status_text ?></p> <?php
                die("erroare la conectare DB la updatare date in salarii");
            }
        }
        //statusul operatiunii
        $date = DateTime::createFromFormat("Y-m-d",$_POST['cal-dat'])->format("D d m Y");
        $date = translate_date_to_ro($date);
        $_SESSION['message'] = "Salariile au fost modificate cu success pentru $date";
        $_SESSION['status'] = "success";
        $_SESSION['icon'] = "glyphicon-ok";
    }
    unset($_POST);
}