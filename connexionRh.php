<?php

if(!empty($_SESSION["connect"]["accesrh"])){
    if($_SESSION["connect"]["accesrh"] === "1"){
        ?>  
        <div class="row">
            <div class ="text-center">
                <b> Bienvenue sur l'application de gestion des Points Jaune </b>
                <br>
                <br>
                <br>
                <b class = "text-warning"> Vous êtes connecté avec un compte Ressource Humaine </b>
                <br>
                <br>
                <br>
                <br>
                <img src="../images/rhImage.png" alt="" height = 400>

















            </div>
        </div>
        <?php
    }else{
        echo("Vous n'avez pas les droits pour accéder à cet endroit");
    }

}else{
    echo("Vous n'avez pas les droits pour accéder à cet endroit");
}

