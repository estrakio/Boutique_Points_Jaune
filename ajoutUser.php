<?php 
    //echo ("<pre>");
    //var_dump($_POST);
    if (!empty($_SESSION["new_user"])) {
        unset($_SESSION['new_user']);
        echo'<b class = "text-center text-success" > User créé avec succès</b> ';

    }
    //echo ("</pre>");

    if (!empty($_POST["etape"])) {
        $data  = array(
            "nom" => strtolower($_POST["nom"]),
            "prenom" => strtolower($_POST["prenom"]),
            "poste" => strtolower($_POST["poste"]),
            "login" => strtolower($_POST["login"]),
            "mdp" => strtolower($_POST["mdp"]),
            "accesrh" => $_POST["accesrh"],
            "accesboutique" => $_POST["accesboutique"],
        );
        $conn = connectionSql();
        $test = "SELECT * FROM users where login = '".strtolower($_POST["login"])."';";
        $user_existant = pg_fetch_assoc(pg_query($conn, $test));
        // echo ("<pre>");
        // var_dump($user_existant );
        // echo ("</pre>");    
        // echo ($test);    
        if($user_existant){
            unset($_POST["etape"]);
            echo('<div class="row">');
                echo('<div class="text-center text-danger h3">');
                        echo ('<b style="margin-top:5vh;"> Utilisateur déjà présent dans la base de données ! </b>');
                echo('</div>');
            echo('</div>');
        }else{
        $insert = " INSERT INTO users (nom, prenom, poste, login, mdp, accesrh, accesboutique) VALUES ('".strtolower($_POST["nom"])."', '".strtolower($_POST["prenom"])."', '".strtolower($_POST["poste"])."', '".strtolower($_POST["login"])."', '".$_POST["mdp"]."',". intval($_POST["accesrh"]).",". intval($_POST["accesboutique"]).");";
        pg_query($conn, $insert);
        unset($_POST);
        echo('<div class="row">');
        echo('<div class="text-center text-success h3">');
                echo ('<b style="margin-top:5vh;"> Utilisateur créer dans la base de données ! </b>');
        echo('</div>');
    echo('</div>');
        }
    }



?>
<div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
        <b class = "text-center text-danger" > Cette page permet la création d'utilisateurs pour le site</b> 
        <form action="index.php?content=ajoutUser" method="post" id="ajouterUtilisateur">
        <input hidden value="1" name="etape" id="etape">
            <br>
            <div>
                <label for="nom">Nom</label>
                <input type="text" class="form-control" placeholder="Nom" name="nom" required>
            </div>
            <br>
            <div>
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" placeholder="Prénom" name="prenom" required>
            </div>
            <br>
            <div>
                <label for="poste">Poste de la personne</label>
                <input type="text" class="form-control" placeholder="Poste de la personne" name="poste" required>
            </div>
            <br>
            <div>
                <label for="login">Identifiant</label>
                <input type="text" class="form-control" placeholder="Identifiant" name="login" required>
            </div>
            <br>
            <div>
                <label for="mdp">Mot de passe</label>
                <input type="text" class="form-control" placeholder="Mot de passe" name="mdp" required>
            </div>
            <br>
            <div>
            <label for="accesrh">Accès ressources humaines</label>
            <select class="form-control" id="" name="accesrh">
                        <option>1</option>
                        <option>0</option>
            </select>
            </div>
            <br>
            <div>
            <label for="accesboutique">Accès boutique</label>
            <select class="form-control" id="" name="accesboutique">
                        <option>1</option>
                        <option>0</option>
            </select>
            </div>
            <br>

        </form>
        <div class="text-center">
            <button class="btn btn-secondary btn-lg" type="submit" form="ajouterUtilisateur" value="Submit">Valider</button>
            <br><br>
        </div>
    </div>
    <div class="col-3"></div>
</div>

