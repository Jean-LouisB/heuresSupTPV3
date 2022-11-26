<?php
$titre="Aperçu de la semaine"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){
    header('location:index.php');
}
//récupère les dates et les mets en forme française (jours/mois/année)

$DateDebut = $tabDate[0]['datedebut'];
$DateFin = $tabDate[0]['datefin'];
$apercuTotal = apercuSemaine($DateDebut,$DateFin,$pdo);
$touToto = toutTotaux($pdo);

?>

<body class="bodyperso">
  <div class="containerperso">
     <H2 style="text-align:center;">Aperçu détaillé de la semaine <br>du <?=$borne1;?> au <?=$borne2;?></H2>
  </div>

  <div style="margin:10px;">
      <table class="table">
        <thead>
          <tr>
            
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Date</th>
            <th scope="col" colspan="2" style="border-left:solid;border-right:solid; border-width:1px; text-align:center;">Récupération<br><font style="font-size:0.8em;">Nouvelle / solde initial</font></th>
            <th scope="col" colspan="2" style="border-left:solid;border-right:solid; border-width:1px; text-align:center;">Heures supp.<br><font style="font-size:0.8em;">Nouvelle / solde initial</font></th>
            <th scope="col">Solidatrité</th>
            <th scope="col">A payer?</th>
            <th scope="col">Justificatif</th>

          </tr>
        </thead>
        <tbody>

      <?php

        for($i=0;$i< count($apercuTotal);$i++){
          
      
      ?>
      
        <tr>

            <td><?=$apercuTotal[$i]['Nom'];?></td>
            <td><?=$apercuTotal[$i]['Prenom'];?></td>
            <td>
              <?php
            
                $DateMvt = date($apercuTotal[$i]['Date']);
                $DateReport = DateTime::createFromFormat('Y-m-d', $DateMvt);
                echo $DateReport->format('d/m/Y');
              
            
              ?>
                      
            </td>
            <td style="text-align:center; border-left:solid; border-width:1px;"><?=afficheHeureMinute($apercuTotal[$i]['Recup']);?></td>
            <td style="text-align:center; border-right:solid; border-width:1px;">Solde à calculer</td>
            <td style="text-align:center; border-left:solid; border-width:1px;"><?=afficheHeureMinute($apercuTotal[$i]['HS_Maj']);?></td>
            <td style="text-align:center; border-right:solid; border-width:1px;">Solde à calculer</td>
            <td class="tdperso"><?=afficheHeureMinute($apercuTotal[$i]['JS']);?></td>
            <td><?=$apercuTotal[$i]['ddepaye'];?></td>
            <td><?=$apercuTotal[$i]['Commentaire'];?></td>

          

            
          </tr>
        
      <?php 
      }
      ?>

      </tbody>
      </table>
  </div>
  <br>
  <hr>
  <br>

  <div class="containerperso">
     <H2 style="text-align:center;">Totaux des compteurs par personne</H2>
  </div>

  <div class="containerperso">
          <table class="table">

                  <thead>
                      <th scope="col">Nom</th>
                      <th scope="col">Compteur Récupération</th>
                      <th scope="col">Compteur Heures supp.</th>
                      <th scope="col">Solidarité.</th>

                  </thead>
          
                  <tbody>
                      <tr>

                          <?php

                          for($i=0;$i< count($touToto);$i++){
                              
                          ?>
                                  <td><?=$touToto[$i]['PrenomNom'];?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['TotalRecup']);?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['HeuresSupp']);?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['JourneeSolidarite']);?></td>

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