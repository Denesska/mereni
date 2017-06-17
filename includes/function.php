<?php
require_once "../classes/Database.php";

// Afiseaza statusul operatiunii
function status_baloon()
{
    $output = null;
    if (isset($_SESSION["message"])) {
        $output = "<div id=\"status_baloon\"class=\"alert alert-";
        $output .= $_SESSION['status'];
        $output .= "\" role=\"alert\" onclick=\"removeStatus()\"><span class=\"glyphicon ";
        $output .= $_SESSION['icon'];
        $output .= "\"></span>";
        $output .= $_SESSION['message'];
        $output .= "</div>";
    }
    $_SESSION['status'] = $_SESSION['message'] = $_SESSION['icon'] = null;
    return $output;
}

//filtreaza campurile introduse
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_string($field)
{
    if (isset($field) && !empty($field)) {
        $field = strtolower($field);
        $field = ucfirst($field);
        $field = preg_replace('/\s+/', '', $field);
    } else {
    }
    return ($field);
}

// Valideaza numarul de telefon, inclusiv lungime si tip
function validate_phone_num($nr)
{
    $tel = preg_replace('/\D+/', '', $nr);
    if (substr($tel, 0, 1) !== '0') {
        $int = substr_replace($tel, "0", 0, 0);
    }
    $tel = substr_replace($tel, " 0 ", 0, 1);
    $tel = wordwrap($tel, 3, ' ', true);
    if (strlen($tel) != 13) {
        $status['sta'] = "has-warning";
        $status['err'] = 1;
        $_SESSION['message'] = "Atentie! Numarul de telefon trebuie sa aiba exact 10 cifre";
        $_SESSION['status'] = "warning";
        $_SESSION['icon'] = "glyphicon-phone-alt";
    } else {
        $status['sta'] = "has-success";
        $status['err'] = null;
    }
    $status['tel'] = $tel;
    return $status;
}

function email_format($string)
{
    if (filter_var($string, FILTER_VALIDATE_EMAIL) === false) {
        $error_text = "email";
    } else {
        $error_text = "";
    }
    return ($error_text);
}

// Prepara stringul pentru DB
function escaped_str($string)
{
    $safe_string = Database::getInstance()->getConnection()->real_escape_string($string);
    return $safe_string;
}

//Formateaza data in formatul dorit pentru afisare
function format_data_out_db($db_date_column)
{
    $formatted_date = "DATE_FORMAT($db_date_column, '%a %d %m %Y') ";
    return $formatted_date;
}

//Formateaza data pentru browser in Romana
function translate_date_to_ro($date_eng)
{
    $days_of_week = ['Mon' => 'Luni,', 'Tue' => 'Marti,', 'Wed' => 'Miercuri,', 'Thu' => 'Joi,', 'Fri' => 'Vineri,', 'Sat' => 'Sambata,', 'Sun' => 'Duminica,'];
    $months_of_year = ['01' => 'Ian', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mai', '06' => 'Iun', '07' => 'Iul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Noi', '12' => 'Dec'];
    $date_eng = explode(" ", $date_eng);
    $date_eng[0] = $days_of_week[$date_eng[0]];
    $date_eng[2] = $months_of_year[$date_eng[2]];
    $date_ro = implode(" ", $date_eng);
//print_r($date_ro);
    return $date_ro;
}

//Formateaza data pentru browser in Romana
function remove_day_from_date_and_format($date_in)
{
//print_r($date_ro);
    // $date_out = substr_replace($date_in, "", 4);
    $date_in = explode(' ', $date_in);
    $date_out = $date_in[3] . "-" . $date_in[2] . "-" . $date_in[1];
    return $date_out;
}

//Formateaza data in formatul dorit pentru introducere
function format_data_in($string_date)
{
    // $formatted_date = "DATE_FORMAT($db_date_column, '%a, %e %b %Y ')";
    $temp = strtotime($string_date);
    $date = date('Y-m-d', $temp);
    $date = DateTime::createFromFormat('D, j M Y', $temp)->format('Y-m-d');
    print_r($date);
    return $date;
}

// returneaza daca a fost selectat o optiune din lista sau nu  // SELECTED
function selected($id, $row_num, $field, $backup_array)
{
    if (isset($backup_array['success']) && $id == $backup_array[$row_num][$field]) {
        return $selected = "selected";
    }
    return $selected = "";
}


// Functii DB !!!


// Selecteaza numele la toti angajatii din DB
function select_all_employee()
{
    $name = null;
    $query = " SELECT id, surname, name FROM angajati WHERE deleted=0 ORDER BY surname";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        $status_text = Database::getInstance()->getConnection()->error;
        ?>
        <p id="status_baloon" class="bg-danger alert h3"><?= $status_text ?></p> <?php
        die();
    }
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name[$id] = $row['surname'] . " " . $row['name'];
    }
    $result->free_result();
    return $name;
}

