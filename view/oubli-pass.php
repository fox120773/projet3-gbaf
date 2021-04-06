<?php

//Connexion à la base de données
require('../src/bdd-connect.php');

//Je teste si je clique sur le bouton envoi
if (isset($_POST['clic_envoi'])) {

        $identifiant = htmlspecialchars($_POST['identifiant']);
		//Je test si tous les champs sont remplis
		if(!empty($_POST['identifiant'])  )
		{
			   // Je vérifie l'existence de l'identifiant dans la  table « utilisateurs » de la Base de données
				$req = $bdd->prepare('SELECT identifiant, question FROM utilisateurs WHERE identifiant = :identifiant');
				$req->execute(array( 'identifiant' => $identifiant ) );
				$resultat = $req->fetch();
				
				if ($resultat)
                {
 
                    // Récupération des informations utilisateur en session			     
				     session_start();	        
			         $_SESSION['identifiant'] = $identifiant;
			         $_SESSION['question'] = $resultat['question'];

                     header('Location: question-pass.php');

				}
				  else { $erreur = 'identifiant incorrect !'; }
          		
		}
		else { $erreur = 'Merci de remplir le champs identifiant';}
}
?>


<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta charset="utf-8" />
        <title>Groupement Banque-Assurance Français</title>
        <link rel="stylesheet" href="../public/css/style.css" />
        <link rel="shortcut icon" href="../public/images/logo-gbaf.png" type="image/x-icon">
    </head>
    
    <body>
        <div id="bloc_page">
            <header>                
                    <div id="logo">
                        <a href="../index.php"><img src="../public/images/logo-gbaf.png" alt="Logo de G.B.A.F" /></a>
                    </div> 
            </header>
            
            <hr>
            
            <section>
               <div id="titre-connexion"><h2>Mot de pass oublié</h2></div>
                <div id="formulaire"> 
               	  <div id="message-erreur"> <?php if (isset($erreur)) { echo $erreur;} ?> </div>
                  <div id="info"><p>Merci de rentrer votre identifiant</p></div>

        	        <form method="post">
        						<table >
        							<tr>
        								<td class="alignement-table-formulaire"><label for="identifiant" >Identifiant :</label></td>
        								<td> <input type="text" name="identifiant" id="identifiant"></td>
        							</tr>
        							<tr>
        								<td></td>
        								<td class="alignement-table-formulaire"><input type="submit" value="Valider"  name="clic_envoi" id="clic_envoi"></td>
        							</tr>
        						</table>  
        					</form> 

                </div> 

            </section>
            
           <?php include '../inc/footer.php'; ?>

        </div>
    </body>
</html>
