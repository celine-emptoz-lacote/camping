<?php 
session_start();
$db= mysqli_connect("localhost","root","","camping");
$error_login=null;
$error_password=null;

  
if (isset($_POST["valider"])){
    $login=htmlentities($_POST["login"]);
    $password= htmlentities($_POST["password"]);
    $pwd_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    $password_confirm= htmlentities($_POST["confirm_password"]);
    $default_status="utilisateur";
    
    $req_login="SELECT * FROM `utilisateurs` WHERE login ='$login'";
    $query_login=mysqli_query($db, $req_login);
    $compare_login= mysqli_fetch_all($query_login);
    
    if(count($compare_login) != 0){
        $error_login="Désolé ce login est déjà utilisé";
    }
    else{
        if($password === $password_confirm){
            $req_register="INSERT INTO `utilisateurs`(`login`, `password`, statut) VALUES ('$login','$pwd_hash', '$default_status' )";
            mysqli_query($db, $req_register);
            header("Location: connexion.php");
        }
        else{
            $error_password= "Votre mot de passe est différent";
        }
    }
    
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <header><?php include("header.php");?> </header>
    <main class="main_register">
        <h1>Inscription</h1>
        <?php if($error_login): ?>
        <div class="error">
          <p><?=  $error_login ?></p>
        </div>
        <?php endif; ?>
        <?php if($error_password): ?>
        <div class="error">
          <p><?=  $error_password ?></p>
        </div>
        <?php endif; ?>
        <div class="box"> 
            <form action="" method="post">
                <input type="text" name="login" placeholder="Votre login">
                <input type="password" name="password" placeholder="Votre mot de passe">
                <input type="password" name="confirm_password" placeholder="Confirmation de mot de passe">
                <button type="submit" name="valider">Valider</button>

            </form>
        </div> 
    </main>
    <footer><?php include("footer.php");?></footer>
    
</body>
</html>