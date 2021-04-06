<?php
session_start();

//Connexion à la base de données
require('../src/bdd-connect.php');

//si la session nom et prenon n'exsiste pas je redirige à la page de connexion
if(  !isset($_SESSION['nom']) AND !isset($_SESSION['prenom'])    ) 
 { header('Location:../index.php'); }


// On récupère la publication de l'acteur définit
$req = $bdd->prepare('SELECT id, titre, contenu_long, url_logo, url_site FROM acteurs WHERE id = :id' );
$req->execute(array('id' =>$_GET['id'] ));
$donnees = $req->fetch();

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

                        <div class="logo-contenu-acteur"><img alt="Logo acteur" src="<?php if (isset($_GET['id']) ) { echo $donnees['url_logo']; } else { header('Location:../view/accueil.php');} ?> " /> </div>

                        <div class="contenu-acteur">
                            <h3><a target="_blank" href="<?php if (isset($_GET['id']) AND $_GET['id'] >= 1 AND $_GET['id'] <= 6) { echo $donnees['url_site']; }  ?> " >
                                    <?php if (isset($_GET['id']) AND $_GET['id'] >= 1 AND $_GET['id'] <= 6){echo $donnees['titre'];}  ?>
                                </a>
                            </h3>
                            <p><?php if (isset($_GET['id']) AND $_GET['id'] >= 1 AND $_GET['id'] <= 6){echo $donnees['contenu_long'];} ?></p>
                        </div>
            </section>


            <section id="contenu-commentaires">
                <div id="conteneur-commentaires">
                    <div id="titre"><h3>Commentaires</h3></div>
                    <div id="bouton-commmantaires"><a href="commentaire-publie.php?id=<?php if (isset($_GET['id']) AND $_GET['id'] >= 1 AND $_GET['id'] <= 6) {echo $donnees['id']; }
                                                                                            else { header('location:../view/accueil.php');}?>">Nouveau commentaire
                                                   </a>
                    </div>
                       <div id="like">  
                                <table>
                                <tr>
                                    <td class="cellule">
                                        <?php
                                        //Je récupère le nombre de like de l'acteur definit
                                        $id_acteur = (int) $_GET['id'];
                                        $req_nblike = $bdd->prepare('SELECT (id_acteur) FROM likes_dislikes WHERE id_acteur = :id_acteur' );
                                        $req_nblike->execute(array( 'id_acteur'=> $id_acteur ) );
                                        echo $req_nblike->rowCount() ;
                                        ?>
                                    </td>
                                    <td><a href="../src/like-post.php?likes=1&amp;id=<?php  echo $donnees['id']; ?>"><img src="../public/images/picto_like.png" alt="Like"></a></td>
                                    <td><a href="../src/like-post.php?likes=0&amp;id=<?php echo $donnees['id']; ?>"><img src="../public/images/picto_dislike.png" alt="DisLike"></a></td>
                                </tr>
                                </table>
                        </div>
                            
                        
                </div>


               
                     <?php              
                    // Récupération des commentaires
                    $req = $bdd->prepare('SELECT prenom, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_commentaire_fr FROM commentaires WHERE id_acteur = ? ORDER BY date_commentaire DESC ');
                    $req->execute(array($_GET['id']));

                    while ($donnees = $req->fetch())
                    {
                    ?>
                    <div class="les-commentaires">
                    <strong><?php echo $donnees['prenom']; ?></strong><br/>
                     Le <?php echo $donnees['date_commentaire_fr']; ?><br/>
                    <p><?php echo nl2br($donnees['commentaire']); ?></p> 
                    </div>
                    <?php
                    } // Fin de la boucle des commentaires
                    $req->closeCursor();
                    ?>
                
            </section>

            <?php include '../inc/footer.php'; ?>

        </div>
    </body>
</html>
