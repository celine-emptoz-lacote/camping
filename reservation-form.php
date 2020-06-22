<?php
session_start();

date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d');
$error=null;

$db= mysqli_connect("localhost","root","","camping");

$id_session=intval($_SESSION["id"]);


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

    
        if($debut<$date){
                 echo $error="Vous ne pouvez pas réserver à une date antérieure"; }

        if($debut>$fin){
                 echo $error="Créneau invalide";}

        if(empty($date_event)){
            
            $req_insert="INSERT INTO `reservations`( `debut`, `fin`, `type`,  `emplacement`, `id_utilisateur`, `option_1`, `option_2`, `option_3`) 
            VALUES ('$debut','$fin',$type,'$lieu',$id_session,'$option_1','$option_2','$option_3')";
            
            var_dump($req_insert);
                   
            mysqli_query($db,$req_insert);

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
                         $req_insert="INSERT INTO `reservations`( `debut`, `fin`, `type`,  `emplacement`, `id_utilisateur`, `option_1`, `option_2`, `option_3`) 
                          VALUES ('$debut','$fin',$type,'$lieu',$id_session,'$option_1','$option_2','$option_3')";
                        
                        echo "ça marche" ;  
                         mysqli_query($db,$req_insert);
                        
                                
                       
                    }
    
                            
                           
                }
          




        }
   



    }
                
}
 
}



   


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
    <p><?= $error ?></p>
<form action="" method="post">

    <label for="place">Lieu</label>
    <select name="place_choice" id="place">
        <option value="">Choissisez votre emplacement</option>
        <option value="La plage">La PLAGE</option>
        <option value="Les pins">Les PINS</option>
        <option value="Le Maquis">Le MAQUIS</option>
    </select>

    <label for="type">Type</label>
    <select name="type" id="type">
        <option value="">Type:</option>
        <option value="1">Tente</option>
        <option value="2">Camping-Car</option> 
    </select>

    <label for="debut">Date de début</label>
    <input type="date" name="date_debut" id="debut">
    <label for="fin">Date de fin</label>
    <input type="date" name="date_fin" id="fin">
    <label for="options">Options</label>
    <label for="borne">Borne électrique 2€</label>
    <input type=checkbox name="option_choice[]" id="borne" value="borne">
    <label for="disco">Disco-club: Les girelles dansantes 17€</label>
    <input type=checkbox id="disco" name="option_choice[]" value="disco">
    <label for="pack">Pack activité 30€</label>
    <input type=checkbox id="pack" name="option_choice[]" value="pack">
 
    <button type="submit" name="validate">Valider</button>


</form>
    </main>
    
</body>
</html>