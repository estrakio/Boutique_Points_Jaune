<div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
        <form action="index.php?content=annulerCommande" method="post" id="annuleCommande">
            <input hidden value="clients" name="content" id="content">
            <br>
            <div>
                <label for="id">ID de la commande</label>
                <input type="text" class="form-control" placeholder="id" name="id_1" required>
            </div>
            <br>
        </form>
        <div class="text-center">
            <button class="btn btn-secondary btn-lg" type="submit" form="annuleCommande" value="Submit">Valider</button>
            <br><br>
        </div>
    </div>
    <div class="col-3"></div>
</div>


<?php
if (!empty($_POST["id_1"])) {
    ?>
    <div class="row">
        <div class="text-center text-danger">
            <p>Voulez vous vraiment supprimer la commande <?php echo($_POST["id_1"]); ?> ?</p>
            <form action="index.php?content=annulerCommande" method="post" id="verif">
                <input hidden value=1 name="validation" id="a">
                <input hidden value=<?php echo ($_POST["id_1"]); ?> name="id" id="b">
                <button type="submit" class="btn btn-outline-success btn-lg" form="verif" value="Submit">Oui</button>
            </form>

            <form action="index.php?content=annulerCommande" method="post" id="pasDaccord">
                <input hidden value=1 name="nonon" id="a">
                <button type="submit" class="btn btn-outline-danger btn-lg" form="pasDaccord" value="Submit">Non</button>
            </form>
        </div>
    </div>

    <?php
}



if (!empty($_POST["validation"])) {
    $test = 0;
    $table = tableSql("historique");
    //echo("<pre>");
    //var_dump($table);
    //echo("</pre>");
    foreach ($table as $ligne) {
        if ($ligne["id"] == $_POST["id"]) {
            if ($ligne["operation"] == "vente de jus") {
                $test = 1;
            }
        }
    }

    if ($test == 1) {
        $tabCondition = array(
            "id" => intval($_POST["id"]),
        );
        $data = ["valeur, beneficiaire, detail"];
        $commande = selectSql("historique", $tabCondition, $data);
        //echo("<pre>");
        //var_dump($commande);
        //echo("</pre>");

        $tabCondition = array(
            "matricule" => $commande["beneficiaire"],
        );
        $data = ["id, nbrpoint"];
        $salarie = selectSql("salarie", $tabCondition, $data);

        $point = intval($salarie["nbrpoint"]) + intval($commande["valeur"]);


        $sql = "UPDATE salarie SET nbrpoint = " . $point . " WHERE matricule = '" . $commande["beneficiaire"] . "';";
        $conn = connectionSql();
        pg_query($conn, $sql);

        $sql = "DELETE FROM historique WHERE id = " . $_POST["id"] . ";";
        pg_query($conn, $sql);

        echo "<div class = ' row text-center text-success' >";
        echo "<b class = 'text-center'>La commande " . $_POST["id"] . " a bien été annulée</b>";
        echo "</div>";

        $tableau = array(
            "posneg" => "+",
            "operation" => "annulation de commande",
            "valeur" => intval($commande["valeur"]),
            "beneficiaire" => $commande["beneficiaire"],
            "detail" => $commande["detail"],
            "date" => (new DateTime("now", new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
            "id_user" => $_SESSION['connect']['id'],
        );
        insertSql("historique", $tableau);


    } else {
        echo "<div class = ' row text-center text-danger' >";
        echo "<b class = 'text-center'>L'id de commande " . $_POST["id"] . " n'existe pas veuillez en saisir un valide</b>";
        echo "</div>";
    }




}
$date = (new DateTime("now", new DateTimeZone('Europe/Paris')))->format('Y-m-d');
$conn = connectionSql();
$sql = "SELECT * FROM historique  where operation = 'vente de jus' ORDER BY id DESC;";
$table_historique = pg_fetch_all(pg_query($conn, $sql));
$historique_ajd = [];
foreach ($table_historique as $ligne) {
    $explosion_date = explode(" ", $ligne["date"]);
    if ($explosion_date[0] == $date) {
        array_push($historique_ajd, $ligne);
    }
}
affichTablePoints($historique_ajd, "HISTORIQUE");
?>