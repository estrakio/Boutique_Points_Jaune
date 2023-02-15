<?php

//echo ("<pre>");
//var_dump($_POST);
//echo ("</pre>");
//
//
//echo("<pre>");
//var_dump($_SESSION);
//echo("</pre>");

//echo("______________________________________________");
if (isset($_POST["commande_terminer"])) {

    echo ('<div class="row text-center text-success h3">');
    echo ('<b style="margin-top:5vh;"> Commande validée ! </b>');
    echo ('<b style="margin-top:5vh;"> Le matricule ' . $_POST["matricule"] . ' doit vous régler ' . $_POST["cout"] . ' points</b>');
    echo ('</div>');
}

if (!empty($_POST["etape"])) {
    if ($_POST["etape"] === "1") {
        $test = "matricule  = '" . strval($_POST["matricule"]) . "'";

        //echo("<pre>");
        //var_dump(tableSqlWhere("salarie", $test));
        //echo("</pre>");
        if (empty(tableSqlWhere("salarie", $test))) {
            unset($_POST["etape"]);
            echo ('<div class="row text-center text-danger h3">');
            echo ("<b style='margin-top:5vh;'> Le matricule saisi n'existe pas </b>");
            echo ('</div>');
        }

    }
}

if (empty($_POST["etape"])) {


    ?>
    <div>
        <br>
        <div class="text-center">
            <b class="text-primary">Système d'encaissement des points bleus</b>
            <br>
            <br>
            <p>
                cette page vous permet d'encaisser les commandes de produits coûtant uniquement des points bleus,
                <br>
                pour l'encaissement il est toujours nécessaire d'utiliser les points physiques
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-3 "></div>
        <div class="col-6">
            <form action="index.php?content=caisseBleu" method="post" id="formMatricule">
                <input hidden value="1" name="etape" id="etape">
                <br>
                <div>
                    <label for="matricule">Veuillez saisir le matricule : </label>
                    <input type="text" class="form-control" placeholder="matricule" name="matricule" required>
                </div>
                <br>
            </form>
            <div class="text-center">
                <button class="btn btn-secondary btn-lg" type="submit" form="formMatricule" value="Submit">Valider</button>
                <br><br>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

    <?php

} elseif ($_POST["etape"] === "1") {
    if (isset($_POST["vide"])) {
        ?>
        <div class="row">
            <div class="text-center text-danger ">
                <b>La commande ne contient aucun produit, <br> merci d'en saisir grâce au tableau ci-dessous</b>
            </div>
        </div>
        <?php
    }
    $where = "matricule  = '" . $_POST["matricule"] . "'";
    $salarie = tableSqlWhere("salarie", $where);
    salarie_caisse($salarie, "Salarié :");

    $table = tableSqlSProduitsActifBleu();
    ?>
    <div class="row text-center  h3">
        <b style="margin-top:5vh;">Listes des produits</b>
    </div>
    <div class="row">
        <div>
            <form action="/index.php?content=caisseBleu" method="post" id="majActif">
                <input hidden value="2" name="etape" id="etape">
                <input hidden value="<?php echo ($_POST['matricule']) ?>" name="matricule" id="matricule">
                <table class="table table-striped table-dark h5">

                    <thead class="thead-dark">
                        <tr>
                            <?php
                            foreach ($table as $ligne) {
                                if (next($table)) {
                                } else {
                                    foreach ($ligne as $champ => $value) {
                                        //echo($champ);
                                        if ($champ === "actif") {
                                            echo ("<th scope='col'> quantité (en carton)</th>");
                                        } elseif ($champ === "codeabap") {
                                            echo ("<th scope='col'> code SAP</th>");

                                        } else {
                                            echo ("<th scope='col'>" . $champ . "</th>");
                                        }
                                    }
                                }
                            } ?>
                        </tr>
                    </thead>

                    <tbody>

                        <?php


                        echo ('<div class="row">');
                        foreach ($table as $ligne) {
                            echo ("<tr>");
                            foreach ($ligne as $champ => $value) {
                                //echo($champ);
                                if ($champ === "id") {
                                    $id = $value;
                                }
                                if ($champ === "actif") {
                                    echo ('<td>');
                                    echo ('<input type="number" class="form-control" value="0" name="produit_' . strval($id) . '">');
                                    echo ('</td>');
                                } else {
                                    echo ("<td>" . $value . "</td>");
                                }
                            }
                            echo ("</tr>");
                        }
                        echo ('</tbody>');
                        echo ('</table>');
                        echo ('</form>');
                        echo ('<div class="text-center">
                        <button class="btn btn-secondary btn-lg" type="submit" form="majActif" value="Submit">Valider la commande</button>
                        <br><br>
                        </div>');
                        echo ('</div>');
                        echo ('</div>');
} elseif ($_POST["etape"] === "2") {
    $tableauRecap = array();
    $totalPoint = 0;
    $verification_commande = 0;
    $taille_post = count($_POST) - 2;
    foreach ($_POST as $champ => $valeur) {
        if ($champ != "etape" or $champ != "matricule") {
            if ($valeur == 0) {
                $verification_commande += 1;
            }
        }
    }
    if ($verification_commande == $taille_post) {
        ?>
                            <script>
                                form = document.createElement("form");
                                form.action = "/index.php?content=caisseBleu";
                                form.method = "post";
                                form.innerHTML = '<input type="hidden" name="etape" value="1">' +
                                    '<input type="hidden" name="vide" value="oui">' +
                                    '<input type="hidden" name="matricule" value="<?php echo ($_POST["matricule"]); ?>">';
                                document.body.appendChild(form);
                                form.submit();
                            </script>
                            <?php
    }
    foreach ($_POST as $champ => $valeur) {

        if ($champ === "etape" or $champ === "matricule") {
        } else {
            $idProduit = explode("_", $champ);
            $tabCondition = array(
                "id" => intval($idProduit[1]),
            );
            $data = ["id", "codeabap", "nomproduit", "valpointsbleu", "col"];
            $ligne = selectSql("produitsbleu", $tabCondition, $data);
            array_push($tableauRecap, $ligne);
        }
    }
    $tableauAffichage = [];
    $detail = "";
    //echo("<pre>");
    //var_dump($tableauRecap);
    //echo("</pre>");

    //for ($i=0; $i < sizeof($tableauRecap); $i++) {
    foreach ($tableauRecap as &$ligne) {
        foreach ($ligne as $champ => &$valeurs) {
            if ($champ === "id") {
                $idLigne = $valeurs;
            }
            if ($champ === "valpointsbleu") {
                $total = intval($valeurs) * intval($_POST["produit_" . $idLigne]);
                //$tableauRecap[$i]["valpointsjaune"] = $total;
                $valeurs = $total;
                $totalPoint += $total;
            }
        }
    }
    $tableauAffichage = [];
    $detail = "";
    foreach ($tableauRecap as &$ligne) {

        if ($ligne["valpointsbleu"] != "0") {
            $b = array(
                "Code SAP" => $ligne["codeabap"],
                "Nom du produit" => $ligne["nomproduit"],
                "Points bleus" => $ligne["valpointsbleu"],
                "Nombre de col par carton" => $ligne["col"],
            );
            array_push($tableauAffichage, $b);
            $detail = $detail . $ligne["codeabap"] . ";" . $ligne["valpointsbleu"] . "/";
        }
    }

    affichTable($tableauAffichage, "Récapitulatif commande");
    $where = "matricule = '" . $_POST["matricule"] . "'";
    $salarie = tableSqlWhere("salarie", $where);

    $tableauFinal = array(
        'nom' => $salarie[0]["nom"],
        'prenom' => $salarie[0]["prenom"],
        'matricule' => $salarie[0]["matricule"],
        'points actuel possédé' => $salarie[0]["nbrpoint"],
        'total du caddie' => $totalPoint,
        'nouveau total' => $salarie[0]["nbrpoint"] - $totalPoint
    );
    ?>
                        <div class="row">
                            <div class="col-3 "></div>
                            <div class="col-6">
                                <form action="index.php?content=caisseBleu" method="post" id="formValidationCommande">
                                    <input hidden value="3" name="etape" id="etape">
                                    <input hidden value="<?php echo ($salarie[0]["nbrpoint"]); ?>" name="pointActuel"
                                        id="pointActuel">
                                    <input hidden value="<?php echo ($salarie[0]["matricule"]); ?>" name="matricule"
                                        id="matricule">
                                    <input hidden value="<?php echo ($totalPoint); ?>" name="cout" id="cout">
                                    <input hidden value="<?php echo ($detail); ?>" name="detail" id="detail">
                                </form>
                                <div class="text-center">
                                    <button class="btn btn-warning btn-lg" type="submit" form="formValidationCommande"
                                        value="Submit">Valider la commande</button>
                                    <br><br>
                                </div>
                            </div>
                            <div class="col-3"></div>
                        </div>
                        <?php
} elseif ($_POST["etape"] == "3") {
    $valeurs = array(
        'posneg' => "-",
        'operation' => "vente de jus",
        'valeur' => $_POST["cout"],
        'beneficiaire' => $_POST["matricule"],
        'detail' => $_POST["detail"],
        'date' => (new DateTime("now", new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
        'id_user' => $_SESSION["connect"]["id"],
    );
    insertSql("historiqueBleu", $valeurs);
    ?>
        <script>
            form = document.createElement("form");
            form.action = "/index.php?content=caisseBleu";
            form.method = "post";
            form.innerHTML = '<input type="hidden" name="commande_terminer" value="1">' +
                            '<input type="hidden" name="cout" value="<?php echo($_POST["cout"]);?>">' +
                            '<input type="hidden" name="matricule" value="<?php echo($_POST["matricule"]);?>">';
            document.body.appendChild(form);
            form.submit();
        </script>
    <?php
    echo ("a");
}
?>