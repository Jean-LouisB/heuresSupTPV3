<?php

$titre = "Détail par semaine";
include ('includes/AllIncludes.php');

if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}

if ((isset($_POST['salarie']))){
    $matricule = $_POST['salarie'];
    $liste = historiqueDetailSemaine($matricule,$pdo); 
} else {

}

$listesalaries = getSalarie($pdo); // permet de récupèrer la liste pour la liste déroulante.


?>

<html>
    <body class="bodyperso">

        <div class = "containerperso">
                <form action="adminDetailHeuresSem.php" method="post">
                    
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
<p>Validée : N.V.R. => Non validée par le Responsable | V.R. => Validée par le Responsable | N.V.S. = > non validée par le salarié</p>

</div>


<div class="container">
<table class="table">
  <thead>
    <tr>
      
      <th scope="col">Semaine</th>
      <th scope="col">Date</th>
      <th scope="col">Justification</th>
      <th scope="col">Durée</th>
      <th scope="col">validée</th>
      <th scope="col"></th>

    </tr>
  </thead>
  <tbody>

<?php

  for($i=0;$i< count($liste);$i++){
    
 
?>
 
  <tr>

      <td style="text-align:center;"><?=$liste[$i]['bornes'];?></td>
      <td>
        <?php
      
          $DateVue = date($liste[$i]['date_evenement']);
          $DateReport = DateTime::createFromFormat('Y-m-d', $DateVue);
          echo $DateReport->format('d/m/Y');
         
      
        ?>
      
    
      </td>
      <td style="text-align:left;"><?=$liste[$i]['commentaire']?></td>
      <td style="text-align:center;"><?=$liste[$i]['temps']?></td>
      <td>
          <?php
            if($liste[$i]['valide']==0){
              echo "N.V.S";
            }elseif ($liste[$i]['valide']==1) {
              echo "V.R";
            }elseif ($liste[$i]['valide']==2) {
              echo "N.V.R";
            }else {
              echo "Erreur code L117";
            }
          ?>
      </td>
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

