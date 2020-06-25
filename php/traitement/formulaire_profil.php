<?php session_start();

if (isset($_SESSION['id'])) {

    $id = $_SESSION['id'];
    $bd = mysqli_connect("localhost","root","","camping");

    $requete = "SELECT * FROM utilisateurs WHERE id = $id ";
    $query = mysqli_query($bd,$requete);
    $resultat = mysqli_fetch_all($query);
    if (!empty($_POST['login'])) {

        if ($_POST['login'] != $resultat[0][1]) {
            $login = $_POST['login'];
            $requete_login = "SELECT COUNT(*) FROM utilisateurs WHERE login = '$login' ";
            $query_login = mysqli_query($bd,$requete_login);
            $resultat_login = mysqli_fetch_all($query_login);

            if (  $resultat_login[0][0] == 0) {
                $requete_enregistre = "UPDATE `utilisateurs` SET `login`= '$login' WHERE id = $id";
                $query_enregistre = mysqli_query($bd,$requete_enregistre);
                $_SESSION['success'] = "Les modifications ont bien été prises en compte";

            }
            else {
                $_SESSION['erreur_speudo'] = "Ce speudo existe dejas";
                header('location: ../../profil.php');
            }
        }
    }

    if (!empty($_POST['password']) && !empty($_POST['password1']) &&!empty($_POST['password2'])) {

        if (password_verify($_POST['password'],$resultat[0][2])) {
           
            if ($_POST['password1'] == $_POST['password2'] ) {

                $nouveau_passe = password_hash($_POST['password1'],PASSWORD_DEFAULT );

                $requete_passe = "UPDATE `utilisateurs` SET `password`=  '$nouveau_passe' WHERE id = $id";
                $query_passe = mysqli_query($bd,$requete_passe);
                $_SESSION['success'] = "Les modifications ont bien été prises en compte";
                
            } else {
                $_SESSION['erreur_passe'] = "Les mots de passe ne sont pas identique";
                header('location: ../../profil.php');
            }
        }
         else {
            $_SESSION['erreur_ancien_passe'] = "Ancien mot de passe incorrect";
            header('location: ../../profil.php');
         }
    }

header('location: ../../profil.php');
}
else {
    header('location: ../../connexion.php');
}

