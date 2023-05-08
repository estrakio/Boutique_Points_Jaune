<?php

// *----------------------------------------------------------------------*
// *  PHP        : extraction_data.php                                    *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Permet la création de tableau des données présentes dans            *
// *  les tables du site                                                  *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *  Ajout des dates du jour et conservation des dates lorsque choisi    *
// *  22/03/2023 WALTER KARL                                              *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *  commentaires du var_dump du post                                    *
// *  24/03/2023 WALTER KARL                                              *
// *----------------------------------------------------------------------*


// echo ("<pre>");
// var_dump($_POST);
// echo ("</pre>");

//_______________________________________________________________________________________________________________________________________

$conn = connectionSql();
$sql = "select * from historique where operation = 'vente de jus';";
$tab_historique_jaune = pg_fetch_all(pg_query($conn, $sql));
$sql = "select * from historiquebleu where operation = 'vente de jus';";
$tab_historique_bleu = pg_fetch_all(pg_query($conn, $sql));
$sql = "table produits;";
$tab_produits_jaune = pg_fetch_all(pg_query($conn, $sql));
$sql = "table produitsbleu;";
$tab_produits_bleu = pg_fetch_all(pg_query($conn, $sql));
$tab_final = [];
//_______________________________________________________________________________________________________________________________________

function filtre_date_mois($table, $filtre_du, $filtre_au)
{
  $donnees = [];
  $du = strtotime($filtre_du);
  $au = strtotime($filtre_au);
  foreach ($table as $ligne_historique) {
    $split_date = explode(" ", $ligne_historique["date"]);
    $date_ligne = strtotime($split_date[0]);
    if ($date_ligne >= $du && $date_ligne <= $au) {
      array_push($donnees, $ligne_historique);
    }
  }
  return $donnees;
}
//_______________________________________________________________________________________________________________________________________
?>


<div class="row">
  <div class="col-3 "></div>
  <div class="col-6">
    <form action="index.php?content=extraction_data" method="post" id="historique">
      <br>
      <div class="row">
        <div class="col-6">
          <label for="id">de la date :</label>
          <?php
          $date_jour = date("Y-m-d"); 
          if (isset($_POST["date_du"])) {
            echo('<input type="date" class="form-control" name="date_du" value="'.$_POST["date_du"].'" required>');
          }else {
            echo('<input type="date" class="form-control" name="date_du" value='.$date_jour.' required>');
          }
          ?>
        </div>
        <div class="col-6">
          <label for="id">à la date :</label>
          <?php
          if (isset($_POST["date_du"])) {
            echo('<input type="date" class="form-control" name="date_au" value="'.$_POST["date_au"].'" required>');
          }else {
            echo('<input type="date" class="form-control" name="date_au" value='.$date_jour.' required>');
          }
          ?>
        </div>
        <br>
        <div class="col-8 text-center">
          <br>
          <label>Sur quel type de points souhaitiez vous faire l'extraction ? </label>
          <br>
          <br>
        </div>
        <br>
        <div class="row">
          <div class=" col-4">
            <input class="form-check-input" type="radio" name="check_bleu_jaune" id="inlineRadio1"
              value="historiquebleu" checked>
            <label class="form-check-label" for="inlineRadio1">Points bleues</label>
          </div>
          <div class=" col-4">
            <input class="form-check-input" type="radio" name="check_bleu_jaune" id="inlineRadio2" value="historique">
            <label class="form-check-label" for="inlineRadio2">Points jaunes</label>
          </div>
        </div>
    </form>
    <div class="text-center">
      <br><br>
      <button class="btn btn-secondary btn-lg" type="submit" form="historique" value="Submit">Valider</button>
      <br><br>
    </div>
  </div>
  <div class="col-3"></div>
</div>

<?php
if (isset($_POST["check_bleu_jaune"])) {
  if ($_POST["check_bleu_jaune"] == "historique") {
    $tab_histo_filtre = filtre_date_mois($tab_historique_jaune, $_POST["date_du"], $_POST["date_au"]);
  } elseif ($_POST["check_bleu_jaune"] == "historiquebleu") {
    $tab_histo_filtre = filtre_date_mois($tab_historique_bleu, $_POST["date_du"], $_POST["date_au"]);
  }

  $ligne_enregistrement = [];

  foreach ($tab_histo_filtre as $ligne) {
    $z = substr($ligne["detail"], 0, -1);
    $detail = explode("/", $z);

    foreach ($detail as $element) {
      $ligne_article = explode(";", $element);
      $code_sap = $ligne_article[0];
      $total_points = $ligne_article[1];
      $a = 0;
      foreach ($ligne_enregistrement as &$data) {
        // echo ("<pre>");
        // var_dump($data);
        // echo ("</pre>");
        if ($data["code_sap"] == $code_sap) {
          $data["total_points"] += intval($total_points);
          $a = 1;
        }
      }
      if ($a == 0) {
        $b = array(
          "code_sap" => $code_sap,
          "total_points" => $total_points
        );
        array_push($ligne_enregistrement, $b);
      }
    }
  }

  // echo ("<pre>");
  // var_dump($ligne_enregistrement);
  // echo ("</pre>");
  //for ($i=0; $i < count($ligne_enregistrement); $i++) { 
  //    // array_push($liste_data_magique, $ligne_enregistrement[$i]);
  //    echo ("<pre>");
  //    var_dump($ligne_enregistrement[$i]);
  //    echo ("</pre>");

  //}

  foreach ($ligne_enregistrement as $couple_de_prod) {
    // echo"coucou";
    // echo ("<pre>");
    // var_dump($couple_de_prod);
    // echo ("</pre>");

    if ($_POST["check_bleu_jaune"] == "historique") {
      // echo("la key qui est passée par la est la $key. la valeur associé est $value<br>");
      $sql = "select * from produits where codeabap = '" . $couple_de_prod["code_sap"] . "';";
      $nom_point = "valpointsjaune";
    } elseif ($_POST["check_bleu_jaune"] == "historiquebleu") {
      $sql = "select * from produitsbleu where codeabap = '" . $couple_de_prod["code_sap"] . "';";
      $nom_point = "valpointsbleu";
    }

    $ligne_produit = pg_fetch_assoc(pg_query($conn, $sql));

    $qte_produit = intval($couple_de_prod["total_points"] / $ligne_produit["$nom_point"]);
    $v = array(
      "CODE SAP" => $couple_de_prod["code_sap"],
      "LIBELLE ARTICLE" => $ligne_produit["nomproduit"],
      "COL PAR CARTON" => $ligne_produit["col"],
      "VALEURS UNITAIRE" => $ligne_produit["$nom_point"],
      "QUANTITE TOTAL" => $qte_produit,
      "TOTAL EN POINTS" => $couple_de_prod["total_points"]
    );
    array_push($tab_final, $v);
  }
  affichTable($tab_final, "RESULTAT");
  // echo ("<pre>");
  // var_dump($tab_final);
  // echo ("</pre>");
}