
<?php
//echo("<pre>");
//var_dump($_POST);
//echo("</pre>");
?>

<div>
    <br>
    <div class="text-center">
        <b class= "text-primary">Transfert des points physiques en dématérialisés</b>
        <br>
        <br>
        <p class= "text-danger">
            Afin d'ajouter les points qui vous ont été confié,
            <br>
            merci de charger ci-dessous un fichier CSV avec le format suivant :
            <br>
            <br>
            matricule ; nombre de points
            <br>
            Le fichier CSV ne doit pas posséder d'entête.
        </p>
    </div>
</div>

<div class="row">
    <div class="col d-flex justify-content-center">
        <div class="card" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title">Veuillez sélectionnez le fichier que vous souhaitez uploader :</h5>
                <p class="card-text">
                    <div class="row text-center">
                        <div>
                            <form action="index.php?content=transfertPoints" method="post" enctype="multipart/form-data">
                                <input type="file" name="csv" value="" />
                                <br>
                                <br>
                                <br>
                                <input type="submit" name="submit" value="Mettre à Jour" />
                            </form>
                        </div>
                    </div>    
                </p>
            </div>
        </div>           
    </div>
</div>
<?php

if (!empty($_POST["submit"])) {
    $dataUtilisateur = [];
    $allowedTypes = ['text/csv', 'application/vnd.ms-excel'];
    try {
        if (!in_array($_FILES['csv']['type'], $allowedTypes)) {
            throw new Exception("Le fichier doit être au format CSV.");
        }
        $filename = $_FILES["csv"]["tmp_name"];
        $row = 1;
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                if ($data[0] != "Matricule") {

                    $line = array(
                        "matricule" => $data[0],
                        "point" => $data[1],
                        "taille_ligne" => count($data)
                    );
                    array_push($dataUtilisateur, $line);
                }
            }
            fclose($handle);
        }
        //echo("<pre>");
        //var_dump($dataUtilisateur);
        //echo("</pre>");
        $compteur = 0;
        $data_update = [];
        foreach ($dataUtilisateur as $line) {
            //echo("<pre>");
            //var_dump($line);
            //echo("</pre>");
            
            
            //echo("___________". $line["taille_ligne"]." ___________");
            if ($line["taille_ligne"] > 2 ) {
                throw new Exception("Le contenu du fichier n'est pas valide, merci de le vérifiez");
                break;
            }
            $tabCondition = array(
                "matricule" => $line["matricule"]
            );
            $data = ["nbrpoint",];
            $salarie_en_cours = selectSql("salarie", $tabCondition, $data);
        
            $nouveau_solde = $salarie_en_cours["nbrpoint"] + $line["point"];
            //echo("$nouveau_solde");
            updateValue("salarie","nbrpoint",$nouveau_solde, $line["matricule"]);
            $compteur += 1;
            $tableau_salarie = array("matricule"=> $line["matricule"], "nouveau solde"=>$nouveau_solde);
            array_push($data_update,$tableau_salarie);

            $valeurs = array('posneg' => "+",
            'operation' => "transfert",
            'valeur' => $line["point"],
            'beneficiaire' => $line["matricule"],
            'detail' => "ajout de points physique",
            'date' => (new DateTime("now", new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
            'id_user' => $_SESSION['connect']['id'],
            );
            // Fonction permettant d'ajouter des données (dictionnaire de données) à une table donnée comme premier argument. 
            insertSql("historique", $valeurs);


        }
        affichTable($data_update,"Tableau des mise à jour");
        } catch (Exception $e) {
            echo "<p class='h3 text-danger text-center'> <br>Une erreur s'est produite: " . $e->getMessage()."</p>";
            exit;
        }
}

?>