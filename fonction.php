<?php

function fabriqueTableau($table, $titre)
{

?>

    <div class="row text-center  h3">
        <b style="margin-top:5vh;"><?php echo($titre); ?></b>
    </div>
    <div class="row">
        <div>
            <table class="table table-striped table-dark h5">

                <thead class="thead-dark">
                    <tr>
                        <?php
                        foreach ($table  as $ligne) {
                            if (next($table)) {
                            } else {
                                foreach ($ligne  as $champ => $value) {
                                    //echo($champ);
                                    echo ("<th scope='col'>" . $champ . "</th>");
                                }
                            }
                        } ?>
                    </tr>
                </thead>

                <tbody>

                <?php


                echo ('<div class="row">');
                foreach ($table  as $ligne) {
                    echo ("<tr>");
                    foreach ($ligne  as $champ => $value) {
                        //echo($champ);
                        echo ("<td>" . $value . "</td>");
                    }
                    echo ("</tr>");
                }
                echo ('</tbody>');
                echo ('</table>');
                echo ('</div>');
                echo ('</div>');
            }
            function tableau_consultation_produits($table, $titre){
            
            ?>
            
                <div class="row text-center  h3">
                    <b style="margin-top:5vh;"><?php echo($titre); ?></b>
                </div>
                <div class="row">
                    <div>
                        <table class="table table-striped table-dark h5">
            
                            <thead class="thead-dark">
                                <tr>
                                    <?php
                                    foreach ($table  as $ligne) {
                                        if (next($table)) {
                                        } else {
                                            foreach ($ligne  as $champ => $value) {
                                                //echo($champ);

                                                echo ("<th scope='col'>" . $champ . "</th>");
                                            }
                                        }
                                    } ?>
                                </tr>
                            </thead>
            
                            <tbody>
            
                            <?php
            
            
                            echo ('<div class="row">');
                            foreach ($table  as $ligne) {
                                echo ("<tr>");
                                foreach ($ligne  as $champ => $value) {
                                    //echo($champ);
                                    if ($champ == "actif"){
                                        if ($value == "1") {
                                        echo ("<td>oui</td>");
                                        }else{
                                            echo ("<td>non</td>");
                                        }
                                    }else{
                                        echo ("<td>" . $value . "</td>");
                                    }
                                }
                                echo ("</tr>");
                            }
                            echo ('</tbody>');
                            echo ('</table>');
                            echo ('</div>');
                            echo ('</div>');
                        }

                ?>
<?php

// ____________________________________________________________________________________________________________________________________________________________________________________
function tableau_recapitulatif_points($tableData, $titre){
    ?>
    
        <div class="row text-center  h3">
            <b style="margin-top:5vh;"><?php echo($titre); ?></b>
        </div>
        <div class="row">
            <div>
                <table class="table table-striped table-dark h5">
    
                    <thead class="thead-dark">
                        <tr>
                            <?php
                            foreach ($tableData  as $ligne) {
                                if(next($tableData)){
                                }else{
                                    foreach ($ligne  as $champ => $value) {
                                        //echo($champ);
                                        if ($champ == "nom" ) {
                                            echo ("<th scope='col'>Nom</th>");
                                        }elseif ($champ == "prenom") {
                                            echo ("<th scope='col'>Prénom</th>");
                                        }elseif ($champ == "matricule") {
                                            echo ("<th scope='col'>Matricule</th>");
                                        }elseif ($champ == "points actuel possédé") {
                                            echo ("<th scope='col'>Points actuel possédés</th>");
                                        }elseif ($champ == "total du caddie") {
                                            echo ("<th scope='col'>Total du caddie</th>");
                                        }elseif ($champ == "nouveau total") {
                                            echo ("<th scope='col'>Nouveau solde</th>");
                                        }else{
                                            echo ("<th scope='col'>".$champ."</th>");
                                        }
                                    }
                                }    
    
                            } ?>
                        </tr>
                    </thead>
    
                    <tbody>
    
                <?php
    
    
                echo ('<div class="row">');
                foreach ($tableData  as $ligne) {
                    echo ("<tr>");
                    foreach ($ligne  as $champ => $value) {
                        //echo($champ);
                        echo ("<td>" . $value . "</td>");
                    } 
                    echo ("</tr>");
                } 
                echo ('</tbody>');
                echo ('</table>');
                echo ('</div>');
                echo ('</div>');
            }
// ____________________________________________________________________________________________________________________________________________________________________________________

