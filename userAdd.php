<?php

$titre = "Créer un utilisateurs";

include ('includes/AllIncludes.php');
if (!isset($_SESSION['Matricule'])){
  header('location:index.php');
}

  if(isset($_POST['password']) ){
        $crypted_password = password_hash($_POST['password'], PASSWORD_BCRYPT );
        $matricule = $_POST['matricule'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $droit = $_POST['droit'];
        $initJS = $_POST['soldeInitialJS'];
        $matResp = $_POST['mat_resp'];

        $res = addUser($matricule,$nom,$crypted_password,$prenom,$droit,$matResp,$pdo);
        $initialisejs = initJS($matricule,$initJS,$date_Sys,$pdo);

        if($res) { header('Location:userAdd.php');}
        else {echo "Erreur d'enregistrement, utilisateur déjà enregistré";}
}

function addUser($matricule,$nom,$crypted_password,$prenom,$droit,$matResp,$pdo){

    $sql = "INSERT INTO salaries (Matricule,Nom,Prenom,Password,Type,Mat_Resp,Present) VALUES (:matricule,:nom, :prenom, :password, :type, :matResp,1)";
    $stmt = $pdo->prepare($sql);
    $params = ['matricule' => $matricule,'nom' => $nom,'password' => $crypted_password, 'prenom' => $prenom,'type' => $droit,'matResp' => $matResp];
    $result = $stmt->execute($params);
    
    return $result;


  }


 function initJS($matricule, $initJS, $date_Sys,$pdo){

  $sql ="INSERT INTO stock_hs (Matricule, Date, Recup, HS_Maj, JS, Date_sys, Commentaire, Validation_Resp, DateValidation,APayer,Payee)
         VALUES (:matricule, :datesys, '0', '0', :initJS, :datesys, 'Création', '1', :datesys, '0', '0')";
  $stmt = $pdo->prepare($sql);
  $params = ['matricule' => $matricule, 'initJS' => $initJS, 'datesys' => $date_Sys];
  $result = $stmt->execute($params);
  return $result;


 } 

?>

<body class="bodyperso">
  
<div class="containerperso">
  <h1>Création d'un utilisateur</h1>

                <form action="userAdd.php" method="post">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Matricule</label>
                            <input required type="text" class="form-control" name="matricule" id="exampleInputEmail1">
                            </div>
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe</label>
                            <input required type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            
                            <div class="form-group">
                            <label for="exampleInputprenom">Nom</label>
                            <input required name="nom" class="form-control" id="exampleInputprenom">
                            </div>
                            
                            <div class="form-group">
                            <label for="exampleInputprenom">Prénom</label>
                            <input required name="prenom" class="form-control" id="exampleInputprenom">
                            </div>

                            <div class="form-group">
                            <label for="exampleInputprenom">Droits (1 = Salarié | 2 = Responsable | 3 = administrateur)</label>
                            <input required name="droit" class="form-control" id="exampleInputprenom">
                            </div>

                            <div class="form-group">
                            <label for="exampleInputprenom">Matricule responsable</label>
                            <input required name="mat_resp" class="form-control" id="exampleInputprenom">
                            </div>

                            <div class="form-group">
                            <label for="exampleInputprenom">Solde solidarité</label>
                            <input required name="soldeInitialJS" class="form-control" id="exampleInputprenom" value="-7">
                            </div>

                            <button type="submit" class="btn btn-primary">Créer un utilisateur</button>
                </form>
</div>

</body>
</html>


