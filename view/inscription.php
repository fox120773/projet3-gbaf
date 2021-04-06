<?php

//Connexion à la base de données
require('../src/bdd-connect.php');


//Je teste si je clique sur le bouton envoi
if (isset($_POST['clic_envoi'])) {

     //Je test si tous les champs sont remplis
	if( !empty($_POST['nom']) AND !empty($_POST['prenom']) AND   !empty($_POST['identifiant']) AND !empty($_POST['pass']) AND !empty($_POST['pass2'])  AND !empty($_POST['reponse_q'])    )
	{
	   
	        $nom = htmlspecialchars($_POST['nom']);
	        $prenom = htmlspecialchars($_POST['prenom']);
	        $identifiant = htmlspecialchars($_POST['identifiant']);
			$reponse_q = htmlspecialchars($_POST['reponse_q']);
			$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);// Hachage du mot de passe
			
            //Je verifie l'existence de l'identifiant dans la table ulilisateurs 
	        $req = $bdd->prepare('SELECT identifiant FROM utilisateurs WHERE identifiant = :identifiant '  );
            $req->execute(array( 'identifiant'=>$identifiant ) );
            $resultat = $req->fetch();
	     
	        if ($resultat = $req->fetch())
	        {
	        $erreur = " Cet identifiant (".$identifiant .") est déjas utilisé ";
	        } 
			else
		    { 

                //Si OK Je veriffie le double mot de passe
			    if ($_POST['pass'] == $_POST['pass2'])               
		        {				  
							        // Insertion dans la BDD à l'aide d'une requette préparée
									$req = $bdd->prepare('INSERT INTO utilisateurs(nom, prenom, identifiant, pass, question, reponse) VALUES( :nom, :prenom, :identifiant, :pass, :question, :reponse)');
									$req->execute(array(
									'nom' => $nom,
									'prenom' => $prenom,
									'identifiant' => $identifiant,
									'pass' => $pass_hache,
									'question' => $_POST['question'],
									'reponse' => $reponse_q));

					                 header('Location: ../index.php');


		         } else {$erreur = 'Les deux  mots de passe ne correspondent pas';}  

            }
            
	} else {$erreur ='Merci de renseigner tous les champs doivent etre complètés';}

}

?>


<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta charset="utf-8" />
        <title>Groupement Banque-Assurance Français -inscription</title>
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
               <div id="titre-connexion"><h2>Créer un nouveau compte</h2></div>
               
              
               <div id="form-inscription"> 
               	      
               	      <div id="message-erreur"> <?php if (isset($erreur)) { echo $erreur;} ?> </div>
	                  
	                  <form method="post" >

							<table>
								<tr>
									<td class="alignement-table-formulaire"><label for="nom" >Nom :</label></td>
									<td><input type="text" name="nom" id="nom" ></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="prenom" >Prenom :</label></td>
									<td><input type="text" name="prenom" id="prenom"></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="identifiant" >Identifiant :</label></td>
									<td><input type="text" name="identifiant" id="identifiant"></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="pass" >Mot de passe :</label></td>
									<td><input type="password" name="pass" id="pass"></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="pass2" > Confirmer le mot de passe : </label></td>
									<td><input type="password" name="pass2" id="pass2"></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									
								</tr>
								<tr>
									<td class="alignement-table-formulaire" class="espace"><label for="question">Choisir parmis une question :</label></td>
									<td><select name="question" id="question" >
													<option value="Quelle est le nom de jeune fille de votre mère ?">Quelle est le nom de jeune fille de votre mère ? </option>
													<option value="Quelle est votre ville de naissance ?">Quelle est votre ville de naissance ?</option>
													<option value="Quelle était le nom de votre 1ère école primaire ?" selected="selected">Quelle était le nom de votre 1ère école primaire ?</option> 
										</select>
									</td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="reponse_q">Donner la réponse :</label></td>
									<td><input type="text" name="reponse_q" id="reponse_q"></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"></td>
									<td><input type="submit" value="Valider"  name="clic_envoi" id="clic_envoi"></td>
								</tr>

							</table>

					</form> 
                </div> 





            </section>
            
            <?php include '../inc/footer.php'; ?>
            
        </div>
    </body>
</html>
