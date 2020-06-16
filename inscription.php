<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<form action="PHP/traitement/formulaire_inscription.php" method="POST">

    <?php if (isset( $_SESSION['erreur_log'])) :?>
    <p><?php echo $_SESSION['erreur_log'] ?> </p>
    <?php endif ;?>

    <?php if (isset( $_SESSION['erreur_pass'])) :?>
    <p><?php echo $_SESSION['erreur_pass'] ?> </p>
    <?php endif ; ?>

    <label for="login">Login :</label>
    <input type="text" id="login" name="login">

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password">

    <label for="password2">Confirmer votre mot de passe :</label>
    <input type="password" id="password2" name="password2">

    <input type="submit" name="submit">
</form>
    
</body>
</html>

<?php unset($_SESSION['erreur_log'],$_SESSION['erreur_pass']) ?>