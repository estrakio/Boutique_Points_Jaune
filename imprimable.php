<?php
    include("sql.php");
?>


<div>

<table border="0" cellspacing="1" style="display: inline-block;" id="tableauSalarie">
    <tr>
        <th>MATR</th>
        <th>NOM</th>
        <th>PREN</th>
        <th style="border-right: 1px solid black;">POINT</th>
        <th>MATR</th>
        <th>NOM</th>
        <th>PREN</th>
        <th style="border-right: 1px solid black;">POINT</th>
        <th>MATR</th>
        <th>NOM</th>
        <th>PREN</th>
        <th style="border-right: 1px solid black;">POINT</th>
    </tr>
    <?php
    $result = tableSqlSalarieActif("salarie");
        $colcount = 1;
        $lastlinefull = 0;
        foreach ($result as $salarie) {
            if ($salarie["actif"] == 1){
                if ($colcount == 1){
                    echo "<tr>"; // enlève les parenthèses autour de l'instruction echo
                }
                
                echo "<td>" . $salarie["matricule"] . "</td>"; // utilise la concaténation pour afficher les valeurs dans les cellules de la table
                echo "<td>" . $salarie['nom'] . "</td>";
                echo "<td>" . $salarie['prenom'] . "</td>";
                echo "<td style='border-right: 1px solid black;'>" . $salarie["nbrpoint"] . "</td>";
                if ($colcount == 3){
                    echo "</tr>"; // enlève les parenthèses autour de l'instruction echo
                }

                $colcount++; // incrémentation du compteur
                if ($colcount == 4){
                    $colcount = 1;
                    $lastlinefull = 1;
                }
                else{
                    $lastlinefull = 0;
                }
            }
        }
        if ($lastlinefull == 0){
            echo "</tr>";
        }

        echo "</table>";
    ?> 

</div>
<button onclick="window.print(document.getElementById('tableauSalarie'))">Imprimer</button>