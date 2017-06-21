<?php
require_once "../classes/Database.php";


// Selteaza toate datele salariilor daca sunt deja platite sau returneaza 0 daca nu exista salarii pe data cceruta
function select_salarii_patite($date, $i)
{
    // $query1 = "IF((SELECT id FROM salarii  ";
    //  $query1 .= "WHERE id_angajat ='$i' AND data = '$date' AND deleted = '0' AND platit = '1' ) > 0)";
    $query1 = " SELECT angajati.surname, angajati.name, salarii.id, salarii.id_angajat, salarii.prezent, salarii.motiv, salarii.detalii, salarii.suma, salarii.data_adaugat FROM salarii ";
    $query1 .= "INNER JOIN angajati ON salarii.id_angajat=angajati.id ";
    $query1 .= "WHERE salarii.id_angajat IN ($i) AND data = '$date' AND salarii.deleted='0' AND salarii.platit='1' ";
    $query1 .= "ORDER BY angajati.surname ASC";
//    $query1 .= "ELSE END";
    //   $query1 = " SELECT `id`, prezent, `id_angajat`, `motiv`, `detalii`, `suma`, `data_adaugat`  FROM salarii ";
    //   $query1 .= "INNER JOIN angajati ON salarii.id_angajat=angajati.id ";
//    $query1 .= "WHERE id_angajat ='$i' data = '$date' AND deleted='0' AND platit='1";
    //   $query1 .= "ORDER BY angajati.surname ASC )";
    $result1 = Database::getInstance()->getConnection()->query($query1);
    if (!$result1) {
        die("Errore la selectare ID info din salarii dupa data si platit! functia select_workdays_by_date" . Database::getInstance()->getConnection()->error);
    };
    $x = [];
    while ($salarii = $result1->fetch_assoc()) {
        $x[$salarii['id_angajat']] = ['num' => $salarii['surname'] . "" . $salarii['name'],
            'sum' => $salarii['suma'],
            'pre' => $salarii['prezent'],
            'mot' => $salarii['motiv'],
            'det' => $salarii['detalii'],
            'dat' => $salarii['data_adaugat']];
    }
    if (Database::getInstance()->getConnection()->affected_rows == 0) {
        return false;
    }
    return $x;
}

// Face update la salarii daca deja sunt in DB

function select_salarii_by_date($data)
{
    $ban = [];
    $query_sal = "SELECT sal.id_angajat, sal.id, sal.detalii, sal.prezent, sal.motiv, suma, surname, name FROM cozagro_db.salarii AS sal
                  INNER JOIN cozagro_db.angajati an ON sal.id_angajat=an.id
                  WHERE sal.deleted=0 AND data='$data' ORDER BY surname";
    $result_sal = Database::getInstance()->getConnection()->query($query_sal);
    if (!$result_sal) {
        die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
    }
    $i = 0;
    while ($candidat = $result_sal->fetch_assoc()) {
        $i++;
        $ban[$i] = [
            "aid" => $candidat['id_angajat'],
            "num" => $candidat['surname'] . " " . $candidat['name'],
            "sid" => $candidat['id'],
            "pre" => $candidat['prezent'],
            "mot" => $candidat['motiv'],
            "sum" => $candidat['suma'],
            "det" => $candidat['detalii']];

    }
    return $ban;

}

function sum_rest_plata()
{
    $query1 = "SELECT angajati.id, sum(salarii.suma) - sum(cozagro_db.lichidare.platit) - sum(cozagro_db.creante.sum_creanta) AS total 
                FROM cozagro_db.angajati 
                INNER JOIN cozagro_db.creante creante ON cozagro_db.angajati.id=creante.id_angajat 
                INNER JOIN cozagro_db.salarii sal ON cozagro_db.angajati.id=sal.id_angajat";

    $result1 = Database::getInstance()->getConnection()->query($query1);
    if (!$result1) {
        die("Errore la selectarea ID-urilor la ANGAJATI din WORK_DAYS dupa data! functia select_workdays_by_date" . Database::getInstance()->getConnection()->error);
    };
    $x = [];
    while ($id = $result1->fetch_assoc()) {
        $x[$id['id']] = $id['total'];
    }
    $result1->free_result();
    return $x;
}

