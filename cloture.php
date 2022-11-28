<?php
$titre="Cloturer la semaine"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){ //vérifie si l'utilisateur est connecté
  header('location:index.php');
}
$matricule = $Matricule;
//$Matricule = $_SESSION['Matricule']; // Récupère le matricule de l'utilisateur connecté..../// Déjà fait dans navbar.php en include
$user = getUserConnect($Matricule,$pdo);//puis récupère les données le concernant


if (isset($_POST['affecHS'])){
    $DateDebut = $borne1;
    $DateFin = $borne2;
    $bornes = $borne1." au ".$borne2;
    $affecJS=$_POST['affecJS'];
    $affecHR=$_POST['affecHR'];
    $affecHS=$_POST['affecHS']*1.25;
    $aPayer=$_POST['aPayer'];
    $commentaire='Arbitrage de la semaine du '.$bornes;

function addHeureSemaine($Matricule,$affecJS,$affecHR,$affecHS,$aPayer,$date_Sys,$commentaire,$pdo){

        $sql = "INSERT INTO stock_hs (Matricule,Date,Recup,HS_Maj,JS,Date_sys,Commentaire,Validation_Resp,APayer,Payee,heureAPayer) 
                              VALUES (:Matricule,:date_Sys,:affecHR,:affecHS,:affecJS,:date_Sys,:commentaire,0,0,0,:aPayer)";
        $stmt = $pdo->prepare($sql);
        $params = ['Matricule' => $Matricule,'affecJS' => $affecJS,'date_Sys' => $date_Sys, 'affecHR' => $affecHR,'affecHS' => $affecHS,'commentaire' => $commentaire,'aPayer' => $aPayer];
        $result = $stmt->execute($params);

        }

$validerHeure = addHeureSemaine($Matricule,$affecJS,$affecHR,$affecHS,$aPayer,$date_Sys,$commentaire,$pdo);


function archiveHeureSemaine($Matricule,$pdo){

                        $sql = "UPDATE semaineencours
                        SET valide = 2
                        WHERE matricules = :matricule
                        And valide = 0";
                        $stmt = $pdo->prepare($sql);
                        $params = ['matricule' => $Matricule];
                        $stmt->execute($params);
                        $result = $stmt->execute($params);
                        return $result;


}
$archiveHeure = archiveHeureSemaine($Matricule,$pdo);

}

  $valide = 0;
  $listeHeures = heuresEnCoursTous($matricule,$pdo);
  $totalHeures = heuresEnCoursTotal($matricule,$valide,$pdo);
  $soldesInitiaux = getSoldeHeureUser($matricule,$pdo);


?>

<body class="bodyperso" onload="reCalcul()">

