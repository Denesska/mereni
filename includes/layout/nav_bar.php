
<nav class="navigation row">
            <div class="container">
                <ul class="col-xs-12 nav nav-pills nav-justified">
                        <div class="btn-group col-md-4 col-sm-4 col-xs-12" role="group" aria-label="...">
                            <li role="menuitem" class="btn btn-default  col-xs-10 col-sm-9 col-md-10<?php if($page == "lucru_zi"){echo " active";}?> ">
                                <a href="/lucru_zi.php" class="menu-item">
                                   Lucru pe zile</a></li>
                            <li role="menuitem" class="btn btn-default col-xs-2 col-sm-3 col-md-2<?php if($page == "lucru_zi_nou"){echo " active";}?>">
                            <a href="/lucru_zi_nou.php" class="menu-item add_button">
                                <span class=" glyphicon glyphicon-24em glyphicon-plus-sign"></span></a>
                            </li></div>

                    <div class="btn-group col-md-4 col-sm-4 col-xs-12" role="group" aria-label="...">
                        <li role="menuitem" class="btn btn-default col-xs-10 col-sm-9 col-md-10<?php if($page == "salarii"){echo " active";}?>">
                            <a href="/salarii.php" class="menu-item add_button">
                                Plati/Incasari</a></li>
                        <li role="menuitem" class="btn btn-default col-xs-2 col-sm-3 col-md-2<?php if($page == "rulaj_zi_nou"){echo " active";}?>">
                            <a href="/rulaj.php" class="menu-item add_button">
                                <span class=" glyphicon glyphicon-24em glyphicon-shopping-cart"></span></a>
                        </li></div>

                    <div class="btn-group col-md-4 col-sm-4 col-xs-12" role="group" aria-label="...">
                        <li role="menuitem" class="btn btn-default col-xs-10 col-sm-9 col-md-10<?php if($page == "achitare"){echo " active";}?> ">
                            <a href="/achitare.php" class="menu-item">
                                Salarii</a></li>
                        <li role="menuitem" class="btn btn-default col-xs-2 col-sm-3 col-md-2<?php if($page == "achitare_nou"){echo " active";}?>">
                            <a href="/achitare_nou.php" class="menu-item add_button">
                                <span class=" glyphicon glyphicon-24em glyphicon-plus-sign"></span></a>
                        </li></div>
                </ul>
            </div>
        </nav>
        <hr/>