//Selecteaza datele angagajatilor dupa ID
function select_employee_personal_data($id_employee)
{
    $id_secure = Database::getInstance()->getConnection()->real_escape_string($id_employee);
    $emp_data = null;
    $query = "SELECT *
              FROM angajati
              WHERE id = $id_secure";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        $status_text = Database::getInstance()->getConnection()->error;
        ?>
        <p id="status_baloon" class="bg-danger alert h3"><?= $status_text ?></p> <?php
        die();
    }
    while ($row = $result->fetch_assoc()) {

        $emp_data['surname'] = $row['surname'];
        $emp_data['name'] = $row['name'];
        $emp_data['middle'] = $row['middle'];
        $emp_data[1] = array($row['cnp'], "Nr identificare :");
        $zdn = date_create($row['birth_day']);
        $emp_data[2] = array(date_format($zdn, "d.m.Y"), "Data nasterii :");
        $emp_data[3] = array($row['tel_fix'], "Telefon fix :");
        $emp_data[4] = array($row['telefon'], "Telefon mobil :");
        $emp_data[5] = array($row['cities'], "Localitate :");
        $ang = date_create($row['hire_date']);
        $emp_data[6] = array(date_format($ang, "d.m.Y"), "Data angajarii :");
        $emp_data[7] = array($row['type_em'], "Tip contract :");
        $emp_data[8] = array($row['insurance'], "Nr asigurare");
        $emp_data[9] = array($row['comments'], "Observatii");
        $emp_data['gen'] = $row['gender'];
        $emp_data['hday'] = $row['hire_date'];
        $emp_data['bday'] = $row['birth_day'];
    }
    $result->free_result();
    return $emp_data;
}

// Selecteaza activitatile si ID-urile corespunzatoare
function select_activity()
{
    $locatie = null;
    $query = "SELECT id, locatie FROM cozagro_db.loc_activitate ";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Errore in baza de date.");
    };
    while ($activity = mysqli_fetch_assoc($result)) {
        $locatie[$activity['id']] = $activity['locatie'];
    }
    $result->free_result();
    return $locatie;
}

// Selecteaza toti angajatii care lucreaza pentru fiecare zi in parte si uneste inca 2 tabele
function list_day_work($date)
{
    Database::getInstance()->getConnection()->real_escape_string($date);
    // Scoate id_urile din zilele lucrate dupa data
    $row = [];
    $query = "SELECT wd.id, angajati.surname, angajati.name, loc_activitate.locatie, wd.comment FROM cozagro_db.work_days wd
    INNER JOIN cozagro_db.angajati angajati ON wd.id_angajat=angajati.id 
    INNER JOIN cozagro_db.loc_activitate loc_activitate ON wd.id_loc_activitate=loc_activitate.id 
    WHERE DATE_FORMAT(submission_date, '%d - %c - %Y') = '$date' AND wd.deleted='0'
    ORDER BY angajati.surname ASC ";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Errore la extragere pentru zilele de lucru in function.php" . Database::getInstance()->getConnection()->error);
    };

    $i = 0;
    while ($dates = $result->fetch_assoc()) {

        $row[$i] = ["id_work_days" => $dates['id'],
            "nume" => $dates['surname'] . " " . $dates['name'],
            "loc_activitate" => $dates['locatie'],
            "comment" => $dates['comment']];

        //Identifica numele angajatului dupa ID

        $i++;
    }
    $result->free_result();
    return $row;
}

// Selecteaza zilele trecute prelucrate, trecute spre achitare in tabelul salarii.
function s_d_salarii_platit()
{
    // selecteaza datele platite deja din salarii
    $submission_date = format_data_out_db('submission_date');
    $query_sal = "SELECT DISTINCT  $submission_date AS date_db
                  FROM cozagro_db.work_days 
                  WHERE work_days.deleted = 0 AND completed = 0
                  ORDER BY submission_date DESC ";
    $result_sal = Database::getInstance()->getConnection()->query($query_sal);
    if (!$result_sal) {
        die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
    }
    $salary = [];
    while ($sal = $result_sal->fetch_assoc()) {
        $salary[] = [remove_day_from_date_and_format($sal['date_db']), translate_date_to_ro($sal['date_db'])];
    }
    $result_sal->free_result();
    return $salary;
}

