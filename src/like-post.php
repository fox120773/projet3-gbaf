<?php
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');

$req = $bdd->prepare('SELECT id_utilisateur, id_acteur, likes FROM likes_dislikes WHERE id_utilisateur = :id_utilisateur AND id_acteur = :id_acteur ');
$req->execute(array( $_SESSION['id'], $_GET['id']  ) );
$resultat = $req->fetch();

           

//QUAND JE CLIQUE SUR LIKE (condition1)
if ($_GET['likes']== 1) {

     //Si l'id de l'itilisateur et l'id de l'acteur sont exsistants dans la table likes_dislike  je redirige
    if (isset($resultat['id_utilisateur'],$resultat['id_acteur'] )) 
    {              
         header('location:../view/commentaires.php?id='. $_GET['id']);     
    }
    else
    {
        //Je remplis la table likes_dislikes
        $req_insert = $bdd->prepare('INSERT INTO likes_dislikes ( id_utilisateur, id_acteur, likes) VALUES (:id_utilisateur, :id_acteur, :likes)');
        $req_insert->execute(array( 'id_utilisateur' => $_SESSION['id'] ,'id_acteur' => $_GET['id'] ,'likes'=> $_GET['likes']  ) );
         
        header('location:../view/commentaires.php?id='. $_GET['id']); 
    }

 }
 elseif ($_GET['likes']== 0) {  
               
        //Je supprime la ligne correspondant à  l'Id utilisateur
        $req_del = $bdd->prepare('DELETE FROM likes_dislikes WHERE id_utilisateur = :id_utilisateur AND id_acteur = :id_acteur');
        $req_del->execute(array( 'id_utilisateur' => $_SESSION['id'] ,'id_acteur' => $_GET['id']   ) );

        header('location:../view/commentaires.php?id='. $_GET['id']); 
          
 }

?>