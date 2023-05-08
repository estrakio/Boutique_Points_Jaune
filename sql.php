<?php

// *----------------------------------------------------------------------*
// *  PHP        : sql.php                                                *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page de création des tables et fonction SQL                         *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


    include "connectSql.php";
    $conn = connectionSql();



    $sql = "CREATE TABLE IF NOT EXISTS Users(
        id SERIAL,
        nom VARCHAR(50),
        prenom VARCHAR(50),
        poste VARCHAR(50),
        login VARCHAR(50),
        mdp VARCHAR(50),
        accesrh INT,
        accesBoutique INT,
        PRIMARY KEY(id)
    );
    ";

    $sql .= "CREATE TABLE IF NOT EXISTS Produits(
        id SERIAL,
        codeabap VARCHAR(50),
        nomproduit VARCHAR(50),
        valpointsjaune INT,
        col VARCHAR(50),
        actif VARCHAR(50),
        PRIMARY KEY(id)
    );
    ";

    $sql .= "CREATE TABLE IF NOT EXISTS ProduitsBleu(
        id SERIAL,
        codeabap VARCHAR(50),
        nomproduit VARCHAR(50),
        valpointsbleu INT,
        col VARCHAR(50),
        actif VARCHAR(50),
        PRIMARY KEY(id)
    );
    ";

    $sql .= "CREATE TABLE IF NOT EXISTS salarie(
        id SERIAL,
        nom VARCHAR(50),
        prenom VARCHAR(50),
        matricule VARCHAR(50),
        nbrpoint INT,
        actif INT,
        PRIMARY KEY(id)
    );
    ";

    
    $sql .= "CREATE TABLE IF NOT EXISTS Facture(
        id SERIAL,
        datefacture TIMESTAMP,
        chemin VARCHAR(100),
        id_salarie INT NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(id_salarie) REFERENCES salarie(id)
    );
    ";
    
    $sql .= "CREATE TABLE IF NOT EXISTS historique(
        id SERIAL,
        posneg VARCHAR(50),
        operation VARCHAR(50),
        valeur INT,
        beneficiaire VARCHAR(50),
        detail VARCHAR(2000),
        date TIMESTAMP,
        id_user INT NOT NULL,
        PRIMARY KEY(id),
        FOREIGN KEY(id_user) REFERENCES Users(id)
    );
    ";

