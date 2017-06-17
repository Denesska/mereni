<?php
require_once "../includes/layout/session.php";
require_once "../classes/Database.php";
$page = "test";
/*
$post=["panume"=>"denis", "prenume"=>"gandzii"];
$req=["nume", "prenume"];

foreach($post as $field => $value){
    $$field = $value;


    echo $panume."<br>";
}
*/
/*
$fields = array("nume" => "de S is", "pre" => "hau", "oras" => "talma ci");
function verify ($fields){
    foreach($fields as $field){
        if(isset($field) && !empty($field)){
            $field = strtolower($field);
            $field = ucfirst($field);
            $field = preg_replace('/\s+/', '',$field);
        }else{
            echo "ceva nu e ok";
        }
        echo $field;
    }
};

verify($fields);

function connect_db(){
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
function db_function(){
    $table = "test";
#$query = "INSERT INTO $table (city, county, reg_date) VALUES ('Mereni', 'Anenii Noi', '1987-04-06')";
    $query = "SELECT * FROM test";
    $result = mysqli_query($connection, $query);
    if(!$result){
        die("Data base query failed!");
    } else {
        echo "success!!!";
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['city']. "<br>";
    };

    mysqli_close($connection);
};

function extract_num($string){
    $int = preg_replace('/\D+/', '', $string);
    if(substr($int, 0, 1) !== '0'){
        $int = substr_replace($int, "0", 0, 0);
    }
    return($int);
}

function check_lenght($string){
    if(strlen($string)==9){
        $lenght = true;
    }else{
        $lenght =false;
    }
    return $lenght;
};

function phone_format($string){
    $string = substr_replace($string, "(0)", 0, 1);
    $string = wordwrap($string , 3 , ' ' , true );
return($string);
};
*
 e = "Zi muncă nouă";
require "../includes/top_page.php";
require "../includes/nav_bar.php";
?>
    <main class="container">
        <?php
        $i=0;
        while ($i<5){
            $date = date('Y-m-d', strtotime("-$i days"));
            list_day_work($connection, $date);
            $i++;
        } ?>
    </main>
<?php require "../includes/bottom_page.php" ?>

<?php/*

// selecteaza  tipurile de avanas dupa id

<select name="data[<?= $i ?>][tip_avans]" class="form-control">
    <option value="0">Alege un tip de avans</option>
    <?php $query = "SELECT id, tip_avans, unitati_masura, valoare FROM tip_avans WHERE deleted='0' ";
    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Errore in baza de date la alegerea tipului de avans".mysqli_error($connection));
    };
    while ($avans = mysqli_fetch_assoc($result)) {
        // $selected = selected($tipuri["id"], $i, "tip_avans", $backup_array, $error);
        echo "<option  value='{$avans['id']}'>{$avans['tip_avans']} : {$avans['unitati_masura']} </option> ";
    } ?></select>
*/
/*
// Conecteaza la baza de date
$dbhost = "localhost";
$dbuser = "admin";
$dbpass = "123Hello";
$dbname = "mercauto_db";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}
$date = "2017-05-06";

$dif = [];
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
print_r($final);
mysqli_close($connection);
*/
/*
$dbhost = "localhost";
$dbuser = "admin";
$dbpass = "123Hello";
$dbname = "mercauto_db";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}
for ($i=1; $i<=8; $i++ ){
$query = "SELECT angajati.surname, angajati.name, lichidare.id, lichidare.curent, lichidare.platit, lichidare.sold, lichidare.data FROM lichidare ";
//$query = "INSERT INTO lichidare angajati.surname, angajati.name, lichidare.id, lichidare.curent, lichidare.platit, lichidare.sold, lichidare.data FROM lichidare ";
$query .= "INNER JOIN angajati ON lichidare.id_angajat=angajati.id ";
$query .= "WHERE deleted='0' AND id_angajat ='$i' ";
$query .= "ORDER BY lichidare.data DESC LIMIT 1 ";

$result = mysqli_query($connection, $query);
if (!$result) {
    die("Errore in baza de date la crearea listei de angajati pentru salarii cu id ='$i' : ".mysqli_error($connection));
};

while ($candidat = mysqli_fetch_assoc($result)) {
    $vdt = date_create($candidat['data']);
    $container[$i] = [
        "lid" => $candidat['id'],
        "num" => $candidat['surname'] . " " . $candidat['name'],
        "cur" => $candidat['curent'],
        "pla" => $candidat['platit'],
        "sol" => $candidat['sold'],
        "dat" => $candidat['data'],
        "vdt" => date_format($vdt, "l, d M")];

}
}
print_r($container);
mysqli_close($connection);
*/
/*
$title = "Verificare TEST";
$page = "achitare";
require "../includes/top_page.php";
require "../includes/nav_bar.php";

$temp =147;
$temp2 = 1;
$key = 0;
$i = 0;

for ($i=1; $i<=8; $i++ ){
    $query = "SELECT angajati.surname, angajati.name, lichidare.id, lichidare.curent, lichidare.platit, lichidare.sold, lichidare.data FROM lichidare ";
//$query = "INSERT INTO lichidare angajati.surname, angajati.name, lichidare.id, lichidare.curent, lichidare.platit, lichidare.sold, lichidare.data FROM lichidare ";
    $query .= "INNER JOIN angajati ON lichidare.id_angajat=angajati.id ";
    $query .= "WHERE deleted='0' AND id_angajat ='$i' ";
    $query .= "ORDER BY lichidare.data DESC LIMIT 1 ";

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Errore in baza de date la crearea listei de angajati pentru salarii cu id ='$i' : ".mysqli_error($connection));
    };

    while ($candidat = mysqli_fetch_assoc($result)) {
        $vdt = date_create($candidat['data']);
        $container[$i] = [
            "lid" => $candidat['id'],
            "num" => $candidat['surname'] . " " . $candidat['name'],
            "cur" => $candidat['curent'],
            "pla" => $candidat['platit'],
            "sol" => $candidat['sold'],
            "dat" => $candidat['data'],
            "vdt" => date_format($vdt, "l, d M")];

    }
}
?>
    <main class="container">
        <div class="panel panel-info">
            <div class="panel-heading ">
                <span class="">Situatii salarii la zi:<span/>
            </div>
            <table id="" class="table table-striped">
                <thead class="thead-inverse tbl-accordion-section"  onclick=toggleClasss(this)>
                <tr><th colspan="6">Informatii despre ultimul salariu platit fiecarui angajat</th></td></tr>
                </thead>
                <tbody class="">
                <tr>
                    <th><strong>#</strong></th>
                    <th>Nume prenume</th>
                    <th>Curent</th>
                    <th>Sold</th>
                    <th >Platit</th>
                    <th>Data</th>
                    <th>Plata</span></th>
                </tr>
                <?php foreach ($container as $key => $row){ ?>
                    <tr class="thead">
                        <td class="">
                            <!-- Lista angajatilor din lichidare -->
                            <form action="../includes/delete.php" method="get" name="<?php echo $key."x".$row['dat']?>" >
                                <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['lid']?>" style="display: none">
                                <input type="submit" name="submits" value="submited" style="display: none">
                                <span onclick="submitOnClick(this)" class="glyphicon glyphicon-remove red" id="<?php echo $key."x".$row['dat']?>"></span> <?= $key; ?>
                            </form>
                        </td>
                        <td class="">
                            <div class="" role="alert">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <?= " ".$row['num']; ?>
                            </div></td>
                        <td class="">
                            <?= $row['cur']; ?> MDL</td>
                        <td class="">
                            <?= $row['sol']; ?> MDL</td>
                        <td class="">
                            <?= $row['pla']; ?> MDL
                        <td class="">
                            <div class="" role="alert">
                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                <?= $row['vdt']; ?>
                            </div></td>
                        <td> <form action="../includes/delete.php" method="get" name="<?php echo $key."x".$row['dat']?>" >
                                <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['lid']?>" style="display: none">
                                <input type="submit" name="submits" value="submited" style="display: none">
                                <span onclick="submitOnClick(this)" class="glyphicon glyphicon-ok-sign red" id="<?php echo $key."x".$row['dat']?>"></span>
                            </form></td>
                    </tr>
                    <?php  $key++; }; ?>
                <tr class="thead">
                    <td class="">
                        <!-- Lista angajatilor din lichidare -->
                        <form action="../includes/delete.php" method="get" name="<?php echo $key."x".$row['dat']?>" >
                            <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['lid']?>" style="display: none">
                            <input type="submit" name="submits" value="submited" style="display: none">
                            <span onclick="submitOnClick(this)" class="glyphicon glyphicon-ok-sign red" id="<?php echo $key."x".$row['dat']?>"></span> <?= $key; ?>
                        </form>
                    </td>
                    <td class="">
                        <div class="" role="alert">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <?= " ".$row['num']; ?>
                        </div></td>
                    <td class="">
                        <?= $row['cur']; ?> MDL</td>
                    <td class="">
                        <?= $row['sol']; ?> MDL</td>
                    <td class="">
                        <?= $row['pla']; ?> MDL
                    <td class="col-lg-2">
                        <div class="input-group " role="alert">
                            <input type="number" name="palata" class="form-control" >
                            <span class="input-group-addon glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                                                   </div></td>
                    <td> <form action="../includes/delete.php" method="get" name="<?php echo $key."x".$row['dat']?>" >
                            <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['lid']?>" style="display: none">
                            <input type="submit" name="submits" value="submited" style="display: none">
                            <span onclick="submitOnClick(this)" class="glyphicon glyphicon-remove red" id="<?php echo $key."x".$row['dat']?>"></span>
                        </form></td>
                </tr>
                </tbody>
            </table>
        </div>
    </main>

<?php require "../includes/bottom_page.php" ?>

*/
// sterge prin ajax un angajat;
/*
<form action="../includes/delete.php" method="get" name="<?php echo $key."x".$row['dat']?>" >
                                    <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['lid']?>" style="display: none">
                                    <input type="submit" name="submits" value="submited" style="display: none">
                                    <span onclick="submitOnClick(this)" class="glyphicon glyphicon-remove red" id="<?php echo $key."x".$row['dat']?>"></span> <?= $key; ?>
</form>
*/
/*
<td><input class="form-control" type="number" name="data[<?= $i ?>][sum_avans]" value="<?php if(isset($_POST['submit'])){ echo $backup_array[$key]['sum_avans'];};?>" placeholder="MDL"></td>
<td><input class="form-control" type="text" name="data[<?= $i ?>][detalii]" value="<?php if(isset($_POST['submit'])){ echo $backup_array[$key]['detalii'];};?>" placeholder="de exemplu cate kg..."></td>
*/

