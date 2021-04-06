<?php 
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');
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

            <?php include '../inc/header.php'; ?>                                             
            
            <hr>

            <section id="contenu-acteur">

                <?php
                // On récupère la publication de l'acteur définit
                $req = $bdd->prepare('SELECT id, titre, contenu_long, url_logo, url_site FROM acteurs WHERE id = :id' );
                $req->execute(array('id' =>$_GET['id'] ));
                $donnees = $req->fetch();
                ?>
       
                        <div class="logo-contenu-acteur"><img src=<?php if (isset($_GET['id']) AND $_GET['id'] >= 1 AND $_GET['id'] <= 6) { echo $donnees['url_logo']; } else { header('Location:accueil.php');} ?>   /></div>

                        <div class="contenu-acteur">
                            <h3><a href=<?php echo $donnees['url_site']; ?>  ><?php echo $donnees['titre']; ?></a></h3>
                            <p><?php echo $donnees['contenu_long']; ?></p>
                        </div>
            </section>

            <hr>

            <section id="contenu-commentaires-publie">

                <div id="titre"><h3>Ajouter votre commentaire</h3></div>

                <div id=le-commentaire>
                    <form action="../src/commentaire-post.php" method="post">
                            <label for="commentaire"></label>
                                           <textarea type="text" name="commentaire" id="commentaire" rows="10" cols="60"  placeholder=
                                 <?php
                                        $req = $bdd->prepare('SELECT id_utilisateur,id_acteur FROM commentaires WHERE id_utilisateur = :id_utilisateur AND id_acteur = :id_acteur ');
                                        $req->execute(array( 'id_utilisateur'=>$_SESSION['id'], 'id_acteur'=>$_GET['id']  ) );
                                        $resultat = $req->fetch();
                                       //Si l'id_utilisateur et l'id_acteur exsistes , je modifie le commentaire
                                       if (isset($resultat['id_utilisateur'],$resultat['id_acteur'])  ) {echo '"Merci d\'écrire un nouveau commentaire"';} else {echo '"Votre commentaire ici"';}
                                  ?>    ></textarea><br />
                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                            <input type="submit" value="Envoyer" name="submit_commentaire" />
                    </form>
                </div>

            </section>

           <?php include '../inc/footer.php'; ?>

        </div>
    </body>
</html>
