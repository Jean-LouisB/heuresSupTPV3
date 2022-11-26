<?php

$titre = "Dates ouvertes";

include ('includes/AllIncludes.php');
if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}


if (count($_POST)==0){
  
}else{

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];



function changeDate($date1,$date2,$pdo){

  $sql = "UPDATE bornes set datedebut = :date1, datefin = :date2";
  $stmt = $pdo->prepare($sql);
  $params = ['date1' => $date1, 'date2' => $date2];
  $stmt->execute($params);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  return $result;

}   

$majdate = changeDate($date1,$date2,$pdo);
header('location:accueil.php');
}//ferme le else


?>

<html>
<body class="bodyperso">

<div class = "containerperso">

<h1>Dates actuelles :</h1>
<h2>du : <?=$borne1;?> au <?=$borne2;?></h2>
<br>
        <form action="adminDefiniBornes.php" method="post">
            
            <div class="form-group">
              <label for="exampleinputtitre">Nouvelle date de début (inclus):</label>
              <input type="date" class="form-control" name="date1"/>
            </div> 
            <div class="form-group">
              <label for="exampleinputtitre">Nouvelle date de fin (inclus):</label>
              <input type="date" class="form-control" name="date2"/>
            </div> 


            <button type="submit" class="btn btn-primary">Ajouter</button>

        </form>

</div>

</body>
<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>
</html>


