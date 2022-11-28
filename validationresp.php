<?php
$titre="Validation du responsable"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){ //vérifie si l'utilisateur est connecté
  header('location:index.php');
}

//$Matricule = $_SESSION['Matricule']; // Récupère le matricule de l'utilisateur connecté..../// Déjà fait dans navbar.php en include
$user = getUserConnect($Matricule,$pdo);//puis récupère les données le concernant
$droit = $user[0]['Type'];//Pour définir sont niveau de droit
$matriculeResponsable = $user[0]['Matricule'];

//Pour définir le salarié filtré
$listesalaries = getSalarieService($matriculeResponsable,$pdo);
if (isset($_POST['salarie'])){
  $Matr = $_POST['salarie'];
$valide = 2;
$listeHeures = GetAValiderV2($Matr,$pdo);
$listeHeuresSemaine = heuresEnCoursResponsable($Matr,$pdo);
$totalHeures = heuresEnCoursTotal($Matricule,$valide,$pdo);
}

?>

<body class="bodyperso">
<!--*********************************Liste déroulante pour filtrer sur le salarié ***********************************-->
<div class = "containerperso">
                <form action="validationresp.php" method="post">
                    
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

                      <button type="submit" class="bouttonValider">Filtrer</button>


                </form>
              
        </div>




<!-- Tableau présentant e détail retourné par getAValider dans la variable $listeHeures-->
<div style="margin:10px;">
<?php 
if (isset($listeHeures[0]['Prenom'])){
?>
<h1>Ventillation de la semaine à valider pour <?=$listeHeures[0]['Prenom']." ".$listeHeures[0]['Nom'];?></h1>
<table class="table">
  <thead>
    <tr>
      
      <th scope="col"></th>
      <th scope="col" colspan="2" style="border-left:solid;border-right:solid; border-width:1px; text-align:center;">Récupération<br><font style="font-size:0.8em;">Nouvelle / solde avant</font></th>
      <th scope="col" colspan="2" style="border-left:solid;border-right:solid; border-width:1px; text-align:center;">Heures supp.<br><font style="font-size:0.8em;">Nouvelle (majorée) / solde avant</font></th>
      <th scope="col" colspan="2" style="border-left:solid;border-right:solid; border-width:1px; text-align:center;">Solidarité / solde avant</th>
      <th scope="col" colspan="2" style="border-left:solid;border-right:solid; border-width:1px; text-align:center;">A payer / solde avant</th>
      <th scope="col"></th>
      <th scope="col"></th>

    </tr>
  </thead>
  <tbody>

<?php

  for($i=0;$i< count($listeHeures);$i++){
    
 
?>
 
  <tr>

      <td>Ventillation du solde :</td>
      <td style="text-align:center; border-left:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['Recup']);?></td>
      <td style="text-align:center; border-right:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['TotalRecup']);?></td>
      <td style="text-align:center; border-left:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['HS_Maj']);?></td>
      <td style="text-align:center; border-right:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['HeuresSupp']);?></td>
      <td style="text-align:center; border-left:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['JS']);?></td>
      <td style="text-align:center; border-right:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['JourneeSolidarite']);?></td>
      <td style="text-align:center; border-left:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['heureAPayer']);?></td>
      <td style="text-align:center; border-right:solid; border-width:1px;"><?=afficheHeureMinute($listeHeures[$i]['aPayer']);?></td>
      
      <td><a class="buttonnormal" href="actionOKHeure.php?id=<?=$listeHeures[$i]['ID_enr'];?>&matricule=<?=$listeHeures[$i]['Matricule'];?>">Valider</a></td>
      <td><a class="buttondanger" href="actionAnnulerHeure.php?id=<?=$listeHeures[$i]['ID_enr'];?> & nom=<?=$listeHeures[$i]['Nom'];?>">Annuler</a></td>
      


    </tr>
    
  
<?php 
}
?>

</tbody>
</table>

<!--Détail des heures de la semaine-->


<div class="containerperso">
<h2>Détail de la semaine:</h2>
            <table class="tableperso">
              <thead>
                <tr>

                  <th scope="col" class="thperso">id</th>
                  <th scope="col" class="thperso">Date</th>
                  <th scope="col" class="thperso">Durée</th>
                  <th scope="col" class="thperso">Commentaire</th>
                  

                  

                </tr>
              </thead>
              <tbody>

            <?php

              for($i=0;$i< count($listeHeuresSemaine);$i++){
               $d1=$listeHeuresSemaine[$i]['date_evenement'];
                $dateEvenement = strftime('%d-%m-%Y',strtotime($d1));
            ?>
            
              <tr>
                  <?php  ?>
                  <td class="tdperso"><?=$listeHeuresSemaine[$i]['id'];?></td>
                  <td class="tdperso"><?=$dateEvenement;?>
                  <td class="tdperso"><?=afficheHeureMinute($listeHeuresSemaine[$i]['temps']);?></td>
                  <td class="tdperso"><?=$listeHeuresSemaine[$i]['commentaire'];?></td>
                  
                

              </tr>
                
              
            <?php 
            }
            ?>

            </tbody>
            <tfoot>
              <th class="tdperso" colspan="2"> Total de la semaine :</th>
              
              <td class="tdperso"><span class="important"><?=afficheHeureMinute($totalHeures[0]['total']);?></span></td>
            </tfoot>
            </table>

  </div>

  <?php
}else{
  echo "Rien à afficher encore.";
}
?>


</body>

<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>

</html>

