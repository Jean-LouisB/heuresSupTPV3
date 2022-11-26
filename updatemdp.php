<?php
//pour que le salarié puisse personnaliser son mot de passe
$titre="Changer le mot de passe"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}

if (isset($_POST['newpass'])){
    $matricule = $_SESSION['Matricule'];
    $newpass = $_POST['newpass'];
    $crypted_password = password_hash($newpass, PASSWORD_BCRYPT );
    $update = UpdateMdp($matricule,$crypted_password,$pdo);
    header('location:okmdp.php');
    

}


function UpdateMdp($matricule,$crypted_password,$pdo){
            $sql = "UPDATE salaries 
                    SET Password = :cryptepass
                    WHERE Matricule = :matricule";
            $stmt = $pdo->prepare($sql);
            $params = ['cryptepass' => $crypted_password, 'matricule' => $matricule];
            $stmt->execute($params);
            $result = $stmt->execute($params);
            return $result;
            
}


?>

<body class="bodyperso">

<div class = "containerperso">

        <form action="updatemdp.php" method="post">
            
            <div class="form-group">
              <label for="exampleinputtitre"><h3>Nouveau mot de passe :</h3></label>
              <input type="text" class="form-control" name="newpass"/>
            </div> 
            <div class="form-group">
            <button type="submit" class="btn btn-primary">Modifier</button>
        
        </form>


</div>
       

</body>
</html>
