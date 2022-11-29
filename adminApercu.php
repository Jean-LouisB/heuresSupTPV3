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
     <H2>Aperçu détaillé de la semaine du <?=$borne1;?> au <?=$borne2;?></H2>
  </div>

  <div class="containerperso">
  <p>En cours = L'heure n'a pas encore été ventilée par le salarié.<br>Validée = L'heure est validée par le responsable.<br>En attente = l'heure est ventillée et en attente de validation par le responsable</p>

      <table class="table">
        <thead>
          <tr>
            
            <th scope="col" class="thperso" style="width:20%;">Nom Prénom</th>
            <th scope="col" class="thperso" style="width:15%;">Date</th>
            <th scope="col" class="thperso" style="width:15%;">Durée</th>
            <th scope="col" class="thperso" style="width:40%;">Justificatif</th>
            <th scope="col" class="thperso" style="width:10%;">Etat</th>

          </tr>
        </thead>
        <tbody>

      <?php

        for($i=0;$i< count($apercuTotal);$i++){
          
      
      ?>
      
        <tr>

            <td class="tdperso"><?=$apercuTotal[$i]['Nom']." ".$apercuTotal[$i]['Prenom'];?></td>
            <td class="tdperso">
              <?php
            
                $DateMvt = date($apercuTotal[$i]['date_evenement']);
                $DateReport = DateTime::createFromFormat('Y-m-d', $DateMvt);
                echo $DateReport->format('d/m/Y');
              
            
              ?>
                      
            </td>
            <td class="tdperso"><?=afficheHeureMinute($apercuTotal[$i]['temps']);?></td>
            <td class="tdperso"><?=$apercuTotal[$i]['commentaire'];?></td>
            <td class="tdperso"><?php
              switch ($apercuTotal[$i]['valide']) {
                case '0':
                  echo "En cours";
                  break;
                case '1':
                  echo "Validée";
                  break;
                case '2':
                  echo "En attente";
                  break;
                    
                default:
                  echo "NA";

                  break;
              }

            ;?></td>

          

            
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
     <H2>Soldes initiaux des compteurs par personne.</H2>
     <p>Ce tableau ne tient pas compte des mouvements du tableau précédent.</p>
  </div>

  <div class="containerperso" style="width:50%;">
          <table class="tableperso">

                  <thead>
                      <th class="thperso" style="width:40%" scope="col">Nom</th>
                      <th class="thperso" style="width:15%" scope="col">Compteur Récupération</th>
                      <th class="thperso" style="width:15%" scope="col">Compteur Heures supp.</th>
                      <th class="thperso" style="width:15%" scope="col">Solidarité.</th>
                      <th class="thperso" style="width:15%" scope="col">A payer.</th>

                  </thead>
          
                  <tbody>
                      <tr>

                          <?php

                          for($i=0;$i< count($touToto);$i++){
                              
                          ?>
                                  <td class="tdperso"><?=$touToto[$i]['PrenomNom'];?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['TotalRecup']);?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['HeuresSupp']);?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['JourneeSolidarite']);?></td>
                                  <td class="tdperso"><?=afficheHeureMinute($touToto[$i]['heureapayer']);?></td>

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