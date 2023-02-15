<?php
$table = "Historique";
$where = "operation = 'vente de jus'";
$tableData = tableSqlWhere($table,$where);
affichTablePoints($tableData, $table);
?>