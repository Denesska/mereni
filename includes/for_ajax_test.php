<?php
// Face calculul pentru salarii si creante pentru pagina de salarii;
/*
function calc_total($connection){
    $final = [];
    $query = "SELECT `suma`, `id_angajat`, `data`  FROM `salarii`";

    $result = mysqli_query($connection, $query);
    if (!$result){
        die("nu s-a reusit conenctarea la salrii".mysqli_error($connection));
    }

    $sal = array();
    while ($salariu = mysqli_fetch_assoc($result)) {
        if (isset($sal[$salariu['id_angajat']])) {
            $sal[$salariu['id_angajat']] = $sal[$salariu['id_angajat']] + $salariu['suma'];
        } else {
            $sal[$salariu['id_angajat']] = $salariu['suma'];
        }
    }
    $query2 = "SELECT id_angajat, sum_creanta, `data`  FROM creante";
    $result2 = mysqli_query($connection, $query2);
    if (!$result2) {
        die("a murit la conenctarea la creante" . mysqli_error($connection));
    }
    $cre3 = [];
    while ($creante = mysqli_fetch_assoc($result2)) {
        if (isset($cre3[$creante['id_angajat']])) {
            $cre3[$creante['id_angajat']] = $cre3[$creante['id_angajat']] + $creante['sum_creanta'];
        } else {
            $cre3[$creante['id_angajat']] = $creante['sum_creanta'];
        }
    }
    foreach ($sal as $id => $suma) {
        $dif[$id] = $suma - $cre3[$id];
        $final[$id] =["sal" => $sal[$id],
                      "cre" => $cre3[$id],
                      "dif" => $dif[$id]];
    }

    return $final;
}
*/
// Se conecteaza la baza de date
function con_db(){
    // Conecteaza la baza de date
    $dbhost = "localhost";
    $dbuser = "admin";
    $dbpass = "123Hello";
    $dbname = "mercauto_db";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    };
    return $connection;
}

// Selteaza toate datele salariilor daca sunt deja platite sau returneaza 0 daca nu exista salarii pe data cceruta
function select_salarii_patite($connection, $date, $i){
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
    $result1 = mysqli_query($connection, $query1);
    if (!$result1) {
        die("Errore la selectare ID info din salarii dupa data si platit! functia select_workdays_by_date" . mysqli_error($connection));
    };
    $x = [];
    while ($salarii = mysqli_fetch_assoc($result1)) {
        $x[$salarii['id_angajat']] = ['num' => $salarii['surname']."".$salarii['name'],
                                        'sum' => $salarii['suma'],
                                        'pre' => $salarii['prezent'],
                                        'mot' => $salarii['motiv'],
                                        'det' => $salarii['detalii'],
                                        'dat' => $salarii['data_adaugat']];
    }
    if(!mysqli_affected_rows($connection) == 0){
        return;
    }
    return $x;
}
//Selecteaza toate ID-urile la ANGAJATI din WORK_DAYS dupa data
//si sorteaza dupa prenumele angajatului.
function select_workdays_by_date($connection, $date){

    $query1 = "SELECT work_days.id, angajati.id FROM work_days ";
    $query1 .= "INNER JOIN angajati ON work_days.id_angajat=angajati.id ";
    $query1 .= "WHERE submission_date = '$date' AND work_days.deleted='0' ";
    $query1 .= "ORDER BY angajati.surname ASC ";
    $result1 = mysqli_query($connection, $query1);
    if (!$result1) {
        die("Errore la selectarea ID-urilor la ANGAJATI din WORK_DAYS dupa data! functia select_workdays_by_date".mysqli_error($connection));
    };
    $x = [] ;
    while ($id = mysqli_fetch_assoc($result1)) {
        if (in_array($id['id'], $x)){
            continue;
        }
        $x[] = $id['id'];
    }

    return $x;
}
// selecteaza toate ID-urile din agajati,
//si le ordoneaza dupa prenume
//se poate adauga si query mai departe
//se foloseste in achitare.php.
function select_all_id($connection, $query2){
    $aid =[];
    $query = "SELECT id FROM angajati WHERE deleted = '0' $query2";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die(" nu a s-a reusit conectarea la db, id angajati".mysqli_error($connection));
    }
    while ($id = mysqli_fetch_assoc($result)){
        $aid[]= $id['id'];
    }
    return $aid;
}
// Gaseste ultima lichidare dupa ID-urile din $AID,
// creaza un array cu detaliile despre ultima plata si
// calculeaza soldurile de la ultima lichidare pana la zi.
function calc_total($connection, $aid){
    $final = [];
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
        $query = "SELECT lichidare.id_angajat, lichidare.id, lichidare.platit, lichidare.sold, angajati.surname, angajati.name, lichidare.data FROM lichidare ";
        $query .= "INNER JOIN angajati ON lichidare.id_angajat=angajati.id ";
        $query .= "WHERE lichidare.deleted='0' AND id_angajat ='$i' ";
        $query .= "ORDER BY lichidare.data DESC LIMIT 1 ";

        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("Errore in baza de date la crearea listei de angajati pentru salarii cu id ='$i' : " . mysqli_error($connection));
        };
        while ($candidat = mysqli_fetch_assoc($result)) {
            $vdt = date_create($candidat['data']);
            $ban[$i] = [
                "aid" => $candidat['id_angajat'],
                "num" => $candidat['surname'] . " " . $candidat['name'],
                "lid" => $candidat['id'],
                "dat" => $candidat['data'],
                "pla" => $candidat['platit'],
                "sol" => $candidat['sold'],
                "cre" => $ban[$i]['cre'],
                "sal" => $ban[$i]['sal'],
                "dif" => $ban[$i]['dif'],
                "vdt" => date_format($vdt, "d M, l"),
                "temp" => $ban[$i]['temp']];

        }
        $dat1 = $ban[$i]['dat'];
        // Sumeaza creantele
        $query = "SELECT id_angajat, sum_creanta, data FROM creante  ";
        $query .= "WHERE id_angajat = '$i' AND deleted = '0' AND data BETWEEN '$dat1' AND '$dat2'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("nu s-a reusit conenctarea la salrii $i : " . mysqli_error($connection));
        }
        while ($bani = mysqli_fetch_assoc($result)) {
            $ban[$i]['cre'] += $bani['sum_creanta'];
            //$ban[$i]['dcre'] += $bani['data'];
            //  $ban[$i]['icre'] = $bani['id_angajat'];

        }
        // verifica daca exista cel putin o inregistrare
        if (mysqli_affected_rows($connection) == 0) {
            $ban[$i]['cre'] = 0;
        };
        // Sumeaza salariile

        $query = "SELECT suma, id_angajat, data FROM salarii  ";
        $query .= "WHERE id_angajat ='$i' AND deleted = '0' AND platit = '0' AND data BETWEEN '$dat1' AND '$dat2'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("nu s-a reusit conenctarea la salrii $i : " . mysqli_error($connection));
        }
        while ($bani = mysqli_fetch_assoc($result)) {
            $ban[$i]['sal'] += $bani['suma'];
            $ban[$i]['dif'] = $ban[$i]['sal'] - $ban[$i]['cre'];
        }
        // verifica daca exista cel putin o inregistrare
        $af_rows = mysqli_affected_rows($connection);
        if (mysqli_affected_rows($connection) == 0) {
            $ban[$i]['sal'] = 0;
            $ban[$i]['dif'] = $ban[$i]['sal'] - $ban[$i]['cre'];
        };
    }

    echo " end for<br>";
    print_r($ban);
    return $ban ;
}