function affichTable($tableData, $titre){
?>

    <div class="row text-center  h3">
        <b style="margin-top:5vh;"><?php echo($titre); ?></b>
    </div>
    <div class="row">
        <div>
            <table class="table table-striped table-dark h5">

                <thead class="thead-dark">
                    <tr>
                        <?php
                        foreach ($tableData  as $ligne) {
                            if(next($tableData)){
                            }else{
                                foreach ($ligne  as $champ => $value) {
                                    //echo($champ);
                                    echo ("<th scope='col'>".$champ."</th>");
                                }
                            }    

                        } ?>
                    </tr>
                </thead>

                <tbody>

            <?php


            echo ('<div class="row">');
            foreach ($tableData  as $ligne) {
                echo ("<tr>");
                foreach ($ligne  as $champ => $value) {
                    //echo($champ);
                    echo ("<td>" . $value . "</td>");
                } 
                echo ("</tr>");
            } 
            echo ('</tbody>');
            echo ('</table>');
            echo ('</div>');
            echo ('</div>');
        }
        function salarie_caisse($tableData, $titre){

?>

    <div class="row text-center  h3">
        <b style="margin-top:5vh;"><?php echo($titre); ?></b>
    </div>
    <div class="row">
        <div>
            <table class="table table-striped table-dark h5">

                <thead class="thead-dark">
                    <tr>
                        <?php
                        foreach ($tableData  as $ligne) {
                            if(next($tableData)){
                            }else{
                                foreach ($ligne  as $champ => $value) {
                                    //echo($champ);
                                    echo ("<th scope='col'>".$champ."</th>");
                                }
                            }    

                        } ?>
                    </tr>
                </thead>

                <tbody>

            <?php


            echo ('<div class="row">');
            foreach ($tableData  as $ligne) {
                echo ("<tr>");
                foreach ($ligne  as $champ => $value) {
                    //echo($champ);
                    if($champ == "actif"){
                        if($value == '1'){
                            echo ("<td>oui</td>");

                        }else{
                            echo ("<td>non</td>");
                        }
                    }else{
                        echo ("<td>" . $value . "</td>");
                    }
                } 
                echo ("</tr>");
            } 
            echo ('</tbody>');
            echo ('</table>');
            echo ('</div>');
            echo ('</div>');
        }


        function affichTablePoints($tableData, $titre)
        {
        
        ?>
        
            <div class="row text-center  h3">
                <b style="margin-top:5vh;"><?php echo($titre); ?></b>
            </div>
            <div class="row">
                <div>
                    <table class="table table-striped table-dark h5">
        
                        <thead class="thead-dark">
                            <tr>
                                <?php
                                foreach ($tableData  as $ligne) {
                                    if(next($tableData)){
                                    }else{
                                        foreach ($ligne  as $champ => $value) {
                                            //echo($champ);
                                            $a = $champ;
                                            if( $champ == "posneg"){
                                                $a = "+/-";
                                            }
                                            if( $champ == "operation"){
                                                $a = "type d'opération";
                                            }
                                            if( $champ == "id_user"){
                                                $a = "effectué par";
                                            }
                                            echo ("<th scope='col'>".$a."</th>");
                                        }
                                    }    
        
                                } ?>
                            </tr>
                        </thead>
        
                        <tbody>
        
                    <?php
        
                    $conn = pg_connect("host=db dbname=estrakio user=estrakio password=bonjour");            
                    echo ('<div class="row">');
                    foreach ($tableData  as $ligne) {
                        echo ("<tr>");
                        foreach ($ligne  as $champ => $value) {
                            //echo($champ);
                            if ($champ === 'id_user') {
                            $sql = " SELECT login FROM users WHERE id = ".$value.";";
                            $data = pg_fetch_assoc(pg_query($conn, $sql));
                            $line['id_user'][$value] = $data["login"];
                            //echo($data["login"]." ");
                            echo ("<td>" . $data["login"] . "</td>");
                            }elseif($champ === 'posneg'){
                                if ($value === "+"){
                                    echo ("<td class='text-success' >" . $value . "</td>");
                                }else{
                                    echo ("<td class='text-danger' >" . $value . "</td>");
                                }
                            }elseif($champ === "operation"){
                                if ($value === "ajout manuel"){
                                    echo ("<td class='text-warning' >" . $value . "</td>");
                                }elseif ($value === "vente de jus"){
                                    echo ("<td class='text-danger' >" . $value . "</td>");
                                }else{
                                    echo ("<td class='text-info' >" . $value . "</td>");
                                }
                            }else{
                                echo ("<td>" . $value . "</td>");
                            } 
                        } 
                            echo ("</tr>");
                        }
                    echo ('</tbody>');
                    echo ('</table>');
                    echo ('</div>');
                    echo ('</div>');
                }
            