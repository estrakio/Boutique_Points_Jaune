<?php

//echo"<pre>";
//var_dump($_POST);
//echo"<pre>";

$tableau_utilisateur = [];
$conn = connectionSql();
$sql = "SELECT * FROM users";
$result = pg_fetch_all(pg_query($conn, $sql));
foreach ($result as $ligne_utilisateur) {
    $utilisateur = array(
                    "id" => $ligne_utilisateur["id"],
                    "nom" => $ligne_utilisateur["nom"],
                    "prenom" => $ligne_utilisateur["prenom"],
                    "poste occupé" => $ligne_utilisateur["poste"],
                    "login" => $ligne_utilisateur["login"],
                    "mot de passe" => $ligne_utilisateur["mdp"],
                    "accès Ressource Humaine" => $ligne_utilisateur["accesrh"],
                    "accès Boutique" => $ligne_utilisateur["accesboutique"],
    );
    array_push($tableau_utilisateur, $utilisateur);
}
?>
<form action="index.php?content=mdpUsers" method="post" id="modification_user">
    <table class="table table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">nom</th>
                <th scope="col">prenom</th>
                <th scope="col">poste occupé</th>
                <th scope="col">login</th>
                <th scope="col">Mot de passe</th>
                <th scope="col">Accès ressource humaine</th>
                <th scope="col">Accès boutique</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //echo"<pre>";
            //var_dump($tableau_utilisateur);
            //echo"<pre>";
                foreach ($tableau_utilisateur as $ligne_utilisateur) {
                
                        echo("<tr>");
                        echo("<td>".$ligne_utilisateur["id"]."</td>");
                        echo("<td>".$ligne_utilisateur['nom']."</td>");
                        echo("<td>".$ligne_utilisateur['prenom']."</td>");
                        echo("<td>".$ligne_utilisateur["poste occupé"]."</td>");
                        echo("<td>".$ligne_utilisateur["login"]."</td>");
                        echo("<td>
                                <input 
                                    type='text' 
                                    class='form-control' 
                                    placeholder='' 
                                    name='mdp_".$ligne_utilisateur["id"]."'
                                >
                            </td>");
                        ///
                        echo ('<td>
                                    <select class="form-control" id="" name="rh_'.$ligne_utilisateur["id"].'">');
                                    if($ligne_utilisateur["accès Ressource Humaine"] == '1'){
                                        echo('<option>oui</option>');
                                        echo('<option>non</option>');
                                    }else{
                                        echo('<option>non</option>');
                                        echo('<option>oui</option>');
                                    }
                                    echo('</select>');
                        echo('</td>');
                        ///
                        //
                        echo ('<td>
                                    <select class="form-control" id="" name="boutique_'.$ligne_utilisateur["id"].'">');
                                    if($ligne_utilisateur["accès Boutique"] == '1'){
                                    echo('<option>oui</option>');
                                    echo('<option>non</option>');
                                    }else{
                                        echo('<option>non</option>');
                                        echo('<option>oui</option>');
                                    }
                                    echo('</select>');
                        echo('</td>');
                        //
                        echo("</tr>");
                }
            ?>
        </tbody>
    </table>
</form>
<div class="text-center">
    <button class="btn btn-secondary btn-lg" type="submit" form="modification_user" value="Submit">Valider</button>
</div>
<?php
if (!empty($_POST)){
    foreach ($_POST as $champ => $value) {
        if(!empty($value)){
            $new_list  = explode('_',$champ);
            if( $new_list[0] == "rh" or $new_list[0] == "boutique"){
                if ($value == "oui") {
                    $nouvelle_valeur = 1;
                    
                    if($new_list[0] == "rh"){
                        $champ = 'accesrh';
                    }else{
                        $champ = 'accesboutique';
                    }

                    $sql = "UPDATE users SET $champ = $nouvelle_valeur WHERE id = $new_list[1];";
                }elseif ($value == "non") {
                    $nouvelle_valeur = 0;

                    if($new_list[0] == "rh"){
                        $champ = 'accesrh';
                    }else{
                        $champ = 'accesboutique';
                    }

                    $sql = "UPDATE users SET $champ = $nouvelle_valeur WHERE id = $new_list[1];";

                }
            }else{
                $nouvelle_valeur = $value;
                $sql = "UPDATE users SET $new_list[0] = '$nouvelle_valeur' WHERE id = $new_list[1];";

            }
            pg_query($conn, $sql);
            
        }
    }
    unset($_POST);
    ?><script> location.replace("/index.php?content=mdpUsers"); </script><?php
    
}