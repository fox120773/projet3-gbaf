<?php
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');

//Je teste si je clique sur le bouton envoi
if (isset($_POST['clic_envoi'])) {

     //Je test si tous les champs sont remplis
    if( !empty($_POST['new_pass']) AND !empty($_POST['new_pass_chek'])    )
    {
       
                   $identifiant = $_SESSION['identifiant'] ;

                  // je verifie que les mots de passes correspondent
                  if ($_POST['new_pass'] == $_POST['new_pass_chek'])               
                  {
                     $new_pass_hache = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);// Hachage du mot de passe
                    // Je modiffie le mot de passe correspondant a l'identifiant dans la BDD
                     $req = $bdd->prepare('UPDATE utilisateurs  SET pass = :nv_pass   WHERE identifiant = :identifiant_session');
                     $req->execute(array('nv_pass' => $new_pass_hache , 'identifiant_session' => $identifiant)  );
                   
                     header('Location: ../index.php');

                  }else {$erreur ='les mots de passe ne correspondent pas';}
            
        
    } else {$erreur ='Merci de remplir tous les champs';}

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
               <div id="titre-connexion"><h2>Modifier votre mot de passe</h2></div>

                <div id="formulaire"> 
                      
                      <div id="message-erreur"> <?php if (isset($erreur)) { echo $erreur;} ?> </div>
                      
                      <form method="post" >
                            <table>
                                <tr>
                                    <td class="alignement-table-formulaire"><label for="new_pass" >Nouveau mot de passe :</label></td>
                                    <td><input type="password" name="new_pass" id="new_pass"></td>
                                </tr>
                                <tr>
                                    <td class="alignement-table-formulaire"><label for="new_pass_chek" > Confirmer votre nouveau  mot de passe : </label></td>
                                    <td><input type="password" name="new_pass_chek" id="new_pass_chek"></td>
                                </tr>
                                <tr>
                                    <td class="alignement-table-formulaire"git add ></td>
                                    <td><input type="submit" value="Modifier le mot de passe"  name="clic_envoi" id="clic_envoi"></td>
                                </tr>
                            </table>
                      </form> 
                </div> 

          </section>
            
            <?php include '../inc/footer.php'; ?>

        </div>
    </body>
</html>
