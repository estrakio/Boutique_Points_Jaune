<?php
    unset($_SESSION["connect"]);
    unset($_SESSION["supp"]);
    unset($_SESSION["salarie"]);
    unset($_SESSION["test"]);  
    //videTable("salarie");  
    ?><script> location.replace("/index.php?content=accueil"); </script><?php
?>
<br>
<div  class="row text-center">
    <div>
        <b> Vous avez bien été déconnecté !</b>
    </div>
</div>

