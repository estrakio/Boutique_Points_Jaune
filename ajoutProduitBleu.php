<?php

// *----------------------------------------------------------------------*
// *  PHP        : ajoutProduitBleu.php                                   *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Gestion des produits pour les points bleu                           *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


//echo ("<pre>");
//var_dump($_POST);
//echo ("</pre>");
// Si le champ "ajout" de la variable POST n'est pas vide 

if (isset($_POST["produit_ajouter"])) {
  ?>
  <br>
  <div class="row">
    <div class="text-center text-success">
      <p h3>Article ajouté avec succés</p>
    </div>
  </div>
  <?php
}
if (!empty($_POST["ajout"])) {
  // initialise la variable az;
  $az = "";
  // Si le contenu du champ "actif" est oui 
  if ($_POST["actif"] == "oui") {
    //Passe az à 1 
    $az = 1;
  } else {
    // sinon az passe à 0
    $az = 0;
  }
  // Initialisation du tableau qui contiendra les données à insérez
  $tableau = array(
    'codeabap' => $_POST["codeabap"],
    'nomproduit' => $_POST["nomproduit"],
    'valpointsbleu' => $_POST["valpointsbleu"],
    'col' => $_POST["col"],
    'actif' => $az
  );
  // Insertion des dites données
  insertSql("produitsBleu", $tableau);
  // Vide la variable POST
  unset($_POST["ajout"]);
  ?>
  <script>
    form = document.createElement("form");
    form.action = "/index.php?content=ajoutProduitBleu";
    form.method = "post";
    form.innerHTML = '<input type="hidden" name="produit_ajouter" value="1">';
    document.body.appendChild(form);
    form.submit();
  </script>
  <?php


  // si le champ "choix_1" de la variable post contient quelque chose
} elseif (!empty($_POST["choix_1"])) {
  // Récupération des paramétre de connexion à la base de données
  $conn = connectionSql();
  // Lecture de chaque ligne du tableau 
  foreach ($_POST as $champ => $value) {
    // Séparation du contenu de la variable champ au niveau de "_"
    $explosion = explode("_", $champ);
    // Si la valeur est égale à "oui
    if ($value == "oui") {
      // Met à jour l'article en le rendant actif
      $sql = "UPDATE produitsBleu SET actif = '1' WHERE id = " . $explosion[1] . ";";
    }
    // Si la valeur est égale à non
    if ($value == "non") {
      // Met à jour l'article en le rendant inactif
      $sql = "UPDATE produitsBleu SET actif = '0' WHERE id = " . $explosion[1] . ";";
    }

    // éxecute la rêquete SQL
    pg_query($conn, $sql);
    // Vide la variable explosion
    $explosion = '';
  }
}
// ___________________________________________________________________________________________FORM DEPART_____________________________________________________________________________________
if (empty($_POST["choix"])) {
  unset($_POST["ajout"]);
  ?>
  <!-- Affichage de texte-->

  <div class="row text-center  h3">
    <b style="margin-top:5vh;" class="text-primary">
      Vous êtes sur la page de gestion des produits bleu
    </b>
    <b style="margin-top:5vh;">
      Merci de sélectionner avec le menu déroulant l'opération que vous souhaitez effectuer :
    </b>

  </div>

  <!-- Affichage d'un formulaire à option pré-défini-->
  <div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
      <form action="/index.php?content=ajoutProduitBleu" method="post" id="formChoix">
        <br>
        <div>
          <label for="choix">Quelle opération souhaitez vous effectuer ?</label>
          <select class="form-control" id="" name="choix">
            <option disabled selected value>- - - - - - - - - </option>
            <option>-- Consulter les produits existants</option>
            <option>-- Supprimer des produits existants</option>
            <option>-- Ajouter des produits manuellement</option>
            <option>-- Ajouter des produits via un fichier Excel</option>
            <option disabled selected value>- - - - - - - - - </option>
          </select>
        </div>
      </form>
      <br>
      <div class="text-center">
        <button class="btn btn-secondary btn-lg" type="submit" form="formChoix" value="Submit">Valider</button>
        <br><br>
      </div>
    </div>
    <div class="col-3"></div>
  </div>

  <?php
  // ___________________________________________________________________________________________CONSULTATION____________________________________________________________________________________
} elseif ($_POST["choix"] === "-- Consulter les produits existants") {
  // Création d'une liste
  $tab = [];
  // Récupération d'un tableau contenant tout le contenu de la table "produits"
  $table = tableSql("produitsBleu");
  // parcours des données récupérer ligne par ligne
  foreach ($table as $ligne) {
    // Récupération des données nécessaires dans un dictionnaire de données
    $a = array(
      "id" => $ligne["id"],
      "Code SAP" => $ligne["codeabap"],
      "Nom du produit" => $ligne["nomproduit"],
      "Valeurs en points" => $ligne["valpointsbleu"],
      "nombre de col par carton" => $ligne["col"],
      "actif" => $ligne["actif"]
    );
    // ajout de la ligne du dictionnaire dans la liste $tab
    array_push($tab, $a);
  }
  // Affichage du tableau avec les données récupérer.
  tableau_consultation_produits($tab, " Liste des produits :");



  // ___________________________________________________________________________________________SUPPRESSION_____________________________________________________________________________________
} elseif ($_POST["choix"] === "-- Supprimer des produits existants") { {
    // Récupération des données présentes dans la table "produits"
    $table = tableSql("produitsBleu");

    // Début d'un tableau
    ?>
    <div class="row text-center  h3">
      <b style="margin-top:5vh;">Listes des produits : </b>
    </div>
    <div class="row">
      <div>
        <form action="/index.php?content=ajoutProduitBleu" method="post" id="majActif">
          <table class="table table-striped table-dark h5">

            <thead class="thead-dark">
              <tr>
                <?php
                // parcours de chaque ligne du tableau 
                foreach ($table as $ligne) {
                  if (next($table)) {
                  } else {
                    foreach ($ligne as $champ => $value) {
                      //echo($champ);
                      // Créer une colonne dans le tableau pour chacun des champs
                      echo ("<th scope='col'>" . $champ . "</th>");
                    }
                  }
                } ?>
              </tr>
            </thead>

            <tbody>

              <?php


              echo ('<div class="row">');
              // pour chaque produit présent dans la table
              foreach ($table as $ligne) {
                echo ("<tr>");
                foreach ($ligne as $champ => $value) {
                  //echo($champ);
                  // Si le champ en cours et celui de l'id 
                  if ($champ === "id") {
                    // Récupère la valeur qui lui correspond
                    $id = $value;
                  }
                  // Si le champ en cours est celui qui définit si un article et actif ou non
                  if ($champ === "actif") {
                    // Créer un formulaire qui va afficher si le produit est actif ou pas et va permettre de modifié son état
                    echo ('<td>');
                    echo ('<select class="form-control" id="" name="choix_' . strval($id) . '">');
                    if ($value === '1') {
                      echo ('<option>oui</option>');
                      echo ('<option>non</option>');
                    } else {
                      echo ('<option>non</option>');
                      echo ('<option>oui</option>');
                    }
                    echo ('</select>');
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
                        <button class="btn btn-secondary btn-lg" type="submit" form="majActif" value="Submit">Mettre à jour</button>
                        <br><br>
                        </div>');
              echo ('</div>');
              echo ('</div>');
  }





  // ___________________________________________________________________________________________AJOUT MANUEL____________________________________________________________________________________
} elseif ($_POST["choix"] === "-- Ajouter des produits manuellement") {
  ?>

            <div class="row">
              <div class="col-3 "></div>
              <div class="col-6">
                <form action="/index.php?content=ajoutProduitBleu" method="post" id="formAjoutProduit">
                  <input hidden value="ajout" name="ajout" id="ajout">

                  <div>
                    <label for="codeabap">Code SAP</label>
                    <input type="text" class="form-control" placeholder="code SAP" name="codeabap" required>
                  </div>
                  <br>
                  <div>
                    <label for="nomproduit">Nom du produit</label>
                    <input type="text" class="form-control" placeholder="Nom du produit" name="nomproduit" required>
                  </div>
                  <br>
                  <div>
                    <label for="valpointsbleu">Valeur en point bleu</label>
                    <input type="number" class="form-control" placeholder="0" name="valpointsbleu" required>
                  </div>
                  <br>
                  <div>
                    <label for="col">Nombre de bouteille dans le carton</label>
                    <input type="number" class="form-control" placeholder="0" name="col" required>
                  </div>
                  <br>
                  <div>
                    <label for="choix">Actif </label>
                    <select class="form-control" id="" name="actif">
                      <option>oui</option>
                      <option>non</option>
                    </select>
                  </div>
                </form>
                <div class="text-center">
                  <button class="btn btn-secondary btn-lg" type="submit" form="formAjoutProduit"
                    value="Submit">Valider</button>
                  <br><br>
                </div>
              </div>
              <div class="col-3"></div>
            </div>
            <?php


  // ___________________________________________________________________________________________AJOUT PAR EXCEL_________________________________________________________________________________
} elseif ($_POST["choix"] === "-- Ajouter des produits via un fichier Excel") {
  ?>
            <div class="row">
              <div class="col d-flex justify-content-center">
                <div class="card" style="width: 25rem;">
                  <div class="card-body">
                    <h5 class="card-title">Veuillez sélectionner le fichier que vous souhaitez uploader
                      :</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Merci d'utilisez uniquement des fichiers
                      CSV</h6>
                    <p class="card-text">
                    <div class="row text-center">
                      <div>
                        <form action="index.php?content=ajoutProduitBleu" method="post" enctype="multipart/form-data">
                          <input type="file" name="csv" value="" />
                          <input hidden value="clickExcel" name="etape2Excel" id="etape2Excel">

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

}
if (!empty($_POST["etape2Excel"])) {
  if ($_POST["etape2Excel"] === "clickExcel") { /// DEBUT
    $allowedTypes = ['text/csv', 'application/vnd.ms-excel'];
    try {
      if (!in_array($_FILES['csv']['type'], $allowedTypes)) {
        throw new Exception("Le fichier doit être au format CSV.");
      }
      $joliTableau = [];
      $nouveauxProduits = [];
      $filename = $_FILES["csv"]["tmp_name"];
      $row = 1;
      if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

          if ($data[0] != "code SAP") {

            $line = array(
              "codeabap" => $data[0],
              "nomproduit" => $data[1],
              "valpointsbleu" => $data[2],
              "col" => $data[3],
              "actif" => 1
            );
            array_push($nouveauxProduits, $line);
          }
        }
        fclose($handle);
      }
      $tableProduits = tableSql("produits");
      //echo "<pre>";
      //var_dump($tableProduits);
      //echo "</pre>";
      foreach ($nouveauxProduits as $ligne) {
        $a = 0;
        foreach ($tableProduits as $ligneProduit) {
          if ($ligne["codeabap"] === $ligneProduit["codeabap"]) {
            $a = 1;
          }
        }

        if ($a === 0) {
          $affichage = array(
            "Code SAP" => $ligne["codeabap"],
            "Nom du produit" => $ligne["nomproduit"],
            "Point bleu" => $ligne["valpointsbleu"],
            "Nombre de col par carton" => $ligne["col"],
          );
          array_push($joliTableau, $affichage);
          insertSql("produitsbleu", $ligne);
        }
      }
      //echo "<pre>";
      //var_dump($joliTableau);
      //echo "</pre>";

      if (count($joliTableau) == 0) {
        echo "<div class='text-center'>";
        echo "<p class='text-danger'> Tous les élements présents dans le fichier font déjà partie de la base de données </p>";
        echo "</div>";
      } else {
        affichTable($joliTableau, 'Liste des produits ajoutés :');
      }
    } catch (Exception $e) {
      echo "<p class='h3 text-danger text-center'> <br>Une erreur s'est produite: " . $e->getMessage() . "</p>";
    }
  } /// LA

}
?>