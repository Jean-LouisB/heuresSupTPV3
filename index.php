<?php
$titre="Connection"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
?>


<body class="bodyperso">

<?php
if (count($_POST) > 0) {
  
        if (isValid($_POST['Matricule'],$_POST['password'], $pdo)) {
              $_SESSION['Matricule'] = $_POST['Matricule'];
              header('Location: accueil.php');
            
        } else {
?>
        
        <div class="containerpersoaligne" >

        <H1>Connection échouée, recommencez.</H1>
        </div>
        <div class="containerpersoaligne" >
        <a class="btn btn-secondary" href="index.php">CONNECTION</a>
        </div>
        <?php
    }
} else { 

    

?>

  
      

    <div class="containerperso">
    <h1>Connexion</h1>

      <form action="index.php" method="post">
        <div class="form-group">
          <label>Matricule</label>
          <input class="form-control" name="Matricule" id="Mat" maxlength = 4>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input required type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
      </form>
    </div>

  </body>
    

<?php
}
?>
</html>


