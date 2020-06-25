<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="font/fontello/css/fontello.css">
    <link rel="stylesheet" href="font/fontello1/css/fontello.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><?php include 'php/include/header.php'?></header>
<main class="main_inscription">
    <div class="div_inscription">
        <form action="PHP/traitement/formulaire_inscription.php" method="POST">
            <h1 class="titre_creation_compte">Créer un compte</h1>
            <?php if (isset( $_SESSION['erreur_log'])) :?>
            <p><?php echo "<p class='error'>".$_SESSION['erreur_log']."</p>" ?> </p>
            <?php endif ;?>

            <?php if (isset( $_SESSION['erreur_pass'])) :?>
            <p><?php echo "<p class='error'>".$_SESSION['erreur_pass']."</p>" ?> </p>
            <?php endif ; ?>

            <input type="text" id="login" name="login" placeholder=" Login">

            <input type="password" id="password" name="password" placeholder=" Mot de passe">

            <input type="password" id="password2" name="password2" placeholder=" Confirmer votre mot de passe">

            <input type="submit" name="submit">
        </form>

        <section class="section_inscription">
            <h1 class="titre_inscription">Vous avez déjà un compte ?</h1>
            <p>Connectez-vous pour gérer vos réservations, débloquer des offres exclusives et bien plus encore</p>
            <a class="connexion" href="connexion.php">Se connecter</a>
            <div>
                <a class="icon-facebook-squared" href="https://fr-fr.facebook.com/"></a>
                <a class="icon-twitter-squared" href="https://twitter.com/explore"></a>
                <a class="icon-instagram" href="https://www.instagram.com/?hl=fr"></a>
            </div>
        </section>
    <div>
</main>
<footer><?php include 'php/include/footer.php' ?></footer>   
</body>
</html>

<?php unset($_SESSION['erreur_log'],$_SESSION['erreur_pass']) ?>