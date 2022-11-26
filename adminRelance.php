<?php


$titre = "Relance semaine validée";
include ('includes/AllIncludes.php');
if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}

$dates = getBornes($pdo);
$date1 = ($dates[0]['datedebut']);
$date2 = ($dates[0]['datefin']);

$listeValidation = relance($pdo);

function relance($pdo)
{
    $sql ="SELECT s.Nom, s.Prenom 
          FROM salaries s
          LEFT JOIN vue_matriculesemvalide v
          ON s.Matricule = v.MatOk
          WHERE v.MatOk IS Null
          AND s.Type > 1
          Order by Nom";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;


}


?>
<body class="bodyperso">
<div class="containerperso">
<H3>Responsables qui doivent encore valider la semaine :</H3>
</div>
<div class="container" style="width:30%; min-width:300px;">
  <table class="table">
    <thead>
      <tr>
        <th scope="col" style="text-align:center;">Nom Prénom</th>
      </tr>
    </thead>
          <tbody>
            <?php
              for($i=0;$i< count($listeValidation);$i++){
                ?>
                <tr>

                  <td style="text-align:center;"><?=$listeValidation[$i]['Nom']." ".$listeValidation[$i]['Prenom']?></td>
                
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

