<?php
session_start();
//var_dump($_POST);
$id_utilisateur = 1;

/****  VARIABLES ****/
$compte = 0;
$current_date = date("Y-m-d");

/***  CONNEXION BDD***/
$bd = mysqli_connect("localhost","root","","camping");

require 'functions.php';
   

if (isset($_POST['submit'])) {

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
        if ($_POST['type'] == 'tente') {
            $type = 1; 
        }
        else {
            $type = 2;  
        }
    }


    if ($_POST['emplacement'] == "") {
        $_SESSION['erreur_emplacement'] = "Ce champs ne peut etre vide";
    }
    else {
        $empla = $_POST['emplacement'];
    }

   

    $option_1 = option('options1',1) ;
    $option_2= option('options2',2) ;
    $option_3 = option('options3',3) ;
   

    if (!isset( $_SESSION['erreur_date_debut']) && !isset( $_SESSION['erreur_date_fin']) && !isset( $_SESSION['erreur_type']) && !isset( $_SESSION['erreur_emplacement'])) {
        
        $requete = "SELECT * FROM reservations WHERE emplacement = '$empla' AND  (debut <= '$debut' AND debut <= '$fin') OR (fin  <= '$debut' AND fin <= '$fin')";
		$query = mysqli_query($bd, $requete);
        $resultat = mysqli_fetch_all($query,MYSQLI_ASSOC);

        if (!empty($resultat)) {

            for ($i = 0 ; $i < COUNT($resultat) ; $i ++) {
                if( (  $debut >= $resultat[$i]['debut']  &&   $debut <= $resultat[$i]['fin'] ) || ( $resultat[$i]['debut'] <= $fin && $resultat[$i]['fin'] <= $fin) ) {
                    
                    $requete_compte = "SELECT SUM(`type`) FROM reservations WHERE `emplacement`='$empla' AND (`debut` <= '$debut' AND '$debut' <=`fin`) OR (`debut`< '$fin'AND '$fin' <`fin`)";
                    $query_compte = mysqli_query($bd,$requete_compte);
                    $resultat_compte = mysqli_fetch_all($query_compte);

                    var_dump( $requete_compte);
                if ( $resultat_compte[0][0] <= 4 ) {
                    echo "1";
                    if ( ($resultat_compte[0][0] + $type) > 4 ){
                        $_SESSION['erreur_resa'] = "Il n'y a plus de place à cette date ";
                        //header('location: ../../reservation.php');
                    }
                    else {
                        insertion($bd,$debut,$fin,$type,$empla,$id_utilisateur,$option_1,$option_2,$option_3);
                        //header('location: ../../planning.php');

                    }
                   
                }
                else {
                    $_SESSION['erreur_resa'] = "Il n'y a plus de place à cette date ";
                    //header('location: ../../reservation.php');
                }

            }
        }   
        }
        else {
             insertion($bd,$debut,$fin,$type,$empla,$id_utilisateur,$option_1,$option_2,$option_3);
             header('location: ../../planning.php');
        }
}
else {
    $_SESSION['erreur_form'] = "probleme formulaire";
   header('location: ../../reservation.php');
}
}
?>