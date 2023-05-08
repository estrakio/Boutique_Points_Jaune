<?php

// *----------------------------------------------------------------------*
// *  PHP        : historique_bleu.php                                         *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 24/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui permet d'afficher la table Historique                      *
// *----------------------------------------------------------------------*
// *  Création de la page                                                 *
// *   WK 24/03/2023                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


$data = tableSqlOrderById("historiqueBleu");

affichTablePoints($data,"HISTORIQUE POINTS BLEUES");