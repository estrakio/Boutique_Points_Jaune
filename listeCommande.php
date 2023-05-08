<?php

// *----------------------------------------------------------------------*
// *  PHP        : listeCommande.php                                      *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 20/03/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui affiche la liste des commandes effectué                    *
// *  pour les commandes de points jaunes                                   *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


$table = "Historique";
$where = "operation = 'vente de jus'";
$tableData = tableSqlWhere($table,$where);
affichTablePoints($tableData, $table);
?>