<?php session_start();

if (isset($_POST['submit'])) {

    $bd = mysqli_connect("localhost","root","","camping");
    $default_statue = "utilisateur";

    if (!empty($_POST['login'])) {

        $login = $_POST['login'];

        //Vérification du login en BDD
        $requete = "SELECT COUNT(*) FROM utilisateurs WHERE login = '$login'";
        $query = mysqli_query($bd,$requete);
        $result = mysqli_fetch_all($query);

        if ($result[0][0] == 1){
            $_SESSION['erreur_log'] = "Ce login existe dejas";
        }
    }
    else {
        $_SESSION['erreur_log'] = "Ce champs ne peux pas etre vide"; 
    }


    if ($_POST['password'] == $_POST['password2']) {
        $passHash = password_hash($_POST['password'],PASSWORD_DEFAULT);
    }
    else {
        $_SESSION['erreur_pass'] = "Les mots de passe ne correspondent pas"; 
    }


    if (!isset( $_SESSION['erreur_log']) && !isset($_SESSION['erreur_pass']) ) {
       
            //enregistrement en BDD
            $requete_enregistrement = "INSERT INTO `utilisateurs`( `login`, `password`, `statut`) VALUES ('$login','$passHash','$default_statue')";
            $query_enregistrement = mysqli_query($bd,$requete_enregistrement);
            header('location: ../../connexion.php');
            exit; 
      
    }
    else {
        echo ' erreur';
        unset($_SESSION);
        header('location: ../../inscription.php');
    }
}
?>