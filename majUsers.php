<?php

// *----------------------------------------------------------------------*
// *  PHP        : majUsers.php                                           *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui permet de mettre à jour les salariées                      *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*

?>


<br>
<br>
<div class="row">
    <div class="text-center">
    <b class="h5">Mise à jour des Salariés</b>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col d-flex justify-content-center">
        <div class="card" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title">Veuillez sélectionner le fichier <br> que vous souhaitez charger:</h5>
                <h6 class="card-subtitle mb-2 text-muted"><br>Merci d'utiliser uniquement des fichiers CSV</h6>
                <p class="card-text">
                    <div class="row text-center">
                        <div>
                            <form action="index.php?content=majUsers" method="post" enctype="multipart/form-data">
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
//echo("<pre>");
//var_dump($_FILES);
//echo("</pre>");
if (empty($_FILES["csv"]["name"])) {

}else {

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
                    
                    if (count($data) >= 5) {
                    throw new Exception("Le nombre de colonne n'est pas correct le fichier en contient :".count($data)."");
                    }
                    if ($data[0] != "Matricule") {

                        $line = array(
                            "matricule" => $data[0],
                            "nom" => $data[1],
                            "prenom" => $data[2]
                        );
                        array_push($dataUtilisateur, $line);
                    }
                }
                fclose($handle);
            }

            $nouveauSalarie = [];
            foreach ($dataUtilisateur as $champ => $ligne) {


                if ($ligne["matricule"] != "Matricule") {
                    if (checkUtilisateurs($ligne["matricule"]) == null) {
                    
                        $valeurs = array(
                            'nom' => mb_convert_encoding($ligne["nom"], 'UTF-8', 'ISO-8859-1'),
                            'prenom' => mb_convert_encoding($ligne["prenom"], 'UTF-8', 'ISO-8859-1'),
                            'matricule' => mb_convert_encoding($ligne["matricule"], 'UTF-8', 'ISO-8859-1'),
                            'nbrpoint' => 0,
                            'actif' => 1,
                        );
                        insertSqlSalarier("salarie", $valeurs);
                        array_push($nouveauSalarie, $valeurs);
                        unset($valeurs);
                        $valeurs = [];
                    }
                }
            }
            affichTable($nouveauSalarie, 'Salariés mis à jour ! ');

            // Récupère les matricules des salarie dans le fichier CSV
            $matricules = array_column($dataUtilisateur, 'matricule');

            // Récupère les utilisateurs actifs dans la base de données
            $utilisateurs = tableSqlSalarieActif('salarie');

            foreach ($utilisateurs as $utilisateur) {

                // Si l'utilisateur n'est pas présent dans le fichier CSV, on le désactive
                if (!in_array($utilisateur['matricule'], $matricules)) {
                    updateValue("salarie", "actif", 0, $utilisateur['matricule']);
                }
            }

        } catch (Exception $e) {
            echo "<p class='h3 text-danger text-center'> <br>Une erreur s'est produite: " . $e->getMessage()."</p>";
        }
    }// fin de la limite
}

