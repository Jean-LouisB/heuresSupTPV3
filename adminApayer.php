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

/* Cette fonction a été rajouté dans l'include, elle pourra être retiré d'ici après test (4/07/22)
function getAPayer($pdo) {

  $sql = "SELECT *
          FROM stock_hs INNER JOIN salaries ON salaries.Matricule = stock_hs.Matricule 
          WHERE APayer = 1 
          AND Payee = 0
          ORDER BY Nom, Date";
  $stmt = $pdo->prepare($sql);
 
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;


}*/

?>

<body class="bodyperso">

    <div class="container">

          <table class="table">
            <thead>
              <tr>
                <th scope="col">Nom</th>
                <th scope="col">Date</th>
                <th scope="col">H. à récupérer (1pour1)</th>
                <th scope="col">H.supp. (non majorée)</th>
                <th scope="col">Solidarité</th>
                <th scope="col">Justification</th>
                <th scope="col"></th>

              </tr>
            </thead>
            <tbody>

          <?php

            for($i=0;$i< count($liste);$i++){
              
          
          ?>
          
            <tr>

                <td><?=$liste[$i]['Nom']?></td>
                <td><?=$liste[$i]['Date']?></td>
                <td align="center"><?php echo afficheHeureMinute($liste[$i]['Recup']);?></td>
                <td align="center"><?= afficheHeureMinute($liste[$i]['HS_Maj']);?></td>
                <td align="center"><?=afficheHeureMinute($liste[$i]['JS']);?></td>
                <td><?=$liste[$i]['Commentaire']?></td>
                <td><a class="btn btn-primary" href="actionPayeHeure.php?id=<?=$liste[$i]['ID_enr'];?>">Payer</a></td>
                


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
