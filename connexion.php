
<?php

    //echo("<pre>");
    //var_dump($_SESSION);
    //echo "</pre>";

    if (!empty($_POST['login']) && (!empty($_POST['mdp']))){



        $condition = array(
                    "login" => $_POST['login'],
                    "mdp"   => $_POST['mdp']
                    );
        $data = ["*"];
        $conn = connectionSql();
        $sql = "SELECT * FROM users WHERE login = '".$_POST['login']."' and mdp ='".$_POST['mdp']."'";
        $test = pg_fetch_assoc(pg_query($conn, $sql));
        //echo("<pre>");
        //var_dump($test);
        //echo "</pre>";
        if($test){
            if ($test['login'] === $_POST['login'] && $test['mdp'] === $_POST['mdp']){
                unset($_SESSION['faux']);
                $_SESSION["connect"] = $test;
                if ($test["accesrh"] ==="1"){
                    ?><script> location.replace("/index.php?content=connexionRh"); </script><?php
                }
                if ($test["accesboutique"] ==="1"){
                    ?><script> location.replace("/index.php?content=connexionBoutique"); </script><?php
                }
            }
        }else{
            unset($_POST);
            $_SESSION["faux"] = true;
            ?><script> location.replace("/index.php?content=connexion"); </script><?php
            
        }


    }else{

?>



<!-- Page de connexion de base lors de la connexion sur la page ( FORMULAIRE ) -->
<div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
        <form action="index.php?content=connexion" method="post" id="formConnex">

                <br>
            <div>
                <label for="login"> Login : </label>
                <input type="text" class="form-control" placeholder="exemple : p.nom" name="login" required>
            </div>
            <br>
            <div>
                <label for="login"> Mot de passe : </label>
                <input type="password" class="form-control" placeholder="Saisir le mot de passe ici" name="mdp" required>
            </div>
            </form>

            <?php if(isset($_SESSION['faux']) && $_SESSION["faux"]){

                echo('<div class="row text-center text-danger">');
                echo('<p> Login ou mot de passe incorrect merci de bien vouloir réessayer</p>');
                echo('</div>');

            }
            ?>
            <br>

            <div class="text-center">
                <button class="btn btn-secondary btn-success" type="submit" form="formConnex" value="Submit">Valider</button>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

<?php

    }
?>