<?php
$titre ="Modifier un salarié";
include ('includes/AllIncludes.php');
if (!isset($_SESSION['Matricule'])){
    header('location:index.php');
}

if (isset($_GET['mat'])){
    $matricule = $_GET['mat'];
} else {

    $matricule = $_POST['matricule'];
}



$user = getUserConnect($matricule,$pdo);

if (isset($_POST['matricule'])){
    
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $matresp = $_POST['matresp'];
    $droit = $_POST['droit'];
    $presence = $_POST['presence'];

    

            function modifUser($matricule, $prenom, $nom, $matresp, $droit, $presence, $pdo){

                $sql = "UPDATE salaries
                        SET Prenom = :prenom, Nom = :nom, Mat_resp = :matresp, Type = :droit, Present = :presence
                        WHERE Matricule = :matricule";
                        $stmt = $pdo->prepare($sql);
                        $params = ['prenom' => $prenom, 'nom' => $nom, 'matresp' => $matresp, 'droit' => $droit, 'presence' => $presence, 'matricule' => $matricule ];
                        $stmt->execute($params);
                        $result = $stmt->execute($params);
                        return $result;


            }
            $modification = modifUser($matricule, $prenom, $nom, $matresp, $droit, $presence, $pdo);
            header('location:userList.php');
   
        }




?>
<body class="bodyperso">
<div class="container">
  <h1>Modification du salarié</h1>

                <form action="userEdit.php" method="post">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Matricule (non modifiable)</label>
                            <input required type="text" class="form-control" name="matricule" id="exampleInputEmail1" value="<?=$user[0]['Matricule']?>" readonly>
                            </div>
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Prénom</label>
                            <input required type="text" name="prenom" class="form-control" id="exampleInputPassword1" value="<?=$user[0]['Prenom']?>">
                            </div>
                            
                            <div class="form-group">
                            <label for="nom">Nom</label>
                            <input required name="nom" class="form-control" id="nom" value="<?=$user[0]['Nom']?>">
                            </div>
                            
                            <div class="form-group">
                            <label for="matresp">Matricule du responsable</label>
                            <input required name="matresp" class="form-control" id="matresp" value="<?=$user[0]['Mat_Resp']?>">
                            </div>

                            <div class="form-group">
                            <label for="droit">Droits (1 = Salarié | 2 = Responsable | 3 = administrateur)</label>
                            <input required name="droit" class="form-control" id="droit" value="<?=$user[0]['Type']?>">
                            </div>

                            <div class="form-group">
                            <label for="presence">Présent dans l'effectif (0 = Absent | 1 = Présent)</label>
                            <input required name="presence" class="form-control" id="presence" value="<?=$user[0]['Present']?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            <a class="btn btn-danger" href="actionMDPTemporaire.php?matricule=<?=$matricule;?>">Ré-initialise le mot de passe</a>

                </form>
</div>

</body>

<footer>
    <?php
    include('includes/footer.php')
    ?>
</footer>

</html>

