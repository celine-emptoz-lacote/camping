<?php $page = $_SERVER['PHP_SELF']; ?>

<div class="header_menu">

    <div class="header_title"><h1>Les Happy Sardines</h1></div>
    
   
    <nav class="menu">
        <ul class="menu_ul">
            <li class="icon_menu" ></li>
            <ul class="submenu">
                <li>            
                <?php if($page !== '/camping/index.php'):?>
                <a href="index.php">Accueil</a>
                <?php endif ?>
                </li>
                <li><a href="reservation-form.php">Réserver</a></li>
                <li><a href="planning.php">Planning</a></li>
                <?php if(!isset($_SESSION['id'])):?>   
                <li><a href="connexion.php">Se connecter</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
                <?php endif ?>   
                <?php if(isset($_SESSION['id'])): ?>   
                <li><a href="profil.php">Mon compte</a></li>
                <?php endif ?>  
                <?php if(isset($_SESSION['admin'])):?>
                <li><a href="espace-admin.php">Espace administrateur</a></li>
                <?php endif ?>
                <?php if(isset($_SESSION['id'])):?>
                <li><a href="logout.php">Se déconnecter</a></li>
                <?php endif?>   
            </ul>
        </ul> 
            
    </nav>  

</div>
<?php if($page == '/camping/index.php'):?> 
<div class="img_index">
    <h1>Emplacement camping pour Tente et Camping-Car</h1>

</div>
<?php endif ?>