$sql .= "CREATE TABLE IF NOT EXISTS historiqueBleu(
    id SERIAL,
    posneg VARCHAR(50),
    operation VARCHAR(50),
    valeur INT,
    beneficiaire VARCHAR(50),
    detail VARCHAR(2000),
    date TIMESTAMP,
    id_user INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(id_user) REFERENCES Users(id)
);
";


    pg_query($conn, $sql);

    $test = "SELECT prenom FROM users WHERE id = 1";
    $valid = pg_query($conn, $test);
    $result = pg_fetch_row($valid)[0];

    if ($result != "karl"){

        $insert = " INSERT INTO users (nom, prenom, poste, login, mdp, accesrh, accesboutique)
        VALUES ('walter', 'karl', 'informatique', 'kwalter', 'bonjour', 1, 1);";

        pg_query($conn, $insert);
    }







    // Fonction permettant d'insérez n'importe quelle donnée dans n'importe quelle table.
    function insertSql($nomDeTable,$tableau){

        $conn = connectionSql();
        $champs = "";
        $listeValues = "";

        foreach($tableau as $nomChamp => $valeurs){
            $champs .= $nomChamp;
            $valeurs = pg_escape_string($conn, $valeurs);
            $listeValues .= "'".$valeurs."'";
            if ( next($tableau)){
                $champs .= ", ";
                $listeValues .= ", ";
            }
        }
        $nomDeTable = strtolower($nomDeTable);
        $champs = strtolower($champs);
        $listeValues = strtolower($listeValues);

        $sql = " INSERT INTO ".$nomDeTable."(".$champs.") VALUES (".$listeValues.");";
        pg_query($conn, $sql);
    }



    // Fonction permettant de faire un select avec condition sur n'importe quelle table
    function selectSql($table, $tableauCondition, $listeData){

        $conn = connectionSql();
        $data = "";
        $condition = "";

        foreach($listeData as $col){

            $data .= $col; 

            if ( next($listeData) != false ){
                $data .= ", ";
            }

        }

        foreach($tableauCondition as $conditionTab => $valeur){
            if (is_string($valeur)){
                $valeur = " '".$valeur."'";
                $condition .= $conditionTab." like ".$valeur;

            }
            else{
                $condition .= $conditionTab." = ".$valeur;
            }

            if ( next($tableauCondition)){
                $condition .= " AND ";
            }
        }
        $data = strtolower($data);
        $table = strtolower($table);
        $condition = strtolower($condition);

        $sql = "SELECT ".$data." FROM ".$table." WHERE ".$condition.";"; 


        return(pg_fetch_assoc(pg_query($conn, $sql)));

    
        
    }

    function tableSql($table){

        $conn = connectionSql();
        $sql = "SELECT * FROM ".$table.";" ; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }

    function table_sql_ajout_point(){

        $conn = connectionSql();
        $sql = "SELECT * FROM salarie where actif = 1;" ; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }

    function tableSqlSalarieActif($table){

        $conn = connectionSql();
        $sql = "SELECT * FROM $table WHERE actif = 1 ORDER BY nom ASC;"; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }

    function tableSqlSProduitsActif(){

        $conn = connectionSql();
        $sql = "SELECT * FROM produits WHERE actif = '1' ORDER BY nomproduit ASC;"; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }

    function tableSqlSProduitsActifBleu(){

        $conn = connectionSql();
        $sql = "SELECT * FROM produitsBleu WHERE actif = '1' ORDER BY nomproduit ASC;"; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }

    function tableSqlOrderById($table){

        $conn = connectionSql();
        $sql = "SELECT * FROM ".$table." ORDER BY id DESC;"; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }
    
    function tableSqlWhere($table, $where){

        $conn = connectionSql();
        $sql = "SELECT * FROM ".$table."  WHERE ".$where." ORDER BY id DESC;"; 

        return(pg_fetch_all(pg_query($conn, $sql)));
    }

    function videTable($table){

        $laTable = tableSql($table);
        $taille = count($laTable);
        $data = "";
        for ($i=0; $i <= $taille; $i++) { 
            # code...
            if($i === $taille){
                $data .= $i;

            }else{
                $data .= $i.", ";
            }
        }
        $conn = connectionSql();
        $sql = "DELETE FROM ".$table." WHERE id IN (".$data.") returning *;";
        pg_query($conn, $sql);
    }  

    function checkUtilisateurs($matricule){

        $conn = connectionSql();
        
        $matricule = strtolower($matricule);

        $sql = "SELECT nom FROM salarie WHERE matricule = '".$matricule."';"; 

        return(pg_fetch_assoc(pg_query($conn, $sql)));
    }

    function insertDataBot($table, $data) {
        // Connexion à la base de données
        $conn = connectionSql();

        // Génération de la requête d'insertion en utilisant les clés du tableau $data comme colonnes et les valeurs du tableau comme valeurs à insérer
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_values($data),);
        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        // Exécution de la requête et vérification du résultat
        $result = pg_query($conn, $query);
        if (!$result) {
            die("Erreur lors de l'exécution de la requête : " . pg_last_error($conn));
        }

    }

    function updateValue($table, $field, $newValue, $matricule) {
        // Connexion à la base de données
        $db = connectionSql();
        $newValue = intval($newValue);
        // Construction de la requête SQL
        $query = "UPDATE $table SET $field = $newValue WHERE matricule = '$matricule'";
        
        // Exécution de la requête
        $result = pg_query($db, $query);
        
        // Vérification du résultat
        if (!$result) {
            die("Erreur lors de la mise à jour de la valeur : " . pg_last_error($db));
        }
    }













        function has_next(array $_array)
        {
            return next($_array) !== false ?: key($_array) !== null;
        }








        // Fonction permettant d'insérez les nouveaux salarié dans la table correspondantes.
        function insertSqlSalarier($nomDeTable,$tableau){
            $conn = connectionSql();
            $champs = "";
            $listeValues = "";
            //$iteration = 0;
    
            foreach($tableau as $nomChamp => &$valeurs){
                $champs .= $nomChamp;


                if (is_int($valeurs)){
                    $listeValues .= $valeurs;
                }else {                
                    $valeurs = pg_escape_string($conn, $valeurs);
                    $listeValues .= "'".$valeurs."'";
    
    
                }
                //echo("<pre>");
                //var_dump($tableau);
                //echo("</pre>");
                //
                //echo("<br>");

                

                if (next($tableau) !== false){
                    $champs .= ", ";
                    $listeValues .= ", ";
                    // echo("iteration nr $iteration : $listeValues");
                    // $iteration += 1;
                    // echo("<br>");
    
    
                }
            }
            $nomDeTable = strtolower($nomDeTable);
            $champs = strtolower($champs);
            $listeValues = strtolower($listeValues);
    
            $sql = " INSERT INTO $nomDeTable ($champs) VALUES ($listeValues);";
            //echo( $sql);
            pg_query($conn, $sql);
        }