<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
?>
<?php
require_once "../includes/layout/session.php";
$title = "Angajat nou";
$page = "new_emp";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../includes/add_pers_db.php";
$baloon = status_baloon();
?>

    <main class="container">
<?= $baloon; ?>

        <div class="panel panel-default">
            <div class="panel-heading" id="panel"><label for="panel" class="h4">Adauga un angajatat: </label></div>
            <hr>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <!--Prenume -->
                <div class="<?= $status["surname"]; ?>">
                    <label for="surname" class="control-label col-sm-2 col-md-2 col-lg-1">*Prenume:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-user form-control-feedback"></span>
                        <input type="text" name="surname" class="form-control" id="surname" placeholder="Prenume"
                               value="<?php if (isset($surname)) {
                                   echo $surname;
                               }; ?>" required>
                    </div>
                </div>
                <!--Al doilea prenume -->
                <div class="<?= $status["middle"]; ?>">
                    <label for="middle_name" class="control-label col-sm-2 col-md-2 col-lg-1">Mijlociu:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-user form-control-feedback"></span>
                        <input type="text" name="middle" class="form-control" id="middle_name"
                               placeholder="Nume mijlociu"
                               value="<?php if (isset($middle)) {
                                   echo $middle;
                               }; ?>">
                    </div>
                </div>
                <!--Nume -->
                <div class="<?= $status["name"]; ?>">
                    <label for="name" class="control-label col-sm-2 col-md-2 col-lg-1">*Nume:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-user form-control-feedback"></span>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nume"
                               value="<?php if (isset($name)) {
                                   echo $name;
                               }; ?>" required>
                    </div>
                </div>
                <!--CNP -->
                <div class="<?= $status["numar"]; ?>">
                    <label for="CNP" class="col-sm-2 col-md-2 col-lg-1 control-label">CNP:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-barcode form-control-feedback"></span>
                        <input type="number" name="numar" class="form-control" id="CNP" placeholder="CNP"
                               value="<?php if (isset($numar)) {
                                   echo $numar;
                               }; ?>">
                    </div>
                </div>
                <!--Data nasterii -->
                <div class="<?= $status["bday"]; ?>">
                    <label for="bday" class="col-sm-2 col-md-2 col-lg-1 control-label">Data nasterii:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-gift form-control-feedback"></span>
                        <input type="date" name="bday" class="form-control" id="birthDay"
                               value="<?php if (isset($bday)) {
                                   echo $bday;
                               }; ?>">
                    </div>
                </div>
                <!--Gender -->
                <div class="<?= $status["gender"]; ?>">
                    <label for="gender" class="col-sm-2 col-md-2 col-lg-1 control-label">Gen:</label>
                    <div id="gender" class="form-group col-sm-10 col-md-4 col-lg-3">
                        <label for="genderF" class="radio-inline">
                            <input type="radio" name="gender" id="genderF"
                                   value="Female" <?php if (isset($gender) && $gender == "Female") {
                                echo "checked";
                            }; ?>>Fem:</label>
                        <label for="genderM" class="radio-inline">
                            <input type="radio" name="gender" id="genderM"
                                   value="Male" <?php if (isset($gender) && $gender == "Male") {
                                echo "checked";
                            }; ?>>Masc:</label>
                        <label for="genderN" class="radio-inline">
                            <input type="radio" name="gender" id="genderN"
                                   value="None" <?php if (!isset($gender) || $gender == "None") {
                                echo "checked";
                            }; ?>>N/A:</label>
                        <span class="form-control-feedback glyphicon glyphicon-heart"></span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!--Tel. Mobil -->
                <div class="<?= $status["tel_mob"]; ?>">
                    <label for="tel_mob" class="col-sm-2 col-md-2 col-lg-1 control-label">Tel. Mobil:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        <input type="tel" name="tel[mob]" class="form-control" id="tel_mob" placeholder="Tel. Mobil:"
                               value="<?php if (isset($tel['mob'])) {
                                   echo $tel['mob'];
                               }; ?>">

                    </div>
                </div>
                <!--Tel. Fix -->
                <div class="<?= $status["tel_fix"]; ?>">
                    <label for="tel_fix" class="col-sm-2 col-md-2 col-lg-1 control-label">Tel. Fix:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group">
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        <input type="tel" name="tel[fix]" class="form-control" id="tel_fix" placeholder="Tel. Fix"
                               value="<?php if (isset($tel['fix'])) {
                                   echo $tel['fix'];
                               }; ?>">

                    </div>
                </div>
                <!--Localitate -->
                <div class="<?= $status["cities"]; ?>">
                    <label for="cities" class="col-sm-2 col-md-2 col-lg-1 control-label">Localitate:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-home form-control-feedback"></span>
                        <input list="cities" name="cities" class="form-control" placeholder="Localitatea"
                               value="<?php if (isset($cities)) {
                                   echo $cities;
                               }; ?>">
                        <datalist id="cities">
                            <option value="Mereni">
                            <option value="Chirca">
                            <option value="Merenii Noi">
                            <option value="Chetrosu">
                            <option value="Maximovca">
                        </datalist>
                    </div>
                </div>
                <!--Data angajarii -->
                <div class="<?= $status["hire_dat"]; ?>">
                    <label for="hire_dat" class="col-sm-2 col-md-2 col-lg-1 control-label">Data angajarii</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-calendar form-control-feedback"></span>
                        <input type="date" name="hire_dat" class="form-control" id="hire_dat"
                               value="<?php if (isset($hire_dat)) {
                                   echo $hire_dat;
                               }; ?>">
                    </div>
                </div>
                <!--Situatie angajare/ Tip colaborare -->
                <div class="<?= $status["type_em"]; ?>">
                    <label for="type_em" class="control-label col-sm-2 col-md-2 col-lg-1">Colaborare:</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-user form-control-feedback"></span>
                        <select class="form-control" name="type_em">
                            <option value="angajat" <?php if (!isset($_POST['type_em']) || $_POST['type_em'] == "0") {
                                echo "selected";
                            } ?>>Tip contract:
                            </option>
                            <option value="angajat" <?php if (isset($_POST['type_em']) && $_POST['type_em'] == "angajat") {
                                echo "selected";
                            } ?>>Angajat
                            </option>
                            <option value="temp" <?php if (isset($_POST['type_em']) && $_POST['type_em'] == "temp") {
                                echo "selected";
                            } ?>>Temporar
                            </option>
                            <option value="child" <?php if (isset($_POST['type_em']) && $_POST['type_em'] == "child") {
                                echo "selected";
                            } ?>>Minor
                            </option>
                        </select>
                    </div>
                </div>
                <!--Numar polita asigurare -->
                <div class="<?= $status["insurance"]; ?>">
                    <label for="CNP" class="col-sm-2 col-md-2 col-lg-1 control-label">Asigurare</label>
                    <div class="col-sm-10 col-md-4 col-lg-3 form-group"><span
                                class="glyphicon glyphicon-barcode form-control-feedback"></span>
                        <input type="number" name="insurance" class="form-control" id="CNP" placeholder="Nr. Asigurare"
                               value="<?php if (isset($insurance)) {
                                   echo $insurance;
                               }; ?>">
                    </div>
                </div>
                <!--Comentarii/Detalii -->
                <label for="comment" class="col-sm-2 col-md-2 col-lg-1 control-label">Detalii</label>
                <div class="col-sm-10 col-md-10 col-lg-11 form-group"><span
                            class="glyphicon glyphicon-comment form-control-feedback"></span>
                    <textarea name="comment" class="form-control" id="comment"
                              placeholder="Detalii suplimentare"><?php if (isset($comment)) {
                            echo $comment;
                        }; ?></textarea>
                </div>

                <!--Foc la ghete -->
                <div class="col-md-12 col-lg-12"></div>
                <button type="submit" name="submit" class="btn btn-lg btn-success btn-group-justified" id="submit">
                    Inregistreaza <span class="glyphicon glyphicon-plus-sign"></span></button>
            </form>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php" ?>