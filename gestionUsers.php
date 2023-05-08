<?php

// *----------------------------------------------------------------------*
// *  PHP        : gestionUsers.php                                       *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui permet d'avoir la liste des Salariées                      *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*

//echo("<pre>");
//var_dump($_POST);
//echo("</pre>");
?>


<div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
        <form action="imprimable.php" method="post" id="impression">
        <input hidden value="clients" name="content" id="content">
        </form>
        <div class="text-center">
            <button class="btn btn-secondary btn-lg" type="submit" form="impression" value="Submit">Imprimer</button>
            <br><br>
        </div>
    </div>
    <div class="col-3"></div>
</div>
<div class="row">
        <div class="col-3 "></div>
        <div class="col-6">
            <form action="index.php?content=salarie_rechercher" method="post" id="formMatricule">
                <br>
                <div>
                    <label for="matricule">Veuillez saisir le matricule à rechercher : </label>
                    <input type="text" class="form-control" placeholder="matricule" name="matricule" required>
                </div>
                <br>
            </form>
            <div class="text-center">
                <button class="btn btn-secondary btn-lg" type="submit" form="formMatricule" value="Submit">Valider</button>
                <br><br>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

<table class="table table-sm">
    <thead class="thead-dark">
        <tr>
            <th scope="col">MATRICULE</th>
            <th scope="col">NOM</th>
            <th scope="col">PRENOM</th>
            <th scope="col" >POINT JAUNE</th>

        </tr>
    </thead>
    <tbody>
    <?php
    $result = (tableSqlSalarieActif("salarie"));

    ?> 
        <div class="row"> 
    <?php
    foreach ($result  as $salarie) {
    
            echo("<tr>");
          //echo("<th scope='row'>1</th>");
            echo("<td>".$salarie["matricule"]."</td>");
            echo("<td>".$salarie['nom']."</td>");
            echo("<td>".$salarie['prenom']."</td>");
            echo("<td>".$salarie["nbrpoint"]."</td>");
            echo("</tr>");

    
    }
    ?>

    </tbody>
</table>
