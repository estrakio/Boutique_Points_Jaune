<?php

// *----------------------------------------------------------------------*
// *  PHP        : connectSql.php                                         *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  function de connexion a la BDD                                      *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*

    function connectionSql(){
        // Connect to the database
        $conn = pg_connect("host=db dbname=estrakio user=estrakio password=bonjour");
        // Show the client and server versions
        //print_r(pg_version($conn));
        return $conn;
    }
?>