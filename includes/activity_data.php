<?php
/**
 * Created by PhpStorm.
 * User: denes
 * Date: 08-Jun-17
 * Time: 2:09 PM
 */
require_once "function.php";

$mon = array("01" => "IAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAI", "06" => "IUN", "07" => "IUL", "08" => "AUG", "09" => "SEP", "10" => "OCT", "11" => "SEP", "12" => "DEC");
$nr = null;
$tabs = array("Total", "Lucrat", "Produs", "Cumparat", "Platit");

if (isset($_GET['id'])) {
    $id = htmlentities($_GET['id']);
    $tab = htmlentities($_GET['tab']);
    echo "<ul class=\"nav nav-tabs\">";
    foreach ($tabs as $tab_nr => $tab_nm) { ?>
        <li role="presentation" onclick="displayActivityTabs(<?= $tab_nr ?>)"
            class="<?php if ($tab == $tab_nr) {
                echo "active";
            } ?>">
            <p><?= $tab_nm ?></p>
        </li>
        <?php
    }
    echo "</ul>";
    if ($tab == 0) {
        echo "<table class=\"table\">";
        $work_months = work_data_emp($id);
        $cre_months = sum_creante_moth_group_emp($id);
        $pla_months = sum_plati_moth_group_emp($id);
        $months = array_merge_recursive($work_months, $cre_months, $pla_months);
        display_work_info_month($months);
        echo "</table>";
    } else {
        if ($tab == 1) {
            $months = work_data_emp($id); ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Luna</th>
                    <th>Lucrat</th>
                    <th>Absent</th>
                    <th>Salariu</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($months as $nr => $data) { ?>
                    <tr>
                        <th colspan="2" id="<?= $id . "&&tab=$tab&&month=$nr"; ?>"
                            onclick="getEmployeeActivityByDat(this)">
                            <?= $mon[$nr] ?>
                        </th>
                        <td><?php if (!isset($data['luc'])) {
                                $data['luc'] = $data['abs'] = $data['mot'] = $data['sal'] = 0;
                            }
                            echo $data['luc'] ?> zile
                        </td>
                        <td><?= $data['abs'] ?> zile &nbsp;
                            <span class="badge<?php if ($data['mot'] > 0) {
                                echo " danger";
                            } ?>"><?= $data['mot'] ?></span>
                        </td>
                        <td><?= $data['sal'] ?> MDL
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } elseif ($tab == 2) {
            $months = sum_salarii_moth_group_emp($id); ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Luna</th>
                    <th>Nr de plati</th>
                    <th>Suma</th>
                    <th>Abs. nemotivate</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($months as $nr => $data) { ?>
                    <tr>
                        <th colspan="2" id="<?= $id . "&&tab=$tab&&month=$nr"; ?>"
                            onclick="getEmployeeActivityByDat(this)"><?= $mon[$nr] ?>
                        </th>
                        <td><?= $data['nr'] ?> plati</td>
                        <td><?= $data['sum'] ?> MDL</td>
                        <td><?= $data['mot'] ?> absente</td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
            <?php
        } elseif ($tab == 3) {
            $months = sum_creante_moth_group_emp($id); ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Luna</th>
                    <th>Cumparaturi</th>
                    <th colspan="2">Suma</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($months as $nr => $data) { ?>
                    <tr>
                        <th colspan="2" id="<?= $id . "&&tab=$tab&&month=$nr"; ?>"
                            onclick="getEmployeeActivityByDat(this)"><?= $mon[$nr] ?>
                        </th>
                        <td><?= $data['nr'] ?> cumparaturi</td>
                        <td colspan="2"><?= $data['cre'] ?> MDL</td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
            <?php
        } elseif ($tab == 4) {
            $months = sum_plati_moth_group_emp($id); ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="2">Luna</th>
                    <th>Nr Plati</th>
                    <th>Suma</th>
                    <th>Detalii</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($months as $nr => $data) { ?>
                    <tr>
                        <th colspan="2" id="<?= $id . "&&tab=$tab&&month=$nr"; ?>"
                            onclick="getEmployeeActivityByDat(this)"><?= $mon[$nr] ?>
                        </th>
                        <td><?= $data['nr'] ?> plati</td>
                        <td><?= $data['pla'] ?> MDL</td>
                        <td></td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
            <?php
        }

    }
}