<?php
session_start();
date_default_timezone_set('UTC');
include("fonction.php");
?>

<html>

<head>
    <title> Boutique aux points </title>

    <!-- css necessaire pour Bootstrap -->
    <link rel="stylesheet" href="./bootstrap/5.1.2/css/bootstrap.min.css">

    <!--  Mon css perso pour inclure les polices de caracteres-->
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/index.css">

    <!-- scripts necessaires pour bootstrap -->
    <script src="./bootstrap/5.1.2/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php
    include "sql.php";
    ?>

    <!-- DIV = Ce que je veux dépendant de ce que je met dedans  -->
    <div id="header" class="row">
        <div class="col-4 gauche"><?php include "menuGauche.php"; ?></div>
        <div class="col-4 milieu"></div>
        <div class="col-4 droite"></div>
    </div>

    <div id="content" class="container">
        <?php

        if (isset($_GET["content"])) {

            include $_GET["content"] . ".php";
        } else {
            include "accueil.php";
        }
        ?>

    </div>

    <div id="footer" class="row">

</body>

</html>