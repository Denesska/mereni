<?php
require_once "../classes/Database.php";
require_once "../includes/function.php";
require "../includes/for_ajax.php";
if (isset($_POST['fun'])){
       $date = $_POST['date'];
    $db_fun = $_POST['fun'];
    $total = null;
    ?>
    <thead class="thead-inverse">
    <tr>
        <th><strong>#</strong></th>
        <th>Nume prenume</th>
        <th>Prezenta si explicatii</th>
        <th>Salariu</th>
    </tr>
    </thead>
    <tfoot>
    <tr><td colspan="4">
            <div class="col-lg-12">
                <button class="btn btn-default btn-success btn-group-justified" type="submit" name="submit"
                        value="submit">Adauga datele pentru toata ziua
                </button>
            </div><!-- /.col-lg-12 -->
        </td></tr>
    </tfoot>
    <!-- Continutul tabelului -->
        <tbody id="tbody_1">
        <?php
    //Selecteaza ID-urile la angajatii din salarii dupa data si sorteaza dupa numele ang.
        if ($db_fun == "update") {
            $total = select_salarii_by_date($date);
        }
        if (!$total){
            // Anuleaza functia de update
            $db_fun = "insert";
            //Selecteaza angajatii din work_days dupa data.
            $list_id = select_workdays_by_date($date);
            // Gaseste ultima lichidare dupa ID-urile din $AID,
            // creaza un array cu detaliile despre ultima plata si
            // calculeaza soldurile de la ultima lichidare pana la zi.
            $total = calc_total($list_id);
        }

        // $i este contorul de randuri
        $i = 0;
        // afisam toate randurile cu informatiile la angajati
        foreach ($total as $id => $candidat ){
            echo $i++;
        ?>
        <tr class="tbody input_row "  id="<?= $i ?>">
            <!-- Prezenta si explicatii -->
            <td class="td1"><?= $i ?></td>
            <!-- Nume candidat -->
            <?php ?>
            <td class="h3"><p ><?= $candidat['num'];?><input type="number" name="data[<?=$i?>][id]" style="display: none" value="<?= $candidat['aid']?>" title="Numele lucratorului"></p></td>
            <!-- Prezenta  -->
            <td class=""><div class="input-group">
                      <span class="input-group-addon">
                          <!-- nemotivat -->
                        <input name="data[<?=$i?>][abs]" type="checkbox" title="absent nemotivat"
                               onchange="addDisabled(this)" <?php if (isset($candidat['sum'])&&$candidat['mot'] == 1){echo "checked";}?> >
                      </span>
                    <input type="text" name="data[<?= $i ?>][exp]" class="form-control" title="detalii referitor la prezenta sau absenta"
                           value="<?php if (isset($candidat['sum'])&&$candidat['det']){echo $candidat['det'];}?>">
                </div></td>

            <!-- Salariu -->
            <td class=""><div class="input-group">
                    <input type="number" name="data[<?= $i ?>][sal]" class="form-control salar" title="Salariu pentru ziua curenta"
                           value="<?php if(isset($candidat['sum'])&&$candidat['sum']!==0){echo $candidat['sum'];}else{ echo "100";}?>"<?php if (isset($candidat['sum'])&&$candidat['mot'] == 1){echo "disabled";}?>>
                    <span class="input-group-addon"> MDL </span></div></td>


            <?php } ?>
        </tbody>
<?php } ?>

