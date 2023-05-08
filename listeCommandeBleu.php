<?php

// *----------------------------------------------------------------------*
// *  PHP        : listeCommandeBleu.php                                      *
// *  Site       : site-point-jaune                                       *
// *  AUTEUR     : WALTER KARL                                            *
// *  DATE       : 06/04/2023                                             *
// *  DATE       :                                                        *
// *  BUT PAGE   : -------------------------------------------------------*
// *                                                                      *
// *  Page qui affiche la liste des commandes effectué                    *
// *  pour les commandes de points bleu                                   *
// *----------------------------------------------------------------------*
// *  MODIFICATIONS                                                       *
// *                                                                      *
// *                                                                      *
// *----------------------------------------------------------------------*


$table = "HistoriqueBleu";
$where = "operation = 'vente de jus'";
$tableData = tableSqlWhere($table,$where);
affichTablePoints($tableData, $table);
?>