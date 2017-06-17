<table class="table table-striped">
    <thead>
    <tr>
        <th>Luna</th>
        <th>Lucrat</th>
        <th>Absent</th>
        <th>Salariu</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $y[0] = $y[1] = $y[2] = $y[3] = $y[4] = $y[5] = 0;
    $mon = array("01" => "IAN", "02" => "FEB", "03" => "MAR", "04" => "APR", "05" => "MAI", "06" => "IUN", "07" => "IUL", "08" => "AUG", "09" => "SEP", "10" => "OCT", "11" => "SEP", "12" => "DEC");
    $nr = null;
    foreach ($months as $nr => $data) {
        ?>
        <tr>
            <th id="<?= $id . "&&month=$nr"; ?>"
                onclick="getEmployeeActivityByDat(this)"><?= $mon[$nr] ?></th>
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
        </tr>
        <?php
        $y[0] += $data['luc'];
        $y[1] += $data['abs'];
        $y[2] += $data['mot'];
        $y[3] += $data['sal'];
    } ?>
    </tbody>
    <tfoot class="total">
    <tr>
        <th>Total</th>
        <td><?= $y[0] ?> zile</td>
        <td><?= $y[1] ?> zile &nbsp;
            <span class="badge<?php if ($y[2] > 0) {
                echo " danger";
            } ?>"><?= $y[2] ?></span></td>
        <td><?= $y[3] ?> MDL</td>
    </tr>
    </tfoot>
</table>