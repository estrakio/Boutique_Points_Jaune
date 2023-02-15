<?php
    //echo("<pre>");
    //var_dump($_POST);
    //echo("</pre>");


?>
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
    $conn = connectionSql();
    $sql = "SELECT * FROM salarie WHERE matricule ='".$_POST["matricule"]."';"; 

    $result = pg_fetch_assoc(pg_query($conn, $sql));

    if(empty($result)){
        echo('
            <div class="text-center">
            <p>Le matricule saisi ne contient aucune données</p>
            </div>
        
        
        ');
    }else{
    //echo("<pre>");
    //var_dump($result);
    //echo("</pre>");

    ?> 
        <div class="row"> 
    <?php
    
            echo("<tr>");
          //echo("<th scope='row'>1</th>");
            echo("<td>".$result["matricule"]."</td>");
            echo("<td>".$result['nom']."</td>");
            echo("<td>".$result['prenom']."</td>");
            echo("<td>".$result["nbrpoint"]."</td>");
            echo("</tr>");

    
    ?>

    </tbody>
</table>

<div class="row">
        <div class="col-3 "></div>
        <div class="col-6">
            <form action="index.php?content=gestionUsers" method="post" id="formRetour">
            </form>
            <div class="text-center">
                <button class="btn btn-secondary btn-lg" type="submit" form="formRetour" value="retour">Retour</button>
                <br><br>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

<?php
    }
?>