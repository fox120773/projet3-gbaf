<?php 

if(  !isset($_SESSION['nom']) AND !isset($_SESSION['prenom'])    ) 
 { header('Location:/../view/accueil.php'); }
else 
 {
 header('Location: ../index.php');
 }

?>