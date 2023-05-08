<?php

// *----------------------------------------------------------------------*
// *  PHP        : ajoutPoints.php                                        *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page pour ajouter des points aux salarié                            *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


if(!empty($_SESSION['maj'])){
?>
<div class ="text-center">
  <div>
    <p class="text-warning h5"> <br>Vous avez mis à jour <?php echo($_SESSION['maj'])?> salarié </p>
  </div>
</div>
<?php
unset($_SESSION['maj']);
}
//echo("<pre>");
//var_dump($_SESSION);  
//echo("</pre>");

// Vérifie si la variable POST contient des données au niveau de valPoint
if (!empty($_POST["valPoint"])) {
  // Création d'une variable qui contient le format de la date
  $date = date("m.d.y");
  // Prépare le dictionnaire des données qui vont être ajouté à la table historique
  $valeurs = array('posneg' => "+",
                  'operation' => "ajout points",
                  'valeur' => $_POST["valPoint"],
                  'beneficiaire' => "Tous Salariés",
                  'detail' => "Ajout de points mensuel",
				          'date' => (new DateTime("now", new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
                  'id_user' => $_SESSION['connect']['id'],
                  );
  // Fonction permettant d'ajouter des données (dictionnaire de données) à une table donnée comme premier argument. 
  insertSql("historique", $valeurs);
  // récupération de tout le contenu de la table "salarie" grâce à la fonction tableSql.
  $salaries = table_sql_ajout_point();
  $nbrSalarie = 0;
  // parcours de chaque ligne du tableau contenant les données de la table salarie
  foreach ($salaries as $salarie) {
    // parcours du contenu de chaque clé de chaque ligne
    foreach ($salarie as $key => $value) {
      // si le champ en cours et égale à matricule
      if ($key === "matricule") {
          // Alors récupère la données qui lui corespond
          $valu = $value;
      }
      // si le champ est égale à nbrpoint
      if ($key === "nbrpoint") {
        //Récupère la valeur correspondante ajoute lui la quantité souhaité par l'utilisateur.
        $point = $value + $_POST["valPoint"]; 
        // Commande SQL mettant à jour le nombre de points de l'utilisateur sélectionner
        $sql = "UPDATE salarie SET nbrpoint = '".$point."' WHERE matricule = '".$valu."';";
        // Récupération de la connexion à la base de données.
        $conn = connectionSql();
        // lancement de la requete SQL auprès de la base de données.
        pg_query($conn, $sql);
        $nbrSalarie += 1;
      }
    }
  }
  // vide la variable valPoint
  $_POST['valPoint'] = "";
  $_SESSION['maj'] = $nbrSalarie;
  
  // recharge la page pour afficher le tablea issu de la table historique mis à jour
  ?>
  <script> location.replace("/index.php?content=ajoutPoints"); </script>
  <?php
  

// si la variable valPoint est vide vérifie si la variable POST contient des données au niveau de valPointmoins
}elseif (!empty($_POST["valPointmoins"])) {
  // Création d'une variable qui contient le format de la date
  $date = date("m.d.y");

  // Prépare le dictionnaire des données qui vont être ajouté à la table historique
  $valeurs = array('posneg' => "-",
                  'operation' => "ajout points",
                  'valeur' => $_POST["valPointmoins"],
                  'beneficiaire' => "Tous Salariés",
                  'detail' => "retrait de points suite à une erreur",
                  'date' => (new DateTime("now", new DateTimeZone('Europe/Paris')))->format('Y-m-d H:i:s'),
                  'id_user' => $_SESSION['connect']['id'],
                  );
  // Fonction permettant d'ajouter des données (dictionnaire de données) à une table donnée comme premier argument. 
  insertSql("historique", $valeurs);
  // récupération de tout le contenu de la table "salarie" grâce à la fonction tableSql.
  $salaries = tableSql("salarie");
  $nbrSalarie = 0;
  // parcours de chaque ligne du tableau contenant les données de la table salarie
  foreach ($salaries as $salarie) {
    // parcours du contenu de chaque clé de chaque ligne
    foreach ($salarie as $key => $value) {
      // si le champ est égale au champ matricule
      if ($key === "matricule") {
        // Récupère la valeur du matricule 
          $valu = $value;
      }
      if ($key === "nbrpoint") {
        // Soustraction de du total de Point de la ligne actuel avec la valeur demandé par l'utilisateur.
        $point = $value - $_POST["valPointmoins"];
        // Requete SQL pour mettre à jour le nombre de point de l'utilisateur actuel
        $sql = "UPDATE salarie SET nbrpoint = '".$point."' WHERE matricule = '".$valu."';";
        // Récupération des paramètre de connexion à la base de données
        $conn = connectionSql();
        // Execution de la requête SQL.
        pg_query($conn, $sql);
        $nbrSalarie += 1;
      }
    }
  }
  // Change le contenu de la variable pour la vidé.
  $_POST['valPoint'] = "";
  $_SESSION['maj'] = $nbrSalarie;
  // recharge la page pour l'affichage des modifications.
  
  ?>
  <script> location.replace("/index.php?content=ajoutPoints"); </script>
  <?php
}
?> 



<!-- Affichage de texte-->
<br>
<div class="row text-center"> 
  <div class="row text-center"> 
    Cliquer sur le bouton correspondant pour ajoutez ou retirer le nombre de points voulu : 
  </div>
</div>
<br>
<br>

<div class="row text-center">
  <div class="col-1 text-center">
  </div>
<!-- Affichage des boutons permettant d'ajouter ou retirer des points-->
  <div class="col-3 text-center">

    <form action="index.php?content=ajoutPoints" method="post" id="plusquatre">
    <input hidden value= 1 name="valPoint" id="a">
    <button type="submit" class="btn btn-outline-success btn-lg" form="plusquatre" value="Submit">+ 1 Points</button>
    </form>

    <form action="index.php?content=ajoutPoints" method="post" id="moinsquatre">
    <input hidden value= 1 name="valPointmoins" id="step">
    <button type="submit" class="btn btn-outline-danger btn-lg" form="moinsquatre" value="Submit">- 1 Points</button>
    </form>

  </div>

  <div class="col-3 text-center">
    <form action="index.php?content=ajoutPoints" method="post" id="plushuit">
    <input hidden value= 9 name="valPoint" id="step">
    <button type="submit" class="btn btn-outline-success btn-lg" form="plushuit" value="Submit">+ 9 Points</button>
    </form>

    <form action="index.php?content=ajoutPoints" method="post" id="moinshuit">
    <input hidden value= 9 name="valPointmoins" id="step">
    <button type="submit" class="btn btn-outline-danger btn-lg" form="moinshuit" value="Submit">- 9 Points</button>
    </form>
  </div>

  <div class="col-3 text-center">
  <form action="index.php?content=ajoutPoints" method="post" id="plusdouze">
    <input hidden value= 18 name="valPoint" id="step">
    <button type="submit" class="btn btn-outline-success btn-lg" form="plusdouze" value="Submit">+ 18 Points</button>
    </form>

    <form action="index.php?content=ajoutPoints" method="post" id="moinsdouze">
    <input hidden value= 18 name="valPointmoins" id="step">
    <button type="submit" class="btn btn-outline-danger btn-lg" form="moinsdouze" value="Submit">- 18 Points</button>
    </form>
  </div>


</div>

<?php
// Création des conditions pour la Récuperation de données
$where = "operation = 'ajout points' or operation = 'ajout manuel'";
// Utilisation des conditons pour récupérer uniquement Certaines données de la table Historique
$tableData = tableSqlWhere("historique",$where);
// fonction affichant un tableau rempli des données récupéré plus Haut.
affichTablePoints($tableData, "Historique");


?>