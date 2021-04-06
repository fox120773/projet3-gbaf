<?php
session_start();


//Connexion à la base de données
require('../src/bdd-connect.php');


//Je teste si je clique sur le bouton envoi
if (isset($_POST['clic_envoi'])) {

        $identifiant = $_SESSION['identifiant'];
        $reponse_q = htmlspecialchars($_POST['reponse_q']);

		//Je teste si tous les champs sont remplis
		if(!empty($_POST['reponse_q'])  )
		{    
					
			//  Je teste si la réponse correspond avec la réponse de la BDD
			$req = $bdd->prepare('SELECT identifiant, reponse  FROM utilisateurs WHERE identifiant = :identifiant AND reponse = :reponse '  );
            $req->execute(array( 'reponse' => $reponse_q , 'identifiant'=>$identifiant ) );
            $resultat = $req->fetch();
            
            if ($resultat)
            {
                       //  Je peux réinitialiser le mot de passe			            
                        header('Location: modif-pass.php');
                      
            }else { $erreur = 'Réponse incorrecte'; }

		}else { $erreur = 'Merci de répondre à la question';}
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
                        <a href="accueil.php"><img src="../public/images/logo-gbaf.png" alt="Logo de G.B.A.F" /></a>
                    </div>
                    
            </header>
            
            <hr>
            
            <section>
               <div id="titre-connexion"><h2>Merci de bien vouloir répondre à la question</h2></div>
               
              
                <div id="formulaire"> 
               	  <div id="message-erreur"> <?php if (isset($erreur)) { echo $erreur;} ?> </div>

	               <form method="post" >
                    <p><?php if (isset($_SESSION['question'])) { echo $_SESSION['question'];} ?></p>
						<table >
							<tr>
								<td class="alignement-table-formulaire"><label for="reponse_q" >Votre réponse :</label></td>
								<td> <input type="text" name="reponse_q" id="reponse_q"></td>
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
