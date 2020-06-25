<?php
session_start();
date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d');

$db= mysqli_connect("localhost","root","","camping");

$id_session=intval($_SESSION["id"]);

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
                $_SESSION["error"]="Vous ne pouvez pas réserver à une date antérieure";
                header("Location:../../reservation-form.php");
                
                 }

        elseif($debut>$fin){
            $_SESSION["error"]="Créneau invalide";
                //header("Location:../../reservation-form.php");
            }

        elseif(empty($date_event)){
            
            $req_insert="INSERT INTO `reservations`( `debut`, `fin`, `type`,  `emplacement`, `id_utilisateur`, `option_1`, `option_2`, `option_3`) 
            VALUES ('$debut','$fin',$type,'$lieu',$id_session,'$option_1','$option_2','$option_3')";
            
            
                   
            mysqli_query($db,$req_insert);
            $_SESSION['success']="Votre réservation a bien été enregistrée.";
            header("Location:../../profil.php");

        }
        elseif(!empty($date_event)){


            for( $i=0;  $i<count($date_event); $i++){
                 

                if(($date_event[$i]['debut']<= $debut
                    && $debut <= $date_event[$i]['fin']) 
                    || ($date_event[$i]['debut']<= $fin 
                    && $fin <= $date_event[$i]['fin'])){
                        
                            
                    if($count_places[0][0] >= 4){
                  
                        $_SESSION["error"]= "Désolée nous sommes complet. Veuillez réserver à une autre date";
                        header("Location:../../reservation-form.php");
                                    
                    }
                    else
                    {
                         $req_insert="INSERT INTO `reservations`( `debut`, `fin`, `type`,  `emplacement`, `id_utilisateur`, `option_1`, `option_2`, `option_3`) 
                          VALUES ('$debut','$fin',$type,'$lieu',$id_session,'$option_1','$option_2','$option_3')";
                        
                    
                         mysqli_query($db,$req_insert);
                         $_SESSION['success']="Votre réservation a bien été enregistrée.";
                         header("Location:../../profil.php");
                        
                                
                       
                    }
    
                            
                           
                }
            }    




        }
   



    }
    else{
        $_SESSION['error']="Veuillez remplir tous les champs";
        header("Location:../../reservation-form.php");
    }
                
}

?>