//Selecteaza toate ID-urile la ANGAJATI din WORK_DAYS dupa data
//si sorteaza dupa prenumele angajatului.
function select_workdays_by_date($date)
{

    $query1 = "SELECT wd.id, an.id FROM cozagro_db.work_days wd
                INNER JOIN cozagro_db.angajati an ON wd.id_angajat =an.id 
                WHERE submission_date = '$date' AND wd.deleted='0' AND completed = 0
                ORDER BY an.surname ASC ";
    $result1 = Database::getInstance()->getConnection()->query($query1);
    if (!$result1) {
        die("Errore la selectarea ID-urilor la ANGAJATI din WORK_DAYS dupa data! functia select_workdays_by_date" . Database::getInstance()->getConnection()->error);
    };
    $x = [];
    while ($id = $result1->fetch_assoc()) {
        if (in_array($id['id'], $x)) {
            continue;
        }
        $x[] = $id['id'];
    }
    $result1->free_result();
    return $x;
}
//Selecteaza toate ID- prenume si nume la ANGAJATI din WORK_DAYS dupa data
//si sorteaza dupa prenumele angajatului.
function select_name_by_workdate($date)
{
    $query = "SELECT DISTINCT wd.id, an.id, an.surname, an.name FROM cozagro_db.work_days wd
                INNER JOIN cozagro_db.angajati an ON wd.id_angajat =an.id 
                WHERE submission_date = '$date' AND wd.deleted='0'
                ORDER BY an.surname ASC ";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Errore la selectarea ID-urilor la ANGAJATI din WORK_DAYS dupa data! functia select_workdays_by_date" . Database::getInstance()->getConnection()->error);
    };
    $x = [];
    while ($emp = $result->fetch_assoc()) {
        $x[$emp['id']] = $emp['surname']." ".$emp['name'];
    }
    $result->free_result();
    return $x;
}
// selecteaza toate ID-urile din agajati,
//si le ordoneaza dupa prenume
//se poate adauga si query mai departe
//se foloseste in achitare.php.
function select_all_id($query2)
{
    $aid = [];
    $query = "SELECT id FROM angajati WHERE deleted = '0' $query2";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die(" nu a s-a reusit conectarea la db, id angajati" . Database::getInstance()->getConnection()->error);
    }
    while ($id = $result->fetch_assoc()) {
        $aid[] = $id['id'];
    }
    $result->free_result();
    return $aid;
}

// Gaseste ultima lichidare dupa ID-urile din $AID,
// creaza un array cu detaliile despre ultima plata si
// calculeaza soldurile de la ultima lichidare pana la zi.
function calc_total($aid)
{
    $dat2 = date("Y-m-d");
    $ban = [];
    // print_r($aid);
    foreach ($aid as $i) {
        $ban[$i]['cre'] = 0;
        $ban[$i]['sal'] = 0;
        $ban[$i]['dif'] = 0;
        $ban[$i]['lid'] = 0;
        $ban[$i]['aid'] = 0;
        $ban[$i]['num'] = 0;
        $ban[$i]['pla'] = 0;
        $ban[$i]['dat'] = 0;
        $ban[$i]['sol'] = 0;
        $ban[$i]['temp'] = 0;
        $query = "SELECT li.id_angajat, li.id, li.platit, li.rest, an.surname, an.name, li.data 
                  FROM cozagro_db.angajati an
                  INNER JOIN cozagro_db.lichidare  li ON an.id=li.id_angajat
                  WHERE li.deleted='0' AND id_angajat ='$i' 
                  ORDER BY li.data DESC LIMIT 1 ";

        $result = Database::getInstance()->getConnection()->query($query);
        if (!$result) {
            die("Errore in baza de date la crearea listei de angajati pentru salarii cu id ='$i' : " . Database::getInstance()->getConnection()->error);
        };
        while ($candidat = $result->fetch_assoc()) {
            $vdt = date_create($candidat['data']);
            $ban[$i] = [
                "aid" => $candidat['id_angajat'],
                "num" => $candidat['surname'] . " " . $candidat['name'],
                "lid" => $candidat['id'],
                "dat" => $candidat['data'],
                "pla" => $candidat['platit'],
                "sol" => $candidat['rest'],
                "cre" => $ban[$i]['cre'],
                "sal" => $ban[$i]['sal'],
                "dif" => $ban[$i]['dif'],
                "vdt" => date_format($vdt, "d M, l"),
                "temp" => $ban[$i]['temp']];

        }
        print_r($ban);
        $dat1 = $ban[$i]['dat'];
        // Sumeaza creantele
        $query = "SELECT id_angajat, sum_creanta, data FROM cozagro_db.creante  ";
        $query .= "WHERE id_angajat = '$i' AND deleted = '0' AND data BETWEEN '$dat1' AND '$dat2'";
        $result = Database::getInstance()->getConnection()->query($query);
        if (!$result) {
            die("nu s-a reusit conenctarea la salrii $i : " . Database::getInstance()->getConnection()->error);
        }
        while ($bani = $result->fetch_assoc()) {
            $ban[$i]['cre'] += $bani['sum_creanta'];
            //$ban[$i]['dcre'] += $bani['data'];
            //  $ban[$i]['icre'] = $bani['id_angajat'];

        }
        // verifica daca exista cel putin o inregistrare
        if (Database::getInstance()->getConnection()->affected_rows == 0) {
            $ban[$i]['cre'] = 0;
        };
        // Sumeaza salariile

        $query = "SELECT suma, id_angajat, data FROM cozagro_db.salarii  ";
        $query .= "WHERE id_angajat ='$i' AND deleted = '0' AND platit = '0' AND data BETWEEN '$dat1' AND '$dat2'";
        $result = Database::getInstance()->getConnection()->query($query);
        if (!$result) {
            die("nu s-a reusit conenctarea la salrii $i : " . Database::getInstance()->getConnection()->error);
        }
        while ($bani = $result->fetch_assoc()) {
            $ban[$i]['sal'] += $bani['suma'];
            $ban[$i]['dif'] = $ban[$i]['sal'] - $ban[$i]['cre'];
        }
        // verifica daca exista cel putin o inregistrare
        if (Database::getInstance()->getConnection()->affected_rows == 0) {
            $ban[$i]['sal'] = 0;
            $ban[$i]['dif'] = $ban[$i]['sal'] - $ban[$i]['cre'];
        };
    }

    echo " end for<br>";
    print_r($ban);
    return $ban;
}

