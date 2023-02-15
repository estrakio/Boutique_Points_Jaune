<!--
  <nav class="navbar navbar-expand-lg">

<div class="container-fluid">
    <a class="navbar-brand" href="index.php?content=accueil">
      <img src="../images/maison.png" alt="" height="50"> 
    </a>   
  </div>

  <div class="container-fluid">
    <a class="navbar-brand" href="index.php?content=accueil">
      <img src="../images/connect.png" alt="" height="50"> 
    </a>   
  </div>
-->
</nav>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand text-center" href="index.php?content=accueil"><img src="../images/home_ rond.png" alt="" height="50"> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php if(empty($_SESSION['connect'])){
        ?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php?content=connexion"><img src="../images/connexion.png" alt="" height="50"></a>
        </li>

        <?php 
        }
        if( !empty($_SESSION['connect'])){
        ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?content=ticket"><img src="../images/deconnexion.png" alt="" height="50"></a>
        </li>
        <?php
                }
        ?>
        <?php if( isset($_SESSION['connect']['accesboutique'])){
                if ($_SESSION['connect']['accesboutique'] ==="1"){
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../images/coteMag.png" alt="" height="50">
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-warning" href="index.php?content=caisse">Nouvelle commande (points jaunes)</a></li>
            <li><a class="dropdown-item text-primary" href="index.php?content=caisseBleu">Nouvelle commande (points bleus)</a></li>
            <li><a class="dropdown-item" href="index.php?content=annulerCommande">Annuler une commande</a></li>
            <li><a class="dropdown-item text-warning" href="index.php?content=ajoutProduit">Gestion des produits (points Jaunes)</a></li>
            <li><a class="dropdown-item text-primary" href="index.php?content=ajoutProduitBleu">Gestion des produits (points Bleus)</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php?content=listeCommande">Liste des commandes</a></li>
            <li><a class="dropdown-item" href="index.php?content=gestionUsers">Liste des Salariés</a></li>
            <li><a class="dropdown-item" href="index.php?content=matricule">Rechercher un matricule</a></li>
            <li><a class="dropdown-item" href="index.php?content=extraction_data">Extraction de données</a></li>
          </ul>
        </li>
        <?php 
              }
                }
            if( isset($_SESSION['connect']['accesrh'])){
                if ($_SESSION['connect']['accesrh'] ==="1"){
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../images/coteRh.png" alt="" height="50">
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?content=ajoutPoints">Ajout de points globals</a></li>
            <li><a class="dropdown-item" href="index.php?content=majUsers">Mise à jour des salariés</a></li>
            <li><a class="dropdown-item" href="index.php?content=pointsManuel">Ajout de points par matricule</a></li>
            <li><a class="dropdown-item" href="index.php?content=transfertPoints">Transfert des points physique</a></li>
            <li><a class="dropdown-item" href="index.php?content=gestionUsers">Liste des salariés</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php?content=matricule">Rechercher un matricule</a></li>
          </ul>
        </li>
        <?php 
                }
            }
      ?>
      <?php 

if( isset($_SESSION['connect']['accesrh']) ){
  if ($_SESSION['connect']['accesrh'] ==="1" && $_SESSION['connect']['accesboutique'] ==="1"){
    ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../images/admin.png" alt="" height="50">
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?content=historique">Historique des transactions</a></li>
            <li><a class="dropdown-item" href="index.php?content=ajoutUser">Ajouter un utilisateur</a></li>
            <li><a class="dropdown-item" href="index.php?content=mdpUsers">Gérer un compte utilisateur</a></li>
          </ul>
        </li>
        <?php 
                }
              }
              ?>
      </ul>
    </div>
  </div>
</nav>