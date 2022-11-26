<?php

//détruit la session et redirige vers la page d'acceuil
session_start();

session_destroy();
header('Location: ../index.php');


?>
</html>
