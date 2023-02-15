<div class="row">
    <div class="col-3 "></div>
    <div class="col-6">
        <form action="index.php?content=matricule" method="post" id="formClients">
        <input hidden value="clients" name="content" id="content">
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
        </form>
        <div class="text-center">
            <button class="btn btn-secondary btn-lg" type="submit" form="formClients" value="Submit">Valider</button>
            <br><br>
        </div>
    </div>
    <div class="col-3"></div>
</div>


<?php
    if (isset(
        $_POST['nom'], 
        $_POST['prenom']
        ) && (!empty($_POST['nom']))  && (!empty($_POST['prenom'])) 
        ){
            $condition = array(
                "nom" => $_POST['nom'],
                "prenom" => $_POST['prenom'],
            );
            
            $data = ["matricule", "nbrpoint"];

            //echo(selectSql("salarie", $condition, $data));
            $result = (selectSql("salarie", $condition, $data));
            if (!empty($result)){
?>
<div class="row">
    <div class="col d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo(ucfirst($_POST['nom'])); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo(ucfirst($_POST['prenom'])); ?></h6>
                <p class="card-text"><?php echo("MATRICULE : ".ucfirst($result["matricule"])); ?></p>
                <p class="card-text"><?php echo("NOMBRE DE POINTS : ".ucfirst($result["nbrpoint"])); ?></p>
            </div>
        </div>           
    </div>
</div>


<?php
            } else {
                ?>
                <div class = "row">
                    <div class="text-center">   
                        <b>
                            Le salarié recherché n'existe pas.
                        </b>
                    </div>
                </div>
                <?php
            }
        }
?>