// Verifica username si parola pentru logare
function login($user, $pass)
{ $hash= null;
    if (isset($_POST['submit'])) {
        $user = escaped_str($_POST['user']);
        $pass = ($_POST['pass']);
        $query = "SELECT hash FROM login WHERE user='$user' LIMIT 1";
        $result = Database::getInstance()->getConnection()->query($query);
        if (!$result) {
            $status_text = Database::getInstance()->getConnection()->error;
            ?>
            <p id="status_baloon" class="bg-danger alert h3"><?= $status_text ?></p> <?php
            die();
        }
        while ($db_hash = $result->fetch_assoc()){
           $hash = $db_hash['hash'];
        }
        if (password_verify($pass, $hash)) {
            setcookie('user', $user, time() + (60 * 60));
            $_SESSION['user'] = ucfirst($user);
            $_SESSION['start'] = time();
            $_SESSION['expire'] = time() + (60 * 60);
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Bine ai veni din nou in Program";
            $_SESSION['icon'] = "glyphicon-check";
            header('Location: http://localhost/cozagro/public/index.php');
            exit();
        } else {
            $_SESSION['status'] = "danger";
            $_SESSION['message'] = "Userul sau Parola sunt gresite sau nu exista!";
            $_SESSION['icon'] = "glyphicon-exclamation-sign";
        }
    }
}

// Selcteaza selecteaza suma zilelor lucrate/lipsite/motivate si suma salriului grupat pe luni.
function work_data_emp($id)
{
// selecteaza datele platite deja din salarii
    $query = "SELECT sum(salarii.prezent) AS lucratez, 
                    (DATE_FORMAT(LAST_DAY(data),'%d') - sum(salarii.prezent)) AS absent, 
                    sum(motiv) AS motivat, 
                    sum(suma) AS salarii, 
                    DATE_FORMAT(data, '%m') AS data
                    FROM cozagro_db.salarii 
                    WHERE salarii.deleted = 0 AND salarii.id_angajat= $id
                    GROUP BY MONTH(data)";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
    }
    $zile_lucrate = [];
    while ($x = $result->fetch_assoc()) {
        $zile_lucrate[$x['data']] = array("luc" => $x['lucratez'], "abs" => $x['absent'], "mot" => $x['motivat'], "sal" => $x['salarii']);
    }
    $result->free_result();
    return $zile_lucrate;
}
// Selcteaza suma creantelor grupate pe luni.
function sum_salarii_moth_group_emp($id)
{
    $query = "SELECT count(platit) AS plati, sum(platit) AS suma, DATE_FORMAT(data, '%m') AS data, sum(motiv) AS motivat
                    FROM cozagro_db.salarii WHERE deleted = 0 AND id_angajat= $id
                    GROUP BY MONTH(data)";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
    }
    $creante_luna = [];
    while ($x = $result->fetch_assoc()) {
        $creante_luna[$x['data']] = array("nr" => $x['plati'], "sum" => $x['suma'], "mot" => $x['motivat']);
    }
    $result->free_result();
    return $creante_luna;
}
// Selcteaza suma creantelor grupate pe luni.
function sum_creante_moth_group_emp($id)
{
    $query = "SELECT count(sum_creanta) AS creante, sum(sum_creanta) AS suma, DATE_FORMAT(data, '%m') AS data
                    FROM cozagro_db.creante WHERE deleted = 0 AND id_angajat= $id
                    GROUP BY MONTH(data)";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
    }
    $creante_luna = [];
    while ($x = $result->fetch_assoc()) {
        $creante_luna[$x['data']] = array("nr" => $x['creante'], "cre" => $x['suma']);
    }
    $result->free_result();
    return $creante_luna;
}

// Selcteaza suma salariilor grupate pe luni.
function sum_plati_moth_group_emp($id)
{
    $query = "SELECT count(platit) AS plati, sum(platit) AS suma, DATE_FORMAT(data, '%m') AS data, comment
                    FROM cozagro_db.lichidare WHERE deleted = 0 AND id_angajat= $id
                    GROUP BY MONTH(data)";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu s-a reusit conexiunea la DB selectarea salariilor platite" . Database::getInstance()->getConnection()->error);
    }
    $lichidare_luna = [];
    while ($x = $result->fetch_assoc()) {
        $lichidare_luna[$x['data']] = array("nr" => $x['plati'], "pla" => $x['suma'], "com" => $x['comment']);
    }
    $result->free_result();
    return $lichidare_luna;
}


