<?php
session_start();

//Connexion à la base de données
require('src/bdd-connect.php');


//Je teste si je clique sur le bouton envoi
if (isset($_POST['clic_envoi'])) {

        
		//Je test si tous les champs sont remplis
		if(!empty($_POST['identifiant'])  AND !empty($_POST['pass']))
		{
			$identifiant = htmlspecialchars($_POST['identifiant']);
			//  Je récupère toutes les infos relative à l'utilisateur 
			$req = $bdd->prepare('SELECT id, nom, prenom, identifiant, pass, question, reponse FROM utilisateurs WHERE identifiant = :identifiant '  );
            $req->execute(array( 'identifiant'=>$identifiant ) );
            $resultat = $req->fetch();
                     //Jeverifie l'existence de l'ulilisateur 
					if ($resultat)
					  { 
						    // Je verifie le mot de passe
						    $isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);

						    if ($isPasswordCorrect) {    
						        //  Récupération des informations utilisateur			     
						        session_start();
						        $_SESSION['id'] = $resultat['id'];
						        $_SESSION['identifiant'] = $identifiant;
						        $_SESSION['nom'] = $resultat['nom'];
						        $_SESSION['prenom'] = $resultat['prenom'];
						        $_SESSION['question'] = $resultat['question'];
						        $_SESSION['reponse'] = $resultat['reponse'];

						        header('Location: ../view/accueil.php');

						    } else { $erreur = 'Mot de pass incorrect!'; }

                       } else { $erreur = 'Mot de pass ou identifiant incorrect !'; }
          		
		} else { $erreur = 'Merci de remplir tous les champs';}
}

?>


<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta charset="utf-8" />
        <title>Groupement Banque-Assurance Français</title>
        <link rel="stylesheet" href="public/css/style.css" />
        <link rel="shortcut icon" href="public/images/logo-gbaf.png" type="image/x-icon">
    </head>
    
    <body>
        <div id="bloc_page">
            <header>
                    <div id="logo">
                        <img src="public/images/logo-gbaf.png" alt="Logo de G.B.A.F" />
                    </div>   
            </header>
            
            <hr>
            
            <section>
                <div id="titre-connexion"><h2>CONNEXION / INSCRIPTION</h2></div>               
                <div id="formulaire"> 
                 	<div id="message-erreur"> <?php if (isset($erreur)) { echo $erreur;} ?> </div>
                	<div id="info"><p>Merci d'indiquer votre identifiant et mot de passe pour rentrer sur le site du G.B.A.F</p></div>
                	<div id="message-validation"> <?php  if(isset($_SESSION['validate'])) {echo $_SESSION['validate'];} ?> </div>
		                <form method="post" >
							<table >
								<tr>
									<td class="alignement-table-formulaire"><label for="identifiant" >Identifiant :</label></td>
									<td><input type="text" name="identifiant" id="identifiant"></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="pass" >Mot de passe :</label></td>
									<td><input type="password" name="pass" id="pass"></td>
								</tr>
								<tr>
									<td></td>
									<td class="alignement-table-formulaire"><input type="submit" value="Connexion"  name="clic_envoi" id="clic_envoi"></td>
								</tr>
							</table>  
						</form> 
                 <p class=pass-oublie><a href="view/oubli-pass.php">Mot de passe oublié</a></p>   
                </div> 

                <div id="inscription">
                 	<p class=pass-oublie >Si cela concerne votre première visite merci de vous rendre sur  : <a href="view/inscription.php">la page d'inscription</a></p><br/>
                </div>

            </section>
            
           <?php include 'inc/footer.php'; ?>

        </div>
    </body>
</html>
