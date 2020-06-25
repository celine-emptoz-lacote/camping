<?php
session_start();


$db= mysqli_connect("localhost","root","","camping");
$id_booking= $_GET['id_booking'];

date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d');


$req_data_booking="SELECT * FROM `reservations` WHERE `id`= $id_booking";
$query_data_booking=mysqli_query($db, $req_data_booking);
$data_booking=mysqli_fetch_all($query_data_booking, MYSQLI_ASSOC);


$debut_booked= $data_booking[0]['debut'];
$fin_booked= $data_booking[0]['fin'];
$type_booked= $data_booking[0]['type'];
$id_user= $data_booking[0]['id_utilisateur']; 
$emplacement_booked= $data_booking[0]['emplacement'];
$option_1_booked= $data_booking[0]['option_1'];
$option_2_booked= $data_booking[0]['option_2'];
$option_3_booked= $data_booking[0]['option_3'];

$option_1=null;
$option_2=null;
$option_3=null;

if(isset($_POST['validate'])){

    $debut= htmlspecialchars($_POST["date_debut"]);
    $fin= htmlspecialchars($_POST["date_fin"]) ;
    $lieu=htmlspecialchars($_POST["place_choice"]);
    $type=htmlspecialchars($_POST["type"]);

    //RECUPERATION DATES
    $req_event_date= "SELECT * FROM `reservations` WHERE `emplacement`='$lieu' AND (`debut` <= '$debut' AND '$debut' <=`fin`) OR (`debut`< '$fin'AND '$fin' <`fin`)
    ";
    $query=mysqli_query($db, $req_event_date);
    $date_event=mysqli_fetch_all($query, MYSQLI_ASSOC);

    // COMPTER LES EMPLACEMENTS
    $req_count_places="SELECT SUM(`type`) FROM reservations WHERE `emplacement`='$lieu' AND (`debut` <= '$debut' AND '$debut' <=`fin`) OR (`debut`< '$fin'AND '$fin' <`fin`)";
    
    $query_count=mysqli_query($db, $req_count_places);
    $count_places=mysqli_fetch_all($query_count);
   
    
  

   
    if(!empty($lieu)&& !empty($type) && !empty($debut) && !empty($fin)){
        
    
        if(!empty($_POST['option_choice'])){

            foreach($_POST['option_choice'] as $option_selected){
                if($option_selected == "borne"){
                    $option_1="borne";
                }
                if($option_selected == "disco"){
                    $option_2="disco";
                }
                if($option_selected == "pack"){
                    $option_3="pack";
                }
            }  
            
        }

        if($debut < $date){
                 $_SESSION['error']="Vous ne pouvez pas réserver à une date antérieure"; 
                 
                 header("Location:../../change-reservation.php?id_booking=$id_booking");
                }

        elseif($debut>$fin){
                $_SESSION['error']="Créneau invalide";
                header("Location:../../change-reservation.php?id_booking=$id_booking");
                }

        elseif(empty($date_event)){
            
            $req_update= "UPDATE `reservations` SET `debut`= '$debut',`fin`='$fin',`type`='$type',`emplacement`='$lieu',`id_utilisateur`=$id_user,`option_1`='$option_1',`option_2`= '$option_2',`option_3`='$option_3' WHERE `id` = $id_booking";
                   
            mysqli_query($db,$req_update);

            $_SESSION['success']="Réservation mise à jour.";
            header("Location:../../espace-admin.php");
            

        }
        elseif(!empty($date_event)){
            


            for( $i=0;  $i<count($date_event); $i++){
                 

                if(($date_event[$i]['debut']<= $debut
                    && $debut <= $date_event[$i]['fin']) 
                    || ($date_event[$i]['debut']<= $fin 
                    && $fin <= $date_event[$i]['fin'])){
                        
                            
                    if($count_places[0][0] >= 4){
                  
                        $_SESSION['error']= "Désolée nous sommes complet. Veuillez réserver à une autre date";
                        header("Location:../../change-reservation.php?id_booking=$id_booking");
                                    
                    }
                    else
                    {
                         

                        $req_update= "UPDATE `reservations` SET `debut`= '$debut',`fin`='$fin',`type`='$type',`emplacement`='$lieu',`id_utilisateur`=$id_user,`option_1`='$option_1',`option_2`= '$option_2',`option_3`='$option_3' WHERE `id` = $id_booking";
                        mysqli_query($db,$req_update);
                        $_SESSION['success']="Réservation mise à jour";
                        header("Location:../../espace-admin.php");
                                
                       
                    }        
                }   
            }    
          
        }
   
    }
                
}
 
?>