// creaza un tabel comun pentru suma la creante, plati, datorii si ultimele date despre plati.
function data_from_lichidari()
{
    $query = "CREATE OR REPLACE VIEW total_bani AS ";
    $query .= "SELECT an.surname, an.name, li.id_angajat,  SUM( li.platit ) AS totalP , SUM( li.creante ) AS totalC, SUM( li.salarii ) AS totalS ,  SUM( li.rest ) AS totalR 
              FROM lichidare AS li 
				  INNER JOIN angajati an ON li.id_angajat=an.id
				  GROUP BY id_angajat; ";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu se connectat la achitari : " . Database::getInstance()->getConnection()->error);
    }
    $data = format_data_out_db("data");
    $query = "CREATE OR REPLACE VIEW total AS ";
    $query .= "SELECT surname, name, id, tb.id_angajat, salarii, creante, platit, rest, $data AS dat_db, totalP, totalC, totalS, totalR FROM lichidare 
                INNER JOIN total_bani AS tb ON lichidare.id_angajat=tb.id_angajat
                WHERE NOT EXISTS (SELECT * FROM lichidare AS l2 WHERE l2.id_angajat = lichidare.id_angajat AND l2.id > lichidare.id) ;";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu se connectat la achitari : " . Database::getInstance()->getConnection()->error);
    }
    $query = "SELECT * FROM total ORDER BY surname;	";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu se connectat la achitari : " . Database::getInstance()->getConnection()->error);
    }

    while ($x = $result->fetch_assoc()) {
        $ban[$x['id_angajat']]['num'] = $x['surname'] . " " . $x['name'];
        $ban[$x['id_angajat']]['vdt'] = $x['dat_db'];
        $ban[$x['id_angajat']]['sal'] = $x['totalS'];
        $ban[$x['id_angajat']]['cre'] = $x['totalC'];
        $ban[$x['id_angajat']]['pla'] = $x['totalP'];
        $ban[$x['id_angajat']]['platit'] = $x['platit'];
        $ban[$x['id_angajat']]['res'] = $x['totalR'];
        $ban[$x['id_angajat']]['rest'] = $x['rest'];
        $ban[$x['id_angajat']]['dif'] = 0;
    }

    $query = "SELECT id_angajat, SUM( sum_creanta ) AS totalC FROM cozagro_db.creante GROUP BY id_angajat ; ";
    $result = Database::getInstance()->getConnection()->query($query);

    if (!$result) {
        die("Nu se connectat la lichidari" . Database::getInstance()->getConnection()->error);
    }

    while ($x = $result->fetch_assoc()) {
        $ban[$x['id_angajat']]['cre'] = $x['totalC'] - $ban[$x['id_angajat']]['cre'];
    }
    $query = "SELECT id_angajat, SUM(suma) AS totalS FROM cozagro_db.salarii GROUP BY id_angajat";
//
    $result = Database::getInstance()->getConnection()->query($query);

    if (!$result) {
        die("Nu se connectat la lichidari" . Database::getInstance()->getConnection()->error);
    }
    while ($x = $result->fetch_assoc()) {
        $id = $x['id_angajat'];
        $ban[$id]['sal'] = $x['totalS'] - $ban[$id]['sal'];
        $ban[$id]['dif'] = $ban[$id]['sal'] - $ban[$id]['cre'] + $ban[$id]['res'];
    }

   // echo " calc_from_lichidari<br>";
   // print_r($ban);
    return $ban;
}
