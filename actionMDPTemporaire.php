<?php
$titre = "Annulation par le responsable";
include ('includes/AllIncludes.php');

if(!isset($_SESSION['Matricule'])){
  header('Location: accueil.php');
}


if (count($_POST) > 0){

$Matricule = $_POST['matricule'];
$salarie = getUserConnect($Matricule,$pdo);
$identite = $salarie[0]['Prenom']." ".$salarie[0]['Nom'];    
$newpass = $_POST['newMdp'];
$crypted_password = password_hash($newpass, PASSWORD_BCRYPT );
$corrigeMdp = mdpTemporaire($Matricule,$crypted_password,$pdo);
echo "<div class='container'><h2 style='color:red;'>";
echo "Mot de passe corrigé";
echo "</h2></div>";
}else{

$Matricule = $_GET['matricule'];
$salarie = getUserConnect($Matricule,$pdo);
$identite = $salarie[0]['Prenom']." ".$salarie[0]['Nom'];

}


//la fonction ci-dessous affecte un mot de passe temporaire défini dans le formulaire
        function mdpTemporaire($Matricule,$crypted_password,$pdo){
            $sql = "UPDATE salaries
                    SET Password = :mdpTemporaire
                    WHERE Matricule = :matricule";
            $stmt = $pdo->prepare($sql);
            $params = ['matricule' => $Matricule, 'mdpTemporaire'=> $crypted_password];
            $stmt->execute($params);
            $result = $stmt->execute($params);
            return $result;
           
        }

?>

<body class="bodyperso">
    <div class="container">
        <br>
<h3>Attribuez un mot de passe temporaire à <?=$identite;?> :</h3>
    
    

<form action="actionMDPTemporaire.php" method="post">

<label for="newMdp">Mot de passe temporaire</label>
<input type="text" name="newMdp" id="newMdp" autocomplete="off">
<input type="hidden" name="matricule" value="<?=$Matricule;?>" readonly>
<button type="submit" class="btn btn-primary">VALIDER</button>


</form>
</div>



</body>

</html>