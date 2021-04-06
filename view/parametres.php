<?php
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');

//si la session nom et prenon n'exsiste pas je redirige à la page de connexion
if(  !isset($_SESSION['nom']) AND !isset($_SESSION['prenom'])    ) 
 { header('Location:../index.php'); }


//Je teste si je clique sur le bouton envoi
if (isset($_POST['clic_envoi'])) {

     //Je test pour savoir si tous les champs sont remplis
	if( !empty($_POST['identifiant'])  AND !empty($_POST['reponse_q'])    )
	{
	   
	    $identifiant = htmlspecialchars($_POST['identifiant']);
		$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);// Hachage du mot de passe
		$reponse_q = htmlspecialchars($_POST['reponse_q']);
	    $validate ='Vos informations ont été modifiées avec succes.';            
							                
		// Modiffication  des informations utilisateur dans la BDD à l'aide d'une requette préparée
		$req = $bdd->prepare('UPDATE utilisateurs SET identifiant= :nv_identifiant , question = :nv_questions ,reponse= :nv_reponse  WHERE id = :id_session');
		$req->execute(array(
		'nv_identifiant' => $identifiant,
		'nv_questions' => $_POST['question'],
		'nv_reponse' => $reponse_q,
		'id_session' => $_SESSION['id']));

		session_start();
		$_SESSION['identifiant'] = $identifiant;
		$_SESSION['question'] = $_POST['question'];
		$_SESSION['reponse'] = $reponse_q;
                
		header('Location: ../view/accueil.php');
            
	} else {$erreur ='<strong>Erreur :</strong>Tous les champs doivent etre complètés';}
}

?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Groupement Banque-Assurance Français</title>
        <link rel="stylesheet" href="../public/css/style.css" />
        <link rel="shortcut icon" href="../public/images/logo-gbaf.png" type="image/x-icon">
    </head>
    
    <body>
        <div id="bloc_page">

           <?php include '../inc/header.php'; ?>
            
            <hr>
            
            <section>
               <div id="titre-connexion"><h2>Paramètres du compte</h2></div>
               
              
               <div id="form-inscription"> 
               	      
               	      <div id="message-erreur"> <?php if (isset($erreur)) { echo $erreur;} ?> </div>
	                  
	                    <form method="post" >

							<table>
								<tr>
									<td class="alignement-table-formulaire">Nom :</td>
									<td><?php  if(isset($_SESSION['nom'])) {echo $_SESSION['nom'];} ?></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire">Prenom :</td>
									<td><?php  if(isset($_SESSION['prenom'])) {echo $_SESSION['prenom'];} ?></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for=" identifiant" >Identifiant :</label></td>
									<td><input type="text" name="identifiant" id="identifiant" value= <?php  if(isset($_SESSION['identifiant'])) {echo '"'.$_SESSION['identifiant'] .'"';} ?> ></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire">Mot de passe :</td>
									<td class="pass-oublie" ><a href="modif-pass.php">Le modiffier</a></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire" class="espace"><label for="question" >Choisir parmis une question :</label></td>
									<td><select name="question" >
													<option value="Quelle est le nom de jeune fille de votre mère ? " <?php if (isset($_SESSION['question'])) { if($_SESSION['question'] == 'Quelle est le nom de jeune fille de votre mère ?') {echo 'selected="selected"';}} ?>>Quelle est le nom de jeune fille de votre mère ? </option>
													
													<option value="Quelle est votre ville de naissance ?" <?php if (isset($_SESSION['question'])) { if($_SESSION['question'] == 'Quelle est votre ville de naissance ?') {echo 'selected="selected"';}} ?>>Quelle est votre ville de naissance ?</option>
													
													<option value="Quelle était le nom de votre 1ère école primaire ?" <?php if (isset($_SESSION['question'])) { if($_SESSION['question'] == 'Quelle était le nom de votre 1ère école primaire ?') {echo 'selected="selected"';}} ?>>Quelle était le nom de votre 1ère école primaire ?</option> 
										</select>
									</td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"><label for="reponse_q" >Donner la réponse :</label></td>
									<td><input type="texte" name="reponse_q" id="reponse_q" value=<?php  if(isset($_SESSION['reponse'])) {echo '"'.$_SESSION['reponse'] .'"';} ?>></td>
								</tr>
								<tr>
									<td class="alignement-table-formulaire"></td>
									<td><input type="submit" value="Modifier vos informations"  name="clic_envoi" id="clic_envoi"></td>
								</tr>

							</table>

					    </form> 
                </div> 

            </section>
            
            <?php include '../inc/footer.php'; ?>
            
        </div>
    </body>
</html>
