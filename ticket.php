<?php

// *----------------------------------------------------------------------*
// *  PHP        : ticket.php                                             *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui certifie la déconnexion d'un utilisateur                   *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*




    unset($_SESSION["connect"]);
    unset($_SESSION["supp"]);
    unset($_SESSION["salarie"]);
    unset($_SESSION["test"]);  
    //videTable("salarie");  
    ?><script> location.replace("/index.php?content=accueil"); </script><?php
?>
<br>
<div  class="row text-center">
    <div>
        <b> Vous avez bien été déconnecté !</b>
    </div>
</div>

