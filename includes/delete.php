<?php
require_once "../classes/Database.php";
/**
 * Created by PhpStorm.
 * User: denesska
 * Date: 19-May-17
 * Time: 6:24 PM
 */
// Sterge angajatii din baza de date de la zilele lucrate.

$_POST['remove_id'];
if(isset($_POST['remove_id'])) {

    // Formeaza query
    $query = ("UPDATE work_days SET  deleted=1 WHERE id = ".$_POST['remove_id']);

    // Verifica daca este scris corect query
    $result = Database::getInstance()->getConnection()->query($query);
    if (!$result){
        die("Nu s-a putut conecta la baza de date".Database::getInstance()->getConnection()->error);
    }

    // deconectarea de la DB
    Database::getInstance()->getConnection()->close();

    // redirectioneaza pagina
    echo "acum trebuie sa redirectioneze";
    header("location: /lucru_zi.php");
    exit();
} else{
    echo "nu este setat get";
}
