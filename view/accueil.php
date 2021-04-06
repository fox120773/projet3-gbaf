<?php 
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');

//si la session nom et prenon n'exsiste pas je redirige à la page de connexion
if(  !isset($_SESSION['nom']) AND !isset($_SESSION['prenom'])    ) 
 { header('Location:../index.php'); }

?>


<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta charset="utf-8" />
        <title>Groupement Banque-Assurance Français - Acceuil</title>
        <link rel="stylesheet" href="../public/css/style.css" />
        <link rel="shortcut icon" href="../public/images/logo-gbaf.png" type="image/x-icon">
    </head>
    
    <body>
        <div id="bloc_page">
            
            <?php include '../inc/header.php'; ?>
            
            <hr>

            <section id="presentation">
                <div id="banniere">
                    <div id="banniere-titre"><h1>Groupement Banque Assurance Français</h1>
                        <p>Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. <br/>
                           Sa mission est de promouvoir l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics. 
                        </p>
                    </div>
                    <div id="banniere-image"><img src="../public/images/banniere.png" alt="Bannière" /></div>
                </div>
            </section>

            <hr>

            <section id="les-acteurs">
                
                
                    <div id="presentation-acteurs">
                         <h2>Acteurs et partenaires</h2>
                         <p>Le Groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 grands groupes français</p>
                    </div>

                
                <?php
                // On récupère les informations des acteurs 
                $req = $bdd->prepare('SELECT id, titre, contenu_court, url_logo, url_site  FROM acteurs ORDER BY id ');
                $req->execute(array( ) );
                //Je fait une boucle afin de tout pouvoir afficher
                while ($resultat = $req->fetch())
               {
                ?>
                <article class="acteur">         
                        <div class="logo-acteur"><img alt="Logo de l'acteur" src=<?php echo $resultat['url_logo']; ?>  /></div>
                        <div class="contenu">
                            <h3><?php echo htmlspecialchars($resultat['titre']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($resultat['contenu_court'])); ?> <br/> <a target="_blank" href="<?php echo $resultat['url_site'];  ?> " >voir le site internet</a></p>

                        </div>
                        <div class="suite"><a href="../view/commentaires.php?id=<?php echo $resultat['id']; ?>"> lire la suite</a></div>
                </article>

                <?php
                } // Fin de la boucle des articles acteurs
                $req->closeCursor();
                ?>

            </section>
            
            <?php include '../inc/footer.php'; ?>
          
        </div>
    </body>
</html>
