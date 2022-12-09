<?php
$titre = "Annulation par le responsable";
include ('includes/AllIncludes.php');

if(!isset($_SESSION['Matricule'])){
  header('Location: accueil.php');
}

$idligne = $_GET['id'];
$nom = $_GET['nom'];
$detailligne = getDemande($idligne,$pdo);
$actuelCommentaire = $detailligne[0]['Commentaire'];
$date1 = date('d', strtotime($detailligne[0]['Date']))."/".date('m', strtotime($detailligne[0]['Date']))."/".date('Y', strtotime($detailligne[0]['Date']));

if (isset($_POST['newJustif'])){
      $justification = $_POST['newJustif'];
      $newComment = $actuelCommentaire." | Responsable dit : ".$justification;
      $datev = date('Y/m/d');
      function justifAnnule($idligne,$newComment,$datev,$pdo){
                          $sql = "UPDATE stock_hs
                                  set 
                                  annulee = 1,
                                  Commentaire = :newComment,
                                  DateValidation = :datev
                                  Where ID_enr = :idligne";
                          $stmt = $pdo->prepare($sql);
                          $params = ['idligne' => $idligne, 'newComment' => $newComment, 'datev' => $datev];
                          $stmt->execute($params);
                          $result = $stmt->execute($params);
                          return $result;
                      }
      $okAnnule = justifAnnule($idligne,$newComment,$datev,$pdo);
      header('location: validationresp.php');
}
?>
<body class="bodyperso">
<div class = "containerperso">
<h3>Veuillez justifier l'annulation de : </h3>

        <form action="actionAnnulerHeure.php?id=<?=$idligne;?>" method="post">
            <div class="form-group">
              <label for="exampleinputtitre"><h4>Nom : <?=$nom;?> ; Date : <?=$date1;?> ; Commentaire : <?=$detailligne[0]['Commentaire'];?></h4></label>

              <input type="text" class="form-control" name="newJustif"/>
              <br>
              
              <button type="submit" class="btn btn-danger">Annuler la demande</button>
              
            </div>
        </form>
</div>
</body>




</html>



