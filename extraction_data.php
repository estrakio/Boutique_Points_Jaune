<?php


include_once("sql.php");

$conn = connectionSql();
$requete_produits_jaune = "table produits;";
$table_produits_jaune = pg_fetch_all(pg_query($conn, $requete_produits_jaune));
$requete_historique = "select * from historique where operation = 'vente de jus';";
$table_historique_jaune = pg_fetch_all(pg_query($conn, $requete_historique));
$produits_jaune = [];


foreach ($table_produits_jaune as $produit) {
    $ligne_produit = array(
        "Code article" => $produit["codeabap"],
        "libelle" => $produit["nomproduit"],
        "valeur" => $produit["valpointsjaune"],
        "nombre de col par carton" => $produit["col"],
        "quantite vendu" => 0
    );
    array_push($produits_jaune, $ligne_produit);
}
// echo("<pre>");
// var_dump($produits_jaune);  
// echo("</pre>");
foreach ($table_historique_jaune as $transaction) {

    $explosion_commande = explode("/", $transaction["detail"]);
    $taille_commande = count($explosion_commande);
    $a = 0;
    // echo $taille_commande;
    // echo("<pre>");
    // var_dump($explosion_commande);  

    while ($a < $taille_commande -1) {
        $article_cout = explode(";",$explosion_commande[$a]);
        foreach ($produits_jaune as &$produit) {        
            if($produit["Code article"] == $article_cout[0]){
                //echo("total points $article_cout[1] <br>");
                //echo("Valeur produit ".$produit["valeur"]." <br>");
                $qte = $article_cout[1] / $produit["valeur"];
                //echo("quantite ".$qte."<br> <br>");
                $produit["quantite vendu"] += $qte;
            }
        }
        $a += 1; 
    } 

}

affichTable($produits_jaune, "Historique des points jaunes");
// echo("<pre>");
// var_dump($$table_produits_bleus);  
// echo("</pre>");
// ____________________________________________________________PRODUITS BLEUES____________________________________________________________________________
$requete_produits_bleus = "table produitsbleu;";
$table_produits_bleus = pg_fetch_all(pg_query($conn, $requete_produits_bleus));
$requete_historique_bleu = "select * from historiquebleu where operation = 'vente de jus';";
$table_historique_bleus = pg_fetch_all(pg_query($conn, $requete_historique_bleu));
$produits_bleus = [];

// echo("<pre>");
// var_dump($table_produits_bleus);  
// echo("</pre>");

foreach ($table_produits_bleus as $produit) {
    $ligne_produit = array(
        "Code article" => $produit["codeabap"],
        "libelle" => $produit["nomproduit"],
        "valeur" => $produit["valpointsbleu"],
        "nombre de col par carton" => $produit["col"],
        "quantite vendu" => 0
    );
    array_push($produits_bleus, $ligne_produit);
}
// echo("<pre>");
// var_dump($table_historique_bleus);  
// echo("</pre>");

foreach ($table_historique_bleus as $transaction_bleu) {

    $explosion_commande_bleus = explode("/", $transaction_bleu["detail"]);
    $taille_commande = count($explosion_commande_bleus);
    $a = 0;
    //echo("<pre>");
    //var_dump($explosion_commande_bleus);  
    //echo("</pre>");

    while ($a < $taille_commande -1) {
        $article_cout = explode(";",$explosion_commande_bleus[$a]);
        foreach ($produits_bleus as &$produit) {
            // echo ("Article c out : " . $article_cout[0]."<br>");        
            if($produit["Code article"] == $article_cout[0]){
                // echo("total points $article_cout[1] <br>");
                // echo("Valeur produit ".$produit["valeur"]." <br>");
                $qte = $article_cout[1] / $produit["valeur"];
                //echo("quantite ".$qte."<br> <br>");
                $produit["quantite vendu"] += $qte;
            }
        }
        $a += 1; 
    } 

}
echo ("<br> <br>");
affichTable($produits_bleus, "Historique des points Bleues");