<!-- Tableau présentant e détail retourné par getAValider dans la variable $listeHeures-->
  <div class="containerperso">
    <h3>Détail des heures de la semaine.</h3>
    <h4><?=$user[0]['Prenom']." ".$user[0]['Nom'];?>:</h4>
            <table class="tableperso">
              <thead>
                <tr>

                  <th scope="col" class="thperso">id</th>
                  <th scope="col" class="thperso">Date</th>
                  <th scope="col" class="thperso">Durée</th>
                  <th scope="col" class="thperso">Commentaire</th>
                  <th scope="col" class="thperso"><span style="font-size:0.5em;">Modifier</span></th>
                  <th scope="col" class="thperso"><span style="font-size:0.5em;">Supprimer</span></th>
                  

                  

                </tr>
              </thead>
              <tbody>

            <?php

              for($i=0;$i< count($listeHeures);$i++){
               $d1=$listeHeures[$i]['date_evenement'];
                $dateEvenement = strftime('%d-%m-%Y',strtotime($d1));
            ?>
            
              <tr>

                  <td class="tdperso"><?=$listeHeures[$i]['id'];?></td>
                  <td class="tdperso"><?=$dateEvenement;?>
                  <td class="tdperso"><?=afficheHeureMinute($listeHeures[$i]['temps']);?></td>
                  <td class="tdperso"><?=$listeHeures[$i]['commentaire'];?></td>
                  <td class="tdperso"><a href="modifieheure.php?id=<?=$listeHeures[$i]['id'];?>"><button class="buttonnormal">M</button></a></td>
                  <td class="tdperso"><a href="supprime.php?id=<?=$listeHeures[$i]['id'];?>"><button class="buttondanger">X</button></a></td>
                  
                

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

  <div class="containerperso">
            <h3>Soldes en début de semaine et affectation</h3>
<p>Répartissez le solde en l'écrivant en décimal (15mn = 0.25; 30mn = 0.5; 45mn = 0.75) </p>
    <input class="disparait" id="totalEncours" value="<?=$totalHeures[0]['total'];?>">

    <form action="cloture.php" method="post">
          <table class="tableperso">
                  <thead>
                          <tr>
                            <th class="thperso">Titre</th>
                            <th class="thperso">Solde initial</th>
                            <th class="thperso">Affectation</th>
                          

                          </tr>
                  </thead>
                  <tbody>
                          <tr id="alertJS">
                            <td class="tdperso tdepais"> <span id="titreJS">Journée de solidarité :</span></td>
                            <td class="tdperso tdepais"><?=afficheHeureMinute($soldesInitiaux[0]['JourneeSolidarite']);?></td>
                            <td class="tdperso tdepais"><input type="decimal" class="inputDivers centrer" name="affecJS" id="affecJS" value=0 onblur="reCalcul()"></td>
                          </tr>
                          <tr>
                            <td class="tdperso tdepais">Compteur de récupération (1 pour 1) :</td>
                            <td class="tdperso tdepais"><?=afficheHeureMinute($soldesInitiaux[0]['TotalRecup']);?></td>
                            <td class="tdperso tdepais"><input type="decimal" class="inputDivers centrer" name="affecHR" id="affecHR" value=0 onblur="reCalcul()"></td>
                          </tr>
                          <tr>
                            <td class="tdperso tdepais">Compteur d'heures supplémentaires :</td>
                            <td class="tdperso tdepais"><?=afficheHeureMinute($soldesInitiaux[0]['HeuresSupp']);?></td>
                            <td class="tdperso tdepais"><input type="decimal" class="inputDivers centrer" name="affecHS" id="affecHS" value=0 onblur="reCalcul()"></td>
                          </tr>
                          <tr>
                            <td class="tdperso tdepais">A payer</td>
                            <td class="tdperso tdepais"><?=afficheHeureMinute($soldesInitiaux[0]['aPayer']);?></td>
                            <td class="tdperso tdepais"><input type="decimal" class="inputDivers centrer" name="aPayer" id="aPayer" value=0 onblur="reCalcul()"></td>
                          </tr>
                          <tfoot>
                            <tr>
                            <th class="tdperso tdepais" colspan="2"> Reste à répartir:</th>
                            <th class="tdperso tdepais"> <input class="inputDivers centrer" id="resteTotal"></th>

                            </tr>
                          </tfoot>

                  </tbody>

          </table>
          <div class="containerPersoCentrer">
              <button type="submit" class="buttonnormal masqueObjet" id="bouttonValide">Valider la ventillation</button>
          </div>
  </div>
  <div class="containerpersoaligne">
    <H3>Calculette mn => décimale</H3>
          <p>Entrez votre temps en minutes dans le premier cadre ci-dessous,<br> puis appuyez sur la touche "TABULATION" pour obtenir l'équivalent en nombre décimal dans le second :</p>
          <input type="double" name="nbminutes" id="nbminutes" onblur="calculette()" class="inputDivers" style="text-align:center;"><p> = </p>
          <input type="double" id="minuteDecimale" class="inputDivers" style="text-align:center;">
  </div>
  <script>

        function calculette(){
          var minute = document.getElementById('nbminutes').value;
          var enDecimale = minute/60;
          var endecimaleArrondie = enDecimale.toFixed(2);
          document.getElementById('minuteDecimale').value = endecimaleArrondie;
        }

        function reCalcul(){

          var ligne1 = document.getElementById('affecJS').value;
          var ligne2 = document.getElementById('affecHR').value;
          var ligne3 = document.getElementById('affecHS').value;
          var ligne4 = document.getElementById('aPayer').value;
          var totalinitial = document.getElementById('totalEncours').value;
          var reste = totalinitial-ligne1 - ligne2 - ligne3 - ligne4;


          document.getElementById('resteTotal').value = reste;

          var resteRepartir = document.getElementById('resteTotal').value;
          console.log(resteRepartir);
          
          if (resteRepartir == 0){
                  let element = (document.getElementById("bouttonValide"));
                  element.classList.add("afficheObjet");
           }else{
                let element = (document.getElementById("bouttonValide"));
                element.classList.remove("afficheObjet");
           }


        }
    var dateDuJour = new Date();
    var mois = dateDuJour.getMonth()+1;
    var soldeJS = <?=$soldesInitiaux[0]['JourneeSolidarite'];?>;


    if (mois >= 11 && soldeJS < 0){
      let caseJS = (document.getElementById("alertJS"));
      document.getElementById("titreJS").innerHTML = "PENSEZ A REALISER LES HEURES DE SOLIDARITE : ";
      caseJS.classList.add("miseEnLumiere");
    }
  </script>
</body>

<footer>
  <div class="containerPersoCentrer">
<p>Si vous n'avez pas d'heures à déclarer, valider votre la ventillation pour indiquer le "R.A.S.".</p>

  </div>
</footer>

</html>