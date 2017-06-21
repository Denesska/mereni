<?php
require "../includes/for_ajax.php";
require_once  "function.php";
// verifica daca este setata data
if (!isset($_POST['date'])){
    header("Location: /rulaj_zi_nou");
    exit();
}else{
    if (!isset($date)) {
        $backup_array = [1];
        $date = $_POST['date'];
        $error = "success";
    }
    ?>
    <thead class="thead-default">
    <tr>
        <th><strong>#</strong></th>
        <th>Nume prenume</th>
        <th>Creanta</th>
        <th>Suma</th>
    </tr>
    </thead>
    <!-- Continutul tabelului -->
    <tbody id="tbody_1">
    <?php
    //Selecteaza ID-urile la ANGAJATI din WORK_DAYS dupa data si sorteaza dupa numele ang.
    $list_name = select_name_by_workdate($date);
    $i = 0;
    // afisam toate randurile cu informatiile la angajati pe rand
    foreach ($backup_array as $key => $cont ){ ++$i; ?>
        <tr class="tbody input_row "  id="<?= $i ?>">
            <td class="h4 "><?= $i ?></td>
            <td><div class="form-group <?php if(isset($backup_array)){echo $backup_array[$key]['ang']['alert'];}?> has-feedback">
                    <span class="glyphicon <?php if(isset($backup_array)){echo $backup_array[$key]['ang']['icon'];}?>form-control-feedback" aria-hidden="true"></span>
                    <select name="data[<?= $i ?>][angajat]" class="form-control" onchange="addRows(this)" title="Alege un muncitor"><option value="0">Alege un muncitor</option>
                    <?php
                    // Creaza lista cu angajati;
                    foreach ($list_name as $id => $name){
                        $selected = selected($id, $key, 'angajat', $backup_array, $error);
                        echo "<option $selected value='$id'>$name</option> ";
                    } $id_angajat=array();
                    ?>
                    </select></div></td>

            <td><div class="form-group <?php if(isset($backup_array)){echo $backup_array[$key]['det']['alert'];}?> has-feedback">
                    <span class="glyphicon <?php if(isset($backup_array)){echo $backup_array[$key]['det']['icon'];}?>form-control-feedback" aria-hidden="true"></span>
            <input class="form-control" type="text" name="data[<?= $i ?>][detalii]" value="<?php if(isset($_POST['submit'])){ echo $backup_array[$key]['detalii'];};?>"
                   placeholder="de exemplu cate kg..." title="scrie un comentariu despre avans..."></div>
            </td>
            <td><div class="form-group <?php if(isset($backup_array)){echo $backup_array[$key]['sum']['alert'];}?>has-feedback">
                <span class="glyphicon<?php if(isset($backup_array)){echo $backup_array[$key]['sum']['icon'];}?>form-control-feedback" aria-hidden="true"></span>
                <input class="form-control" type="number" name="data[<?= $i ?>][sum_avans]" value="<?php if(isset($_POST['submit'])){ echo $backup_array[$key]['sum_avans'];};?>"
                       placeholder="MDL" title="suma corespunzatoare..."></div>
            </td>
            </tr>
    <?php  }?>
    </tbody>
    <tfoot>
    <td colspan="4">
        <div class="col-lg-12">
            <button class="btn btn-default btn-success btn-group-justified" type="submit" name="submit"
                    value="submit">Adauga datele pentru toata ziua
            </button>
        </div><!-- /.col-lg-12 -->
    </td>
    </tfoot>
    </form>
<?php } ?>