/*
                                    //selecteaza datele din work_days
                                    $query_data = "SELECT submission_date FROM work_days WHERE completed = 0 AND deleted = 0";
                                    $result_data = mysqli_query($connection, $query_data);
                                    if (!$result_data){
                                        die("Nu s-a reusit conexiunea la DB selectarea zilelor de munca".mysqli_error($connection));
                                    }
                                    $container = [];
                                    while ($dates = mysqli_fetch_assoc($result_data)){
                                        if (in_array($dates['submission_date'], $salar)){
                                            continue;
                                        }
                                        if (in_array($dates['submission_date'], $container)) {
                                            continue;
                                        }
                                        $container[] = $dates['submission_date'];
                                    }
                                    rsort($container);
*/
/*
include "../includes/for_ajax.php";
$connection = con_db();
$date = "2017-05-01";
$i = "2, 3, 6";
$x = select_salarii_patite($connection, $date, $i);
print_r($x);

<?php
$title = "Lucrul pe zile";
$page="lucru_zi";
$j=0;
?>
<?php   require "../includes/top_page.php";
require "../includes/nav_bar.php"
?>

    <main class="container">
        <div class="panel panel-info">
            <div class="panel-heading ">
                <span class="">Raport ultimile 5 zile :<span/>
            </div>
            <?php
            $i=0;
            while ($i<5){
                $date = date('Y-m-d', strtotime("-$i days"));
                $datas = list_day_work(Database::getInstance()->getConnection(), $date);
                ?>
                <table id="" class="table table-striped">
                    <thead class="thead-inverse tbl-accordion-section"  onclick=toggleClasss(this)>
                    <tr><th colspan="4"><?= $date ?> </th></td></tr>
                    </thead>
                    <tbody class="">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Nume prenume</th>
                        <th>Activitate</th>
                        <th colspan="2">Comentarii</th>
                    </tr>
                    <?php foreach ($datas as $key => $row){
                        $key++ ?>
                        <tr class="thead">
                            <td class="col-lg-1">
                                <!-- Formul de stergere a angajatilor din work_days -->
                                <form action="../includes/delete.php" method="get" name="<?php echo $key."x".$date?>" >
                                    <input type="number" id="" class="remove_id" name="remove_id" value="<?= $row['id_work_days']?>" style="display: none">
                                    <input type="submit" name="submits" value="submited" style="display: none">
                                    <span onclick="submitOnClick(this)" class="glyphicon glyphicon-remove red" id="<?php echo $key."x".$date?>"></span> <?= $key; ?>
                                </form>
                            </td>
                            <td class="col-lg-3"><?= $row['nume']; ?></td>
                            <td class="col-lg-3"><?= $row['loc_activitate']; ?></td>
                            <td class="col-lg-5"><?= $row['comment']; ?></td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
                <?php
                $i++;
            }
            ?>
        </div>
    </main>

<?php require "../includes/bottom_page.php" ?>

<!-- Total  -->
<td class="" colspan=""><span class="form-control">
                <?= "<strong>".$candidat["cre"]."</strong>"?>MDL</span>
</td>
*/
/*
function data_dif()
{

    $query = "SELECT DISTINCT an.surname,  an.name, lichidare.data, id_angajat, curent, platit, sold, data 
              FROM mercauto_db.lichidare INNER JOIN mercauto_db.angajati an ON id_angajat=an.id
              WHERE lichidare.deleted=0 ";
//
    $result = Database::getInstance()->getConnection()->query($query);

    if (!$result) {
        die("Nu se connectat la lichidari" . Database::getInstance()->getConnection()->error);
    }

    while ($x = $result->fetch_assoc()) {
        $ban[$x['id_angajat']]['num'] = $x['surname'] . " " . $x['name'];
        $ban[$x['id_angajat']]['vdt'] = $x['data'];
        $ban[$x['id_angajat']]['cur'] = $x['curent'];
        $ban[$x['id_angajat']]['sol'] = $x['sold'];
        $ban[$x['id_angajat']]['pla'] = $x['platit'];
    }

    $query = "SELECT id_angajat, SUM( sum_creanta ) AS totalC FROM mercauto_db.creante GROUP BY id_angajat ; ";
    $result = Database::getInstance()->getConnection()->query($query);

    if (!$result) {
        die("Nu se connectat la lichidari" . Database::getInstance()->getConnection()->error);
    }

    while ($x = $result->fetch_assoc()) {
        $ban[$x['id_angajat']]['cre'] = $x['totalC'];
        $ban[$x['id_angajat']]['sal'] = 0;

    }
    $query = "SELECT id_angajat, SUM(suma) AS totalS FROM mercauto_db.salarii GROUP BY id_angajat";
//
    $result = Database::getInstance()->getConnection()->query($query);

    if (!$result) {
        die("Nu se connectat la lichidari" . Database::getInstance()->getConnection()->error);
    }
    while ($x = $result->fetch_assoc()) {
        $id = $x['id_angajat'];
        $ban[$id]['sal'] = $x['totalS'];
        if (!isset($ban[$id]['cre'])) {
            $ban[$id]['cre'] = 0;
        }
    }
print_r($ban);
    foreach ($ban as $id => $value) {
        if (isset($ban[$id]['cre'])){
            $ban[$id]['dif'] = $value['sal'] - $value['cre'];
            $ban[$id]['cre'] = $value['sol'] - $value['cre'];
            $ban[$id]['sal'] = $value['sal'] - $value['sol'];
        }else{
            $ban[$id]['dif'] = 0;
            $ban[$id]['cre'] = 0;
            $ban[$id]['sal'] = 0;
        }

    }

    echo " end for<br>";
    print_r($ban);
    return $ban;

}
include "../includes/top_page.php";
include "../includes/nav_bar.php";
$total = data_dif()
?>
<main class="container">
        <div class="panel panel-info">
            <div class="panel-heading ">
                <span class="">Pentru plata salariilor introduceti suma in ultima casuta ...<span/>
            </div>
                <div id="" class="table table-striped">
                    <div class="thead-inverse tbl-accordion-section"  onclick=toggleClasss(this)>
                    <div class="tr"><div colspan="6">Plata salariilor :</div></td></div>
                    </div>
                    <div class="tbody">
                    <tr>
                        <th><strong>#</strong></th>
                        <th>Nume prenume</th>
                        <th>Produs</th>
                        <th>Cumparat</th>
                        <th>Rest de plata</th>
                        <th>Introdu suma :</th>
                    </tr>
                    <?php $z=0; foreach($total as $key => $row){ $z++?>

    <div class="tr thead">
        <div class="td">
            <!-- Lista angajatilor din lichidare -->
            <?= $z; ?>
        </div>
        <div class="">
            <div class="" role="alert">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <?= " ".$row['num']; ?>
            </div></div>
        <div class="td">
            <?= $row['sal']; ?> MDL</div>
        <div class="td">
            <?= $row['cre']; ?> MDL</div>
        <div class="td">
            <?= $row['dif']; ?> MDL
        <div class="ta">
            <div class="input-group" role="alert">
                <input type="number" class="form-control" name="plata<?= $key; ?>" placeholder="introdu suma pentru plata salariu" value="<?=$row['dif']?>">
                <span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true"></span>
            </div></div>
    </div>
    <?php  $key++; }; ?>
</div>
</div>
</div>
</main>

<?php
include "../includes/bottom_page.php";

$query = "CREATE OR REPLACE VIEW achitare AS SELECT * FROM lichidare ";
$result = Database::getInstance()->getConnection()->query($query);
if (!$result) {
    die("Nu se connectat la lichidari view " . Database::getInstance()->getConnection()->error);

$query = "CREATE OR REPLACE VIEW achitare AS SELECT DISTINCT * FROM lichidare GROUP BY id_angajat";
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result) {
        die("Nu se connectat la lichidari view " . Database::getInstance()->getConnection()->error);
    }
}
*/
/*
$query = "CREATE OR REPLACE VIEW achitare AS ";
$query .= "SELECT  an.surname,  an.name, li.data AS dat, li.id_angajat, li.platit, li.rest
              FROM lichidare AS li  INNER JOIN angajati an ON li.id_angajat=an.id
              WHERE li.deleted=0";
$result = Database::getInstance()->getConnection()->query($query);
if (!$result) {
    die("Nu se connectat la achitari : " . Database::getInstance()->getConnection()->error);
}

$query = "SELECT * 
              FROM achitare AS ac  ";
$result = Database::getInstance()->getConnection()->query($query);
if (!$result) {
    die("Nu se connectat la achitari : " . Database::getInstance()->getConnection()->error);
}

while ($x = $result->fetch_assoc()) {
    $ban[$x['id_angajat']]['num'] = $x['surname'] . " " . $x['name'];
    $ban[$x['id_angajat']]['vdt'] = $x['dat'];
    $ban[$x['id_angajat']]['platit'] = $x['platit'];
    $ban[$x['id_angajat']]['rest'] = $x['rest'];
    $ban[$x['id_angajat']]['id'] = $x['id_angajat'];
}
print_r($ban);
*/
