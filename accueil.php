<?php

// *----------------------------------------------------------------------*
// *  PHP        : accueil.php                                            *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Affichage par défaut du site post connexion                         *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


// echo"<pre>";
// var_dump($_SESSION);
// echo"</pre>";

// Vérification de la variable de SESSION
if (!empty($_SESSION)) {
  
  // Si la variable de session est égale à "faux" (du à un mot de passe éronnée la réinitialise)
  if(!empty($_SESSION["faux"])){
    if($_SESSION["faux"]){
      unset($_SESSION["faux"]);
      // Recharge la page pour prendre en compte les modifications
      ?><script> location.replace("/index.php?content=accueil"); </script><?php
    
    }
  }

if (!empty($_SESSION["connect"])) {

  // Si la variable contient un accès au Ressource humaine lui affiche la page correspondante
  if($_SESSION["connect"]["accesrh"] === "1"){
    // remplace la page actuel par la page d'accueil dédié au RH
    ?><script> location.replace("/index.php?content=connexionRh"); </script><?php
  }
  // Si la variable contient un accès boutique lui affiche la page correspondante
  if($_SESSION["connect"]["accesboutique"] === "1"){
    // remplace la page actuel par la page d'accueil dédié à la boutique 
    ?><script> location.replace("/index.php?content=connexionBoutique"); </script><?php
  }
}

}
?>

<!-- Affichage du message de bienvenue ainsi que d'une image-->
<div class="row">
                <div class ="text-center">
                  

                    <b> Bienvenue sur l'application de gestion des points jaunes </b>
                    <br>
                    <br>
                    <br>
                    <b class = "text-warning"> Pour commencer à utiliser l'application, merci de vous identifiez </b>
                    <br>
                    <b class = "text-warning"> grâce au bouton présent dans le menu. </b>
                    <br>
                    <br>
                    <br>
                    <img src="../images/imgBoutique.png" alt="" height = 400>
    