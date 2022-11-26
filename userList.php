<?php
$titre = "gestion des utilisateurs";

include ('includes/AllIncludes.php');
if (!isset($_SESSION['Matricule'])){
        header('location:index.php');
}

if (isset($_POST['presence'])){
        $presence = $_POST['presence'];
                switch ($presence){

                        case 1 :
                $presence = 1;
                $selection = "présents";
                $listeUser = getListeUserFiltre($presence,$pdo);
                        break;
                        case 2 :
                $presence = 0;
                $selection = "absents";
                $listeUser = getListeUserFiltre($presence,$pdo);
                        break;
                        case 3 :
                $selection = "présents et absents";
                $listeUser = getListeUser($pdo);
                         default :
                $selection = "présents et absents";
                $listeUser = getListeUser($pdo);
                        break;

                }



}else{       
        $listeUser = getListeUser($pdo);
        $selection = "présents et absents";
       
}

function getListeUserFiltre($presence,$pdo){

        $sql = "SELECT * From salaries
        WHERE Present = :presence
        ORDER by Nom";
        $stmt = $pdo->prepare($sql);
        $params = ['presence'=> $presence];
        $stmt->execute($params);
        $result = $stmt->fetchall(PDO :: FETCH_ASSOC);
        return $result;
}


function getListeUser($pdo){
        $sql = "SELECT * From salaries
        ORDER by Nom";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchall(PDO :: FETCH_ASSOC);
        return $result;
}
?>

<body class="bodyperso">
<div class="container">
<h1>Liste des utilisateurs <?=" ".$selection;?>.</h1>

<form action="userList.php" method="post">
                <select class="form-select" aria-label="Default select example" name="presence" required>

                    <option selected>Afficher les...</option>
                    <option value="1">Présents</option>
                    <option value="2">Absents</option>
                    <option value="3">Tous</option>

                </select>
       
                        
                <button type="submit" class="btn btn-primary">Filtrer</button>
</form>                       

<br>
        <table class="table">

        <thead>
                <tr>
                <!--<th scope="col">#</th>-->
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Matricule</th>
                <th scope="col">Niveau de droits</th>
                <th scope="col">Responsable</th>
                <th scope="col">Présence</th>
                </tr>
        </thead>

        <tbody>
<?php

for($i=0;$i< count($listeUser);$i++){

?>

<tr>
      <!--<td><?=$i?></td>-->
      <td><?=$listeUser[$i]['Nom']?></td>
      <td><?=$listeUser[$i]['Prenom']?></td>
      <td><?=$listeUser[$i]['Matricule']?></td>
      <td><?php
      
      switch ($listeUser[$i]['Type']){

        case 1:
                echo "Utilisateur";
                break;
        case 2:
                echo "Responsable de service";
                break;
        case 3:
                echo "Administrateur";
                break;
        
      }
      
      ?>
      </td>
      <td><?=$listeUser[$i]['Mat_Resp']?></td>
      <td><?php if ($listeUser[$i]['Present'] == 0){echo "Non";}else {echo "Oui";}?></td>
      <td><a class="btn btn-danger" href="userEdit.php?mat=<?=$listeUser[$i]['Matricule']?>">Modifier</a></td>


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

