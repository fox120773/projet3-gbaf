<!DOCTYPE html>
<html lang=fr>
 <head>
        <meta charset="utf-8" />
        <title>Groupement Banque-Assurance Français - Acceuil</title>
        <link rel="stylesheet" href="../public/css/style.css" />
        <link rel="shortcut icon" href="../public/css/images/logo-gbaf.png" type="image/x-icon">
    </head>
<body>

       <header>     
                <div id="logo">
                <a href="accueil.php"><img src="../public/images/logo-gbaf.png" alt="Logo de G.B.A.F" /></a>
                </div>
                          
                <div id="para-utilisateur">
                      <div id="menu-para">
                            <nav>
                                 <ul>
                                      <li class="deroulant"><a href="#"><img src="../public/images/picto-avatar.png" alt="avatar" ></a>
                                  <ul class="sous">
                                      <li><a href="../view/parametres.php">Parametre du compte</a></li>
                                      <li><a href="../src/deconnexion.php">déconnexion</a></li>
                                   </ul>
                                      </li>
                                   </ul>
                             </nav>
                      </div>
                 <div id="nom-prenom"><?php  echo $_SESSION['nom'] .' '. $_SESSION['prenom']; ?> </div>
                 </div>
      </header>
</body>
</html>