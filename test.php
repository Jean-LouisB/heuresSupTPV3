<?php
$titre = "Page de tests";
include('includes/AllIncludes.php');


$heureDecimale = 1.625;
$heureArrondie = round($heureDecimale, 2);
$heureExplode = explode('.',$heureArrondie);
$M = round($heureExplode[1]*(60/100));
  


?>

<body class="bodyperso">
    <?php

print_r($heureExplode);
echo $M;
    
    ?>
    
</body>