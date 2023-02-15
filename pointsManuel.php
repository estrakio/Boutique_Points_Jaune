<?php
//echo("<pre>");
//var_dump($_SESSION);
//echo("</pre>");

//echo ("<pre>");
//var_dump($_POST);
//echo ("</pre>");


if (!empty($_POST["nombrePoints"])) {


    
        # code...
        $tabCondition = array("matricule" => $_POST["matricule"], );
        $listeData = ["nbrpoint",];
        $salarie = selectSql("salarie", $tabCondition, $listeData);
        $point = $salarie["nbrpoint"];

        if ($_POST["plusMoins"] === "Ajouter (+)") {

            $point = $point + $_POST["nombrePoints"];
            $posneg = "+";


        } elseif ($_POST["plusMoins"] === "Retirer (-)") {

            $point = $point - $_POST["nombrePoints"];
            $posneg = "-";

        }
        $sql = "UPDATE salarie SET nbrpoint = '" . $point . "' WHERE matricule = '" . $_POST["matricule"] . "';";
        $conn = connectionSql();
        pg_query($conn, $sql);

        $tableau = array(
            "posneg" => $posneg,
            "operation" => "ajout manuel",
            "valeur" => $_POST["nombrePoints"],
            "beneficiaire" => $_POST["matricule"],
            "detail" => $_POST["raison"],
            "date" => date("Y-m-d H:i:s"),
            "id_user" => $_SESSION['connect']['id'],
        );
        insertSql("historique", $tableau);
        ?>
        <script>
            form = document.createElement("form");
            form.action = "/index.php?content=pointsManuel";
            form.method = "post";
            form.innerHTML = '<input type="hidden" name="mise_a_jour_reussi" value="1">'+ '<input type="hidden" name="mat" value="<?php echo ($_POST["matricule"]); ?>">';
            document.body.appendChild(form);
            form.submit();
        </script>
    <?php


    
}


?>

<div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
        <form action="index.php?content=pointsManuel" method="post" id="formClients">
            <br>
            <div>
                <label for="matricule">Indiquez le matricule ci-dessous</label>
                <input type="text" class="form-control" placeholder="matricule" name="matricule" required>
            </div>
            <br>
        </form>
        <div class="text-center">
            <button class="btn btn-secondary btn-lg" type="submit" form="formClients" value="Submit">Valider</button>
            <br><br>
        </div>
    </div>
    <div class="col-3"></div>
</div>


<?php
if (isset($_POST['mise_a_jour_reussi'])) {
    ?>
    <div class="row">
        <br>
        <br>
        <div class="text-center text-success">
            <b> Mise à jour effectuer Le matricule <?php echo ($_POST["mat"]); ?> à bien été modifié</b>
        </div>

    </div>
    <?php
}


if (
    isset(
    $_POST['matricule'],
) && (!empty($_POST['matricule']))
) {
    $condition = array(
        "matricule" => strval($_POST['matricule']),
    );
    $data = ["nom", "prenom", "nbrpoint"];

    //echo(selectSql("salarie", $condition, $data));
    $result = (selectSql("salarie", $condition, $data));
    if (empty($result)) {
        ?>
        <div class="row">
            <div class="text-center text-danger">
                <b>Le matricule saisi n'existe pas</b>
            </div>
        </div>


        <?php
    }
    if (!empty($result)) {
        //echo("<pre>");
        //var_dump($_POST);
        //echo("</pre>");

        ?>
        <div class="row">
            <form action="/index.php?content=pointsManuel" method="post" id="upPoint">
                <input hidden value=<?php echo ($_POST["matricule"]) ?> name="matricule" id="matricule">
                <div class="col d-flex justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo (ucfirst($result['nom'])); ?>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <?php echo (ucfirst($result['prenom'])); ?>
                            </h6>
                            <p class="card-text">
                                <?php echo ("MATRICULE NUMERO : " . ucfirst($_POST["matricule"])); ?>
                            </p>
                            <p class="card-text">
                                <?php echo ("NOMBRE DE POINTS ACTUEL : " . ucfirst($result["nbrpoint"])); ?>
                            </p>
                            <p class="card-text">
                                <select class="form-control" id="" name="plusMoins">
                                    <option>Ajouter (+)</option>
                                    <option>Retirer (-)</option>
                                </select>
                            </p>
                            <p class="card-text">
                                <label for="nombrePoints">Veuillez saisir le nombre de points : </label>
                                <input type="number" class="form-control" placeholder="0" name="nombrePoints" required>
                            </p>
                            <p class="card-text">
                                <label for="raison">Veuillez signifier la raison de cet ajout manuel : </label>
                                <input type="text" class="form-control" placeholder="..." name="raison" required>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-center">
                <button class="btn btn-secondary btn-lg" type="submit" form="upPoint" value="Submit">Mettre à jour</button>
                <br>
                <br>
            </div>
        </div>


        <?php



    }
}
$table = "historique";
$where = "operation = 'ajout points' or operation = 'ajout manuel'";
$tableData = tableSqlWhere($table, $where);
affichTablePoints($tableData, $table);
//echo("<pre>");
//var_dump($tableData);
//echo("</pre>");

//echo("<pre>");
//var_dump($_POST);
//echo("</pre>");

?>