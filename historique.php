<?php

// *----------------------------------------------------------------------*
// *  PHP        : historique.php                                         *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui permet d'afficher la table Historique                      *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


$data = tableSqlOrderById("historique");

affichTablePoints($data,"HISTORIQUE POINTS JAUNES");