<?php

$titre = "Détail par salarié";
include ('includes/AllIncludes.php');

if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}

if ((isset($_POST['salarie']))){
    $matricule = $_POST['salarie'];
    $liste = getTopoTous($matricule,$pdo);
/*     echo "<pre>";
    print_r($liste);
    echo "</pre>"; */

} else {

}

$listesalaries = getSalarie($pdo); // permet de récupèrer la liste pour la liste déroulante.



function getTopoTous($Matricule, $pdo) {// cette fonction récupère les heures selon le filtre indiqué sur cette page

  $sql = "SELECT *
          FROM stock_hs INNER JOIN salaries ON salaries.Matricule = stock_hs.Matricule 
          WHERE salaries.Matricule = :Matricule 
          ORDER BY Date desc, ID_enr desc";
  $stmt = $pdo->prepare($sql);
  $params = ['Matricule' => $Matricule];
  $stmt->execute($params);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;

}




?>

<html>
    <body class="bodyperso">

        <div class = "containerperso">
                <form action="adminDetailheures.php" method="post">
                    
                    <div class="form-group">
                   
                      <label for="exampleinputtitre">Filtrer sur le salarié :</label>
                          <select class="form-control" name="salarie" value="0">
                            <option value=""></option>
                                    <?php
                                          for ($i = 0; $i < count($listesalaries); $i++){
                                        ?>
                                                <option value=<?=$listesalaries[$i]['Matricule']?>><?=$listesalaries[$i]['Nom']." ".$listesalaries[$i]['Prenom']?></option>

                                        <?php
                                        }
                                        ?>                  
                            </select>
     
                      </div>

                      <button type="submit" class="btn btn-primary">Filtrer</button>


                </form>
              
        </div>

<div class="container">       
  
<?php 
if (!empty($_POST['salarie'])){

  ?>
<h3><?="Détail des heures de ".$liste[0]['Prenom']." ".$liste[0]['Nom'];?></h3>
<h4>Classées de la plus récente à la plus ancienne</h4>
<p>Selectionnez tout le tableau avec les entêtes puis copier le (clic droit ou ctrl+c) pour le coller dans Excel si besoin.</p>

</div>


<div class="container">
<table class="table">
  <thead>
    <tr>
      
      <th scope="col">Date</th>
      <th scope="col">H. à récupérer (1pour1)</th>
      <th scope="col">H.supp. majorées</th>
      <th scope="col">Solidarité</th>
      <th scope="col">Heures à payées (non majorée)</th>
      <th scope="col">Justification</th>
      <th scope="col">validée le</th>
      <th scope="col"></th>

    </tr>
  </thead>
  <tbody>

<?php

  for($i=0;$i< count($liste);$i++){
    
 
?>
 
  <tr>

      
      <td>
        <?php
      
          $DateVue = date($liste[$i]['Date']);
          $DateReport = DateTime::createFromFormat('Y-m-d', $DateVue);
          echo $DateReport->format('d/m/Y');
         
      
        ?>
      
    
      </td>
      <td style="text-align:center;"><?=$liste[$i]['Recup']?></td>
      <td style="text-align:center;"><?=$liste[$i]['HS_Maj']?></td>
      <td style="text-align:center;"><?=$liste[$i]['JS']?></td>
      <td style="text-align:center;"><?=$liste[$i]['heureAPayer']?></td>
      <td><?=$liste[$i]['Commentaire']?></td>
      <td><?php

          $DateValide = date($liste[$i]['DateValidation']);
          $DateValide2 = DateTime::createFromFormat('Y-m-d', $DateValide);
          
      if ($DateValide == NULL){
      echo "Non validée";

      }else{
      echo $DateValide2->format('d/m/Y');
     
    }
      
      ?>
      
    
    </td>
    <td style="text-align:center;"><a href="modifieheurearchive.php?id=<?=$liste[$i]['ID_enr'];?>"><button>Modifier</button></a></td>

    </tr>
  
<?php 
}
?>

<?php
}else{ echo "Veuillez selectionner un salarié dans la liste déroulante";}// si aucun salarié n'est selectionné
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

