<?php
$titre="Accueil"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires

?>

<body class="bodyperso"> <!--la classe body perso est décrite dans le fichier "styleperso.css". Elle permet de positionner le body en dessous de la navbar qui est fixe-->
    <div class="containerperso">
            <H1>Bonjour <?= $prenomUserConnecte;?>,</h1>
            
    </div>
    <?php
    $soldeHeureUser= getSoldeHeureUser($Matricule,$pdo); //Affecte le tableau des totaux de l'utilisateur à la variable soldeHeureUser
    $detailHeureUser= getDetailHeureUser($Matricule,$pdo);
    $detailHeureUserAPayer = getDetailHeureApayerUser($Matricule,$pdo);
    $toutLeDetail = getToutesHeures($Matricule,$pdo);


    //pour l'affichage des soldes en h:mm
    $heureDecimale= $soldeHeureUser[0]['HeuresSupp']; 
    $HS = afficheHeureMinute($heureDecimale);
    $heureDecimale= $soldeHeureUser[0]['TotalRecup'];
    $HR = afficheHeureMinute($heureDecimale);
    $heureDecimale= $soldeHeureUser[0]['JourneeSolidarite'];
    $JS = afficheHeureMinute($heureDecimale);
    $heureDecimale= $detailHeureUserAPayer[0]['HeuresAPayer'];
    $HP = afficheHeureMinute($heureDecimale);


    ?>
<body class="bodyperso">
    
    <div class="containerpersoaligne">
    <h3 class="important">
        <?php

//Total des heures en vours :
$valide=0;
            $totalEnCour = heuresEnCoursTotal($Matricule,$valide,$pdo);
            $totalEnCour2 = afficheHeureMinute($totalEnCour[0]['total']);
            echo "Votre temps en attente d'affectation est de : ".$totalEnCour2;
           
//détail des heures en cours :
            $encours= heuresEnCours($Matricule,$pdo);
       ?>
    </h3>

    </div>

<div class="containerperso disparait" id="tableauDetail">    
    <h3>Détail des heures non clôturées :</h3>
    <table class="tableperso">

        <thead>
                                <tr class="trperso">
                                    <th scop="col" class="thperso">Date</th>
                                    <th scop="col" class="thperso">durée</th>
                                    <th scop="col" class="thperso">Commentaires</th>
                                    
                                </tr>
        </thead>
        <tbody>

<?php

                    for ($i = 0; $i < count($encours); $i++){
                            /* Ecrit la date en Français jj/mm/aaaa : */
                                $dateFrance = explode('-',$encours[$i]['date_evenement']);
                                $jour = $dateFrance['2'];
                                $mois = $dateFrance['1'];
                                $annee = $dateFrance['0'];
                            /*-----------------------------------------*/
                        ?>
                                <tr>
                                    <td class="tdperso"><?=$jour."/".$mois."/".$annee;?></td>
                                    <td class="tdperso"><?=afficheHeureMinute($encours[$i]['temps']);?></td>
                                    <td class="tdperso"><?=$encours[$i]['commentaire'];?></td>
                                    
                                </tr>
                    <?php
                    }
                    ?>
        </tbody>


    </table>
</div>
<hr>
<div class="containerpersocourt disparait" id="tableauSoldes">
            <h3>Soldes de vos compteurs :</h3>
            <p><span style="font-style:italic;">Ne tient pas compte des heures non clôturées.</span></p>

           <table class="tableperso">
                  <thead>
                        <tr>
                            <th class="thperso">Titre</th>
                            <th class="thperso">Solde</th>
                        </tr>
                  </thead>
                  <tbody>
                          <tr>
                            <td class="tdperso tdepais">Journée de solidarité :</td>
                            <td class="tdperso tdepais"><?=$JS;?></td>
                          </tr>
                          <tr>
                            <td class="tdperso tdepais">Compteur de récupération (1 pour 1) :</td>
                            <td class="tdperso tdepais"><?=$HR;?></td>
                          </tr>
                          <tr>
                            <td class="tdperso tdepais">Compteur d'heures supplémentaires :</td>
                            <td class="tdperso tdepais"><?=$HS;?></td>
                          </tr>
                          <tr>
                            <td class="tdperso tdepais">A payer</td>
                            <td class="tdperso tdepais"><?=$HP;?></td>
                          </tr>
  
                  </tbody>

          </table>
          <div class="containerPersoCentrer">






<script>

        var tempo = setTimeout(addClass, 600);

                                            
        function addClass(){
            let element = (document.getElementById("tableauDetail"));
            let element2= (document.getElementById("tableauSoldes"));
            element.classList.add("apparait");
            element2.classList.add("apparait");
       
        }

</script>

</body>

<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>
</html>

