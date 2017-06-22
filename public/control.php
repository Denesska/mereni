<?php
require_once "../includes/layout/session.php";
$title = "Angajati";
$page = "angajati";
require_once "../includes/layout/top_page.php";
require_once "../includes/layout/nav_bar.php";
require_once "../includes/function.php";

?>
    <main class="container">
        <?= status_baloon(); ?>
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading"><p class="h4">Lista Tabelelor si continutul: </p></div>
                <div class="list-menu list-group col-xs-4 col-sm-3 col-md-2">
                    <?php
                    $tables=get_tables_name();
                    foreach ($tables as $id => $table){?>
                        <a class="list-group-item" href="control.php?tab=<?=$table['name']."&&id=".$id?>"><?=$table['name']?></a>
                        <?php
                    }
                    ?>
                </div>
                <div class="content col-xs-8 col-sm-9 col-md-10">
                    <?php

                    if (isset($_GET['tab'])){
                        $id = escaped_str($_GET["id"]);
                        $columns_name = get_columns_name($tables[$id]['tab']);
                        $columns_data = select_columns($tables[$id]['tab'], $columns_name);
                        ?>
                        <div class="personal-data">
                            <p class="h3">Continutul tabelului :  <i class="text-black-strong"><?= $_GET['tab']?></i>
                                <a class="small red" href="angajat_edit.php?id="
                                   title="Editeaza datele personale ale angajatului">editeaza</a></p>
                            <hr>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <?php foreach ($columns_name as $col_nm){
                                        echo "<th>$col_nm</th>";
                                    }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($columns_data as $nr => $data) {
                                    echo "<tr><th>$nr</th>";
                                    foreach ($data as $nm => $col) {
                                        echo "<td>$col</td>";
                                    }
                                    echo "</tr>";
                                }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
                <div class="content col-xs-8 col-sm-9 col-md-10" id="for_replace">

                </div>
            </div>
        </div>
    </main>

<?php require "../includes/layout/bottom_page.php";
?>