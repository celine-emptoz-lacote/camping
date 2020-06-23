<?php
session_start();
$error=null;

$db= mysqli_connect("localhost","root","","camping");
$id_booking= $_GET['id_booking'];
date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d');


$req_data_booking="SELECT * FROM `reservations` WHERE `id`= $id_booking";
$query_data_booking=mysqli_query($db, $req_data_booking);
$data_booking=mysqli_fetch_all($query_data_booking, MYSQLI_ASSOC);
var_dump($data_booking);

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
        
     echo"pas vide";
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
        echo"pas vide";
    }

        if($debut<$date){
                 echo $error="Vous ne pouvez pas réserver à une date antérieure"; 
                }

        if($debut>$fin){
                 echo $error="Créneau invalide";
                }

        if(empty($date_event)){
            
            
            $req_update= "UPDATE `reservations` SET `debut`= '$debut',`fin`='$fin',`type`='$type',`emplacement`='$lieu',`id_utilisateur`=$id_user,`option_1`='$option_1',`option_2`= '$option_2',`option_3`='$option_3' WHERE `id` = $id_booking";
            
            
                   
            mysqli_query($db,$req_update);
            header("Location:espace-admin.php");
            

        }
        if(!empty($date_event)){
            


            for( $i=0;  $i<count($date_event); $i++){
                 

                if(($date_event[$i]['debut']<= $debut
                    && $debut <= $date_event[$i]['fin']) 
                    || ($date_event[$i]['debut']<= $fin 
                    && $fin <= $date_event[$i]['fin'])){
                        
                            
                    if($count_places[0][0] >= 4){
                  
                        $error= "Désolée nous sommes complet. Veuillez réserver à une autre date";
                                    
                    }
                    else
                    {
                         

                        $req_update= "UPDATE `reservations` SET `debut`= '$debut',`fin`='$fin',`type`='$type',`emplacement`='$lieu',`id_utilisateur`=$id_user,`option_1`='$option_1',`option_2`= '$option_2',`option_3`='$option_3' WHERE `id` = $id_booking";
                        mysqli_query($db,$req_update);
                        header("Location:espace-admin.php");
                        
                        echo "ça marche" ;  
                        
                        
                                
                       
                    }
    
                            
                           
                }   
            }    
          




        }
   



    }
                
}
 



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier reservation</title>
</head>
<body>
    <main>
        <section>
            <p><?= $error ?></p>
            <form action="" method="POST">
                
                <label for="place">Lieu</label>
                <select name="place_choice" id="place">
                    <option value="">Choissisez votre emplacement</option>

                    <option value="La plage" <?php if($emplacement_booked
                    == "La plage"){echo "selected";} ?>>La PLAGE</option>

                    <option value="Les pins" <?php if($emplacement_booked
                    == "Les pins"){echo "selected";} ?>>Les PINS</option>

                    <option value="Le Maquis" <?php if($emplacement_booked
                    == "Le Maquis"){echo "selected";} ?>>Le MAQUIS</option>
                </select>

                <label for="type">Type</label>
                <select name="type" id="type">
                    <option value="">Type:</option>
                    <option value="1" <?php if($type_booked
                    == 1){echo "selected";} ?>>Tente</option>
                    <option value="2" <?php if($type_booked
                    == 2){echo "selected";} ?>>Camping-Car</option> 
                </select>

                <label for="debut">Date de début</label>
                <input type="date" name="date_debut" value= "<?= $debut_booked?>" id="debut">
                <label for="fin">Date de fin</label>
                <input type="date" name="date_fin" value= "<?= $fin_booked?>" id="fin">
                <label for="options">Options</label>
                <label for="borne">Borne électrique 2€</label>
                <input type=checkbox name="option_choice[]" id="borne" value="borne"
                <?php if($option_1_booked == "borne" || $option_2_booked =="borne" || $option_3_booked =="borne"){echo "checked";} ?>>
                <label for="disco">Disco-club: Les girelles dansantes 17€</label>
                <input type=checkbox id="disco" name="option_choice[]" value="disco"
                <?php if($option_1_booked == "disco" || $option_2_booked =="disco" || $option_3_booked =="disco"){echo "checked";} ?>>
                <label for="pack">Pack activité 30€</label>
                <input type=checkbox id="pack" name="option_choice[]" value="pack" 
                <?php if($option_1_booked == "pack" || $option_2_booked =="pack" || $option_3_booked =="pack"){echo "checked";} ?>> 
            
                <button type="submit" name="validate">Valider</button>




            </form>
            <a href="espace-admin.php">RETOUR</a>


        </section>



    </main>
    
</body>
</html>