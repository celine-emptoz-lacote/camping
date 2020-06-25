<?php session_start();


if (!isset($_SESSION['id'])) {
    $_SESSION['erreur_co'] = "Vous devez etre connecter pour acceder à cette page !";
    header('location: connexion.php');
} else {
    $bd = mysqli_connect("localhost","root","","camping");
    $id = $_SESSION['id'];
    $requete = "SELECT * FROM utilisateurs WHERE id = $id ";
    $query = mysqli_query($bd,$requete);
    $resultat = mysqli_fetch_all($query);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="main_profil">

    
    <section class="section_form_profil">
        <form action="php/traitement/formulaire_profil.php" method="POST" >
        <h1 class="titre_profil">Mon Compte</h1>
        <?php if (isset($_SESSION['erreur_speudo'])) { echo "<p class='error'>".$_SESSION['erreur_speudo']."</p>" ;} ?>
        <?php if (isset($_SESSION['erreur_passe'])) { echo "<p class='error'>".$_SESSION['erreur_passe']."</p>" ;} ?>
        <?php if (isset($_SESSION['erreur_ancien_passe'])) { echo "<p class='error'>".$_SESSION['erreur_ancien_passe']."</p>" ;} ?>
        <?php if (isset($_SESSION['success'])) { echo "<p class='success'>".$_SESSION['success']."</p>" ;} ?>


        <label for="login">Login :</label>
            <input type="text" id="login" name="login" value="<?php echo $resultat[0][1] ?>">
           
                    <label for="password">Ancien mot de passe :</label>
                    <input type="password" id="password" name="password">
               
                    <label for="password1">Nouveau mot de passe :</label>
                    <input type="password" id="password1" name="password1">
                
                    <label for="password2">Confirmer votre mot de passe :</label>
                    <input type="password" id="password2" name="password2">
                
            <input type="submit" name="submit">
        </form>
        <div class="image_profil">
            <img src="src/img/profil.jpg" alt="Image de profil">
        </div>
    </section>
    <section>
        <h2>Mes réservations</h2>

        <?php 

        $requete_resa = "SELECT * FROM `reservations` WHERE id_utilisateur = $id  ";
        $query_resa = mysqli_query($bd,$requete_resa);
        $resultat_resa = mysqli_fetch_all($query_resa, MYSQLI_ASSOC);


        $requete_tarifs = "SELECT * FROM tarifs";
        $query_tarifs = mysqli_query($bd,$requete_tarifs);
        $resultat_tarifs = mysqli_fetch_all($query_tarifs,MYSQLI_ASSOC);

        
        for ($i = 0 ; $i < COUNT($resultat_resa) ; $i++) :?>

            <?php  $nb_days= (strtotime($resultat_resa[$i]['fin']) - strtotime($resultat_resa[$i]['debut'])) / 86400 +1; ?>
            <?php 
            $prix_emplacement=$resultat_tarifs[2]['prix'];
            $nb_emplacement=$resultat_resa[$i]['type'];

            if($resultat_resa[$i]['option_1'] == "borne" || $resultat_resa[$i]['option_2'] == "borne" || $rresultat_resat[$i]['option_3'] == "borne"){
                $prix_borne= $resultat_tarifs[0]['prix'];
             }
             else{
                 $prix_borne=0;
             }
             if($resultat_resa[$i]['option_1'] == "disco" || $resultat_resa[$i]['option_2'] == "disco" || $resultat_resa[$i]['option_3'] == "disco"){
                $prix_disco= $resultat_tarifs[1]['prix'];
             }
             else{
                 $prix_disco=0;
             }
             if($resultat_resa[$i]['option_1'] == "pack" || $resultat_resa[$i]['option_2'] == "pack" || $resultat_resa[$i]['option_3'] == "pack"){
                $prix_pack= $resultat_tarifs[3]['prix'];
             }
             else{
                 $prix_pack=0;
             }
         
             $total= ($prix_borne * $nb_days + $prix_disco * $nb_days + $prix_pack * $nb_days) + ($nb_emplacement*$prix_emplacement)*$nb_days;
            ?>
            <section class="section_profil_reservations">
            
                <div>
                    <p>Séjour du <?= date ("d-m-Y",strtotime($resultat_resa[$i]['debut'])) ?> <img src="src/img/fleche.png" alt="fleche"> <?= date("d-m-Y",strtotime($resultat_resa[$i]['fin'])) ?>
                </div>
                
                <div class="div_jours">
                    <p> <img src="src/img/jours.png" alt="calendrier"> Nombre de jour : <?= $nb_days ?> </p> 
                    <p> <span class="profil_tarif">Tarif : <?= $total ?> euros </span></p>
                </div>
                <div class="type_reservation">
                    <?php if ($resultat_resa[$i]['type'] == 1 ) :?>
                        <img src="src/img/tente.png" alt="Tente">
                    <?php else :?>
                        <img src="src/img/campingcar.png" alt="Camping car">
                    <?php endif ;?>
                </div> 
                <div class="options">
                    <div >
                        <?php if ( $resultat_resa[$i]['option_1'] != '') :?>
                            <p> Borne éléctrique : <img src="src/img/check.png" alt="check"> </p>
                        <?php else :?>
                            <p> Borne éléctrique : <img src="src/img/croix.png" alt="croix"> </p>
                        <?php endif ;?>
                    </div>

                    <div>
                        <?php if ($resultat_resa[$i]['option_2'] != ''):?>
                            <p> Club Disco : <img src="src/img/check.png" alt="check"> </p>
                        <?php else :?>
                            <p> Club Disco : <img src="src/img/croix.png" alt="croix"> </p>
                        <?php endif ;?>
                    </div>

                    <div>
                        <?php if ( $resultat_resa[$i]['option_3'] != '') :?>
                            <p> Pack : <img src="src/img/check.png" alt="check"> </p>
                        <?php else :?>
                            <p> Pack : <img src="src/img/croix.png" alt="croix"> </p>
                        <?php endif ;?>
                    </div>
                </div>   
            </section>
        
    
        <?php endfor ;?>

    </section>
</main> 
</body>
</html>

<?php unset($_SESSION['erreur_speudo'],$_SESSION['erreur_passe'],$_SESSION['erreur_ancien_passe'],$_SESSION['success']) ?>