    <?php

    //Fonction isvalid contrôle la cohérence matricule/mot de passe
      function isValid($Matricule,$Password,$pdo){

        $sql = "SELECT * from salaries where Matricule = :Matricule";
        $params =['Matricule' => $Matricule];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchall(PDO :: FETCH_ASSOC);
        
          if(count($result) > 0){
                        if(password_verify($Password,$result[0]['Password'])){
                            return true;
                          } else {
                            return false;
                          }
            } else {
              return false;
          }
      }

    // fonction getUserConnect récupère les informations de l'utilisateur connecté
      function getUserConnect($Matricule,$pdo){
        $sql = "SELECT * FROM salaries WHERE Matricule = :Matricule";
        $stmt = $pdo->prepare($sql);
        $params = ['Matricule' => $Matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
      }     


    // function getBornes récupère les dates minimum et maximum de saisie autorisée
      function getBornes($pdo){
        $sql = "SELECT * FROM bornes";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
        }  
            
        $tabDate = getBornes($pdo);
        $borne1 = date('d', strtotime($tabDate[0]['datedebut']))."/".date('m', strtotime($tabDate[0]['datedebut']))."/".date('Y', strtotime($tabDate[0]['datedebut']));;
        $borne2 = date('d', strtotime($tabDate[0]['datefin']))."/".date('m', strtotime($tabDate[0]['datefin']))."/".date('Y', strtotime($tabDate[0]['datefin']));;

        



    // la fonction getSoldeHeureUser calcul les totaux des compteurs d'heures validées de l'utilisateur connecté
      function getSoldeHeureUser($Matricule,$pdo){

        $sql = "SELECT SUM(Recup) as TotalRecup, SUM(HS_Maj) as HeuresSupp, Sum(JS) as JourneeSolidarite , H.aPayer as aPayer
                FROM stock_hs S LEFT JOIN heures_a_payer H ON S.Matricule = H.Matricule
                WHERE S.Matricule = :Matricule 
                AND Validation_Resp = 1";
        $stmt = $pdo->prepare($sql);
        $params = ['Matricule' => $Matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }

      

    // la fonction getDetailHeureUser récupère les heures non validées de l'utilisateur
      function getDetailHeureUser($Matricule,$pdo){

        $sql = "SELECT *
                FROM stock_hs 
                WHERE Matricule = :Matricule 
                AND Validation_Resp = 0
                AND annulee = 0
                ORDER BY Date DESC";
        $stmt = $pdo->prepare($sql);
        $params = ['Matricule' => $Matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }

    // la fonction getHeure récupère les infos d'une heure définie par $idheure
      function getHeure($idheure,$pdo){

        $sql = "SELECT *
                FROM semaineencours 
                WHERE id = :idheure";
        $stmt = $pdo->prepare($sql);
        $params = ['idheure' => $idheure];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }



    //Recupère la liste des salariés présents
    function getSalarie($pdo){
      $sql = "SELECT Matricule, Nom, Prenom
              FROM salaries
              WHERE Present = 1
              ORDER BY Nom";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
      }

    //Liste des salarié du service du responsable connecté
      function getSalarieService($matriculeResponsable,$pdo){
        $sql = "SELECT Matricule, Nom, Prenom
                FROM salaries
                WHERE Present = 1
                And Mat_Resp = :matriculeResponsable
                ORDER BY Nom";
        $stmt = $pdo->prepare($sql);
        $params = ['matriculeResponsable'=>$matriculeResponsable];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }  
    // La fonction getDemade récupère les données d'une demande précise selon son id pour annulation entre autre
      function getDemande($idligne,$pdo){
        $sql = "SELECT * FROM stock_hs 
                WHERE ID_enr = :idligne";
        $stmt = $pdo->prepare($sql);
        $params = ['idligne' => $idligne];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }

    //Fonction pour voir le nombre d'heures à payer
      function getDetailHeureApayerUser($Matricule,$pdo){
        $sql = "SELECT SUM(HS_Maj) as HeuresAPayer
        FROM stock_hs 
        WHERE Matricule = :Matricule 
        AND Validation_Resp = 1
        AND Payee = 0
        AND Apayer =1";
        $stmt = $pdo->prepare($sql);
        $params = ['Matricule' => $Matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
          }

    //La fonction getToutesHeures, récupère toutes les heures validées de l'utilisateur
    function getToutesHeures($Matricule,$pdo){
        $sql = "SELECT *
        FROM stock_hs 
        WHERE Matricule = :Matricule
        AND Validation_Resp = 1
        ORDER by Date desc";
        $stmt = $pdo->prepare($sql);
        $params = ['Matricule' => $Matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
          
      }

    //la fonction afficheHeureMinute permet d'afficher une décimale au format H:MM
    function afficheHeureMinute($heureDecimale){


      $heureArrondie = round($heureDecimale, 2);
      $heureExplode = explode('.',$heureArrondie);
      $H =$heureExplode[0];
      
      if (!isset($heureExplode[1])){
        $M = "";
      }else{
        $nbcarminute = strlen($heureExplode[1]);
                switch ($nbcarminute){
                      case 1:
                        $minute = $heureExplode[1];
                        $M =round(($minute*10)*(60/100));
                        break;

                      case 2:
                        $minute = (int)($heureExplode[1]);
                              if ($minute==0){
                                $M = "00";
                              }else{
                                      if ($minute<10){
                          
                                        $M ='0'.round(($minute)*(60/100));
                          
                                      }else{
                                      $M =round($minute*(60/100));
                                      }
                              }
                      break;
                  }

        }

          $hm = $H."h".$M;
          return $hm;
          
          
      }
    // La fonction apercuSemaine permet au directeur de consulter l'ensemble des événements sur une période donnée.
    function apercuSemaine($borne1,$borne2,$pdo){

          $sql ="SELECT * FROM stock_hs
                INNER JOIN salaries ON salaries.Matricule = stock_hs.Matricule
                WHERE stock_hs.Date >=:borne1
                AND stock_hs.Date <=:borne2
                AND Commentaire <> 'Initialisation'
                ORDER BY Nom";
          $stmt = $pdo->prepare($sql);
          $params = ['borne1'=> $borne1, 'borne2' => $borne2];
          $stmt->execute($params);
          $result=$stmt->fetchALL(PDO::FETCH_ASSOC);
          return $result;

      }

    //fonction toutTotaux permet de récupérer tous les totaux de chaque salarié présent
    function toutTotaux($pdo){
      $sql = "SELECT concat(Prenom,' ',Nom) as PrenomNom, SUM(stock_hs.Recup) as TotalRecup, SUM(stock_hs.HS_Maj) as HeuresSupp, Sum(stock_hs.JS) as JourneeSolidarite
                FROM stock_hs INNER JOIN salaries ON stock_hs.Matricule = salaries.Matricule
                Where Validation_Resp = 1
                AND Apayer =0
                AND salaries.Present = 1
                GROUP BY PrenomNom";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //function GetAValiderV2 récupère les heures à valider et les totaux
    function GetAValiderV2($Matricule,$pdo){
          $sql ="SELECT Nom,Prenom,Date,TotalRecup,HeuresSupp,JourneeSolidarite,T.aPayer,T.Matricule, Recup, HS_Maj, JS,Commentaire, ID_enr, Mat_Resp,ddepaye,S.heureAPayer
                  FROM totauxcompteurs T
                  INNER JOIN stock_hs S ON S.Matricule = T.Matricule
                  INNER JOIN salaries C on T.Matricule= C.Matricule
                  WHERE S.Validation_Resp = 0
                  And S.annulee = 0
                  And C.Matricule = :Matricule";
          $stmt = $pdo->prepare($sql);
          $params = ['Matricule' => $Matricule];
          $stmt->execute($params);
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $result;

      }

    //function GetAValiderV2 récupère les heures à valider et les totaux pour l'administrateur
    function GetAValiderV2Admin($Matricule,$pdo){
      $sql ="SELECT Nom,Date,TotalRecup,HeuresSupp,JourneeSolidarite,T.aPayer,T.Matricule, Recup, HS_Maj, JS,Commentaire, ID_enr, Mat_Resp,ddepaye,S.heureAPayer
              FROM totauxcompteurs T
              INNER JOIN stock_hs S ON S.Matricule = T.Matricule
              INNER JOIN salaries C on T.Matricule= C.Matricule
              WHERE S.Validation_Resp = 0
              And S.annulee = 0
              And C.Matricule = :Matricule";
      $stmt = $pdo->prepare($sql);
      $params = ['Matricule' => $Matricule];
      $stmt->execute($params);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;

      }
    //fonction RAZ, permet de mettre le solde à zéro si il est inférieur à + ou - 15mn 
    function razHS($Matricule,$date_Sys,$totalRaz,$pdo){

        $sql = "INSERT INTO stock_hs (Date, Matricule, JS, Recup, HS_Maj, Commentaire, Date_sys, APayer, Payee) 
        VALUES (:date_Sys, :Matricule, 0, 0, :totalRaz, 'RAZ', :Date_sys, 0 , 0)";
        $stmt = $pdo->prepare($sql);
        $params =['totalRaz' => $totalRaz, 'Matricule' => $Matricule, 'Date_sys' => $date_Sys];
        $result = $stmt->execute($params);
        return $result;


    }
    // récupère toutes les heures à payer :
    function getAPayer($pdo) {

        $sql = "SELECT *
                FROM stock_hs INNER JOIN salaries ON salaries.Matricule = stock_hs.Matricule 
                WHERE Validation_Resp = 1 
                AND Payee = 0
                AND heureAPayer > 0
                ORDER BY Nom, Date";
        $stmt = $pdo->prepare($sql);
      
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      
      
      }


    // Réinitialise la journée des petits vieux

    function petitsVieux($id,$dateRAZ,$dateSysteme,$pdo){

      $sql ="INSERT INTO stock_hs (Date, Matricule, JS, Recup, HS_Maj, Commentaire, Date_sys, APayer, Payee,Validation_Resp,DateValidation)
              values (:dateRAZ, :id, -7, 0, 0, 'RAZ Journée de solidarité', :dateSysteme, 0 , 0,1,:dateSysteme)";
      $params=['dateRAZ' => $dateRAZ, 'id' => $id, 'dateSysteme' => $dateSysteme];
      $stmt= $pdo->prepare($sql);
      $result = $stmt->execute($params);
      header('location:adminApercu.php');


    }

    /********************************************************* Fonctions pour la version 3  ****************************************************/

    //AddHeureV3 ajoute les heure de la semaine dans la table intermédiaire:
    function addHeureV3($bornes,$matricule,$dateEvenement,$dureeEvenement,$commentaire,$pdo){
    
      $sql ="INSERT INTO semaineencours (bornes, matricules,temps,commentaire,date_evenement,valide)
      values (:bornes,:matricule,:dureeEvenement,:commentaire,:dateEvenement,0)";
      $params=['bornes'=>$bornes, 'matricule'=>$matricule,'dureeEvenement'=>$dureeEvenement,'commentaire'=>$commentaire,'dateEvenement'=>$dateEvenement];
      $stmt= $pdo->prepare($sql);
      $result = $stmt->execute($params);


    }
    //La fonction heure en cours affiche le total des heures non validées
    function heuresEnCours($matricule,$pdo){
      $sql = "SELECT *
                FROM semaineencours 
                WHERE valide = 0 
                AND matricules = :matricule
                ORDER BY date_evenement";
        $stmt = $pdo->prepare($sql);
        $params=['matricule'=>$matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
//Affiche les heures du salarié dont la validation est en attentepar le responsable (valide =2)
    function heuresEnCoursResponsable($matricule,$pdo){
      $sql = "SELECT *
                FROM semaineencours 
                WHERE valide = 2 
                AND matricules = :matricule
                ORDER BY date_evenement";
        $stmt = $pdo->prepare($sql);
        $params=['matricule'=>$matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
//Calcule le total des heures en cours en fonction de la variable $valide (0 = non ventillé par le salarié; 2 = ventillé ok)
    function heuresEnCoursTotal($matricule,$valide,$pdo){
      $sql = "SELECT SUM(temps) as total
                FROM semaineencours 
                WHERE valide = :valide 
                AND matricules = :matricule";
        $stmt = $pdo->prepare($sql);
        $params=['matricule'=>$matricule,'valide'=>$valide];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
//Toutes les heures en cours de la semaine (valide = 0) de tout le monde
    function heuresEnCoursTous($matricule,$pdo){
      $sql = "SELECT *
                FROM semaineencours C 
                INNER join salaries S
                ON S.Matricule = C.matricules
                WHERE c.valide = 0 
                AND S.Matricule = :matricule
                ORDER BY S.Nom";
        $stmt = $pdo->prepare($sql);
        $params=['matricule'=> $matricule];
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }




    ?>