// FUNCTII PENTRU AFISARE DATE CREATE DINAMIC


// Afiseaza in lista toti angajatii si selecteaza cel activ
function display_list_emp($employees)
{
    $li_out = null;
    foreach ($employees as $id => $name) {
        $li_out = "<a class='list-group-item ";
        if (isset($_GET['id']) && $_GET['id'] == $id) {
            $li_out .= "active";
        }
        $li_out .= "' href='angajati.php?id=$id'>$name</a>";
        echo $li_out;
    }
    return;
}

// Afiseaza datele personale fiecarui angajat dupa ID
function display_emp_personal_data()
{
    if (isset($_GET['id'])) {
        $emp_data = select_employee_personal_data(escaped_str($_GET['id'])); ?>
        <div class="personal-data">
            <p class="h3">Date personale ale angajatului: <i class="text-black-strong">
                    <?= $emp_data['surname'] . " " . $emp_data['name'] . " " . $emp_data['middle'] . " " ?></i>
                <a class="small red" href="angajat_edit.php?id=<?= $_GET['id'] ?>"
                   title="Editeaza datele personale ale angajatului">editeaza</a></p>
            <hr>
            <?php for ($i = 1; $i <= 9; $i++) { ?>
                <p class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-muted">- <?= $emp_data[$i][1] ?> <i
                            class="text-black-strong"><?= $emp_data[$i][0] ?> </i></p>
            <?php } ?>
            <div class="clearfix"></div>
            <hr>
        </div>
        <?php
    } else {
        echo "<h2>Alege un angajat pentrua  vedea detalii</h2>";
    }
    return;
}

// Adiseaza toate salariile si zilele prezente/absente pe fiecare luna
function display_work_info_month($months)
{
    ?>
    <thead>
    <tr>
        <th>Luna</th>
        <th>Lucrat</th>
        <th>Absent</th>
        <th>Salariu</th>
        <th>Avans</th>
        <th>Platit</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $y[0] = $y[1] = $y[2] = $y[3] = $y[4] = $y[5] = 0;
    $mon = array("01" => "IAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAI", "06" => "IUN", "07" => "IUL", "08" => "AUG", "09" => "SEP", "10" => "OCT", "11" => "SEP", "12" => "DEC");
    $nr =null;
    foreach ($months as $nr => $data) {
        ?>
        <tr>
                <th  id="<?= $_GET['id']."&&month=$nr"; ?>"><?= $mon[$nr] ?></th>
                <td><?php if (!isset($data['luc'])) {
                        $data['luc'] = $data['abs'] = $data['mot'] = $data['sal'] = 0;
                    }
                    echo $data['luc'] ?> zile
                </td>
                <td><?= $data['abs'] ?> zile &nbsp;
                    <span class="badge<?php if ($data['mot'] > 0) {
                        echo " danger";
                    } ?>"><?= $data['mot'] ?></span></td>
                <td><?= $data['sal'] ?> MDL</td>
                <td><?php if (!isset($data['cre'])) {
                        $data['cre'] = 0;
                    }
                    echo $data['cre'] ?> MDL
                </td>
                <td><?php if (!isset($data['pla'])) {
                        $data['pla'] = 0;
                    }
                    echo $data['pla'] ?> MDL
                </td>
        </tr>
        <?php
        $y[0] += $data['luc'];
        $y[1] += $data['abs'];
        $y[2] += $data['mot'];
        $y[3] += $data['sal'];
        $y[4] += $data['cre'];
        $y[5] += $data['pla'];
    } ?>
    </tbody>
    <tfoot class="total">
    <tr>
        <th>Total/6</th>
        <td><?= $y[0] ?> zile</td>
        <td><?= $y[1] ?> zile &nbsp;
            <span class="badge<?php if ($y[2] > 0) {
                echo " danger";
            } ?>"><?= $y[2] ?></span></td>
        <td><?= $y[3] ?> MDL</td>
        <td><?= $y[4] ?> MDL</td>
        <td><?= $y[5] ?> MDL</td>
    </tr>
    </tfoot>
<?php }

// $data = format_data_in('Wed 7 Jun 2017');
