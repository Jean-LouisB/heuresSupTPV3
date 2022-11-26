<?php
$titre="Mot de passe changé"; //La définition du titre de la page se fait fait dans chaque page et est attribué dans l'include ci-dessous
include('includes/AllIncludes.php'); //contient tous les includes necessaires
if (!isset($_SESSION['Matricule'])){
    header('location:index.php');
}
?>
<div>
    <br>
</div>
<div class="container">


<H3>Mot de passe modifié</h3>

</div>

</html>
