<?php
$titre = "Validation des heures à payer";

include ('includes/AllIncludes.php');
if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}

$user = getUserConnect($Matricule,$pdo);
$droit = $user[0]['Type'];

if ($droit == 3){

  $liste = getAPayer($pdo);

} else {

  echo "Vous n'avez pas les droits";

}
/* echo "<pre>";
print_r($liste);
echo "</pre>"; */
?>

<body class="bodyperso">

    <div class="containerperso">
<h2>Liste des heures à payer pour le report dans la paye.</h2>
          <table class="tableperso">
            <thead class="thead">
              <tr>
                <th class="thperso" scope="col">Nom</th>
                <th class="thperso" scope="col">Date</th>
                <th class="thperso" scope="col">Nombre d'heure<br>(non majorée)</th>
                <th class="thperso" scope="col"></th>

              </tr>
            </thead>
            <tbody>

          <?php

            for($i=0;$i< count($liste);$i++){
              
          
          ?>
          
            <tr>

                <td class="tdperso"><?=$liste[$i]['Nom']?></td>
                <td class="tdperso"><?=$liste[$i]['Date']?></td>
                <td class="tdperso"><?php echo afficheHeureMinute($liste[$i]['heureAPayer']);?></td>
                <td class="tdepais"><a class="buttonnormal" href="actionPayeHeure.php?id=<?=$liste[$i]['ID_enr'];?>">Payer</a></td>
                


              </tr>
            
          <?php 
          }
          ?>
          </tbody>
          </table>
    </div>


</body>
<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>
</html>
