<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 28-May-17
 * Time: 2:54 PM
 */
class muncitor {
    public $id;
}

class angajat extends muncitor {
    public function plateste()
    {

    }
}

class neangajat extends muncitor {
    public function plateste()
    {

    }

}
class minori extends muncitor {
    public function plateste()
    {
        return false;
    }

}

$a = new muncitor();
$a->id;