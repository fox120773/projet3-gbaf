<?php
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');



//Cette requete me sert à récuperer l' id_utilisateur  et l'id acteur  dans la table comentaire pour en connaitre l'exsistance 
$req = $bdd->prepare('SELECT id_utilisateur,id_acteur FROM commentaires WHERE id_utilisateur = :id_utilisateur AND id_acteur = :id_acteur ');
$req->execute(array( 'id_utilisateur'=>$_SESSION['id'], 'id_acteur'=>$_POST['id']  ) );
$resultat = $req->fetch();
//Si l'id_utilisateur et l'id_acteur exsistes , je modifie le commentaire
if (isset($resultat['id_utilisateur'],$resultat['id_acteur']) AND  !empty($_POST['commentaire'])  ) 
{   
	    

	    $nv_commentaire = htmlspecialchars($_POST['commentaire']);
	    
		$req_modif = $bdd->prepare('UPDATE commentaires SET commentaire = :nv_commentaire ,date_commentaire = NOW()   WHERE id_utilisateur LIKE :utilisateur AND id_acteur LIKE :id_acteur ');
	    $req_modif->execute(array( $nv_commentaire , $_SESSION['id'] , $_POST['id']    ) );
	    
	    header('location:../view/commentaires.php?id='. $_POST['id']);


} 
else 
{
         // Si le commentaire exsiste et qu'il n'est pas vide j'insert dans la table "commentaires"
		if(isset($_POST['commentaire']) AND  !empty($_POST['commentaire'])) {

				 // Insertion du message à l'aide d'une requête préparée
		$post_commentaire = htmlspecialchars($_POST['commentaire']);
		$post_prenom = $_SESSION['prenom'];
		$req = $bdd->prepare('INSERT INTO commentaires (prenom,commentaire, id_acteur,id_utilisateur, date_commentaire) VALUES ( :prenom, :commentaire, :id_acteur, :id_utilisateur, NOW()) ');
		$req->execute(array( 'prenom' => $post_prenom ,
			     	    'commentaire' => $post_commentaire , 
			     	      'id_acteur' => $_POST['id']  , 
			     	  'id_utilisateur'=> $_SESSION['id']) );
			     
	     // Redirection du visiteur vers la page  du contenu acteur
			      header('location:../view/commentaires.php?id='. $_POST['id']);
				  
		} 
			else {  
				header('location:../view/commentaire-publie.php?id='. $_POST['id']);
			     }
 }       
?>