<?php

var_dump($_POST);

if (isset($_POST['submit'])) {

    $current_date = date("Y-m-d");
    echo $current_date;

    if ( $_POST['date_debut'] < $current_date) {
        $_SESSION['erreur_date_debut'] = "La date de debut est dépassée";
    }
    else {
        $debut = $_POST['date_debut'];
    }


    if ($_POST['date_fin'] < $current_date) {
        $_SESSION['erreur_date_fin'] = "La date de fin est dépassée";
    }
    else {
        $fin = $_POST['date_fin'];
    }


    if ($_POST['type'] == "") {
        $_SESSION['erreur_type'] = "Ce champs ne peut etre vide";
    }
    else {
        $type = $_POST['type'];
    }

    if ($_POST['emplacement'] == "") {
        $_SESSION['erreur_emplacement'] = "Ce champs ne peut etre vide";
    }
    else {
        $empla = $_POST['emplacement'];
    }

    if (!isset( $_SESSION['erreur_date_debut']) && !isset( $_SESSION['erreur_date_fin']) && !isset( $_SESSION['erreur_type']) && !isset( $_SESSION['erreur_emplacement'])) {
        echo "enregistre";
        //je chercher dans la bdd si le jour existe 
        //si il existe compter le nombre de type
        // si egale  A 4 on reserve pas

        $bd = mysqli_connect("localhost","root","","camping");

        $reservation = "SELECT debut FROM reservations ";
        $query_reservation = mysqli_query($bd,$reservation);
        $result = mysqli_fetch_all($query_reservation);

        if (!empty($result)){
            echo "recherche les type de cette date";
            $requete_sum_type = "SELECT SUM(type) FROM `reservations` WHERE `debut` = 2020-06-16 and emplacement = 'La Plage'  ";
            $query_sum = mysqli_query($bd,$requete_sum_type);
            $resultat = mysqli_fetch_all($query_sum);

            var_dump($resultat);
        }
        else {
            echo "enregistre car pas de date";
        }
    }else {
        echo "erreur";
    }
}
?>