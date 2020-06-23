<?php
session_start();
$db= mysqli_connect("localhost","root","","camping");
$id_user=$_SESSION['id'];
$req="SELECT * FROM reservations WHERE id_utilisateur=$id_user";
$query= mysqli_query($db, $req);
$result= mysqli_fetch_all($query, MYSQLI_ASSOC);


 $req_prices="SELECT * FROM tarifs";
 $query2=mysqli_query($db, $req_prices);
 $result2=mysqli_fetch_all($query2, MYSQLI_ASSOC);

 var_dump($result);

 

 for($i=0; $i<=count($result); $i++){

    $nb_days= (strtotime($result[$i]['fin']) - strtotime($result[$i]['debut'])) / 86400 +1;
    $prix_emplacement=$result2[2]['prix'];
    $nb_emplacement=$result[$i]['type'];
    
    if($result[$i]['option_1'] == "borne" || $result[$i]['option_2'] == "borne" || $result[$i]['option_3'] == "borne"){
       $prix_borne= $result2[0]['prix'];
    }
    else{
        $prix_borne=0;
    }
    if($result[$i]['option_1'] == "disco" || $result[$i]['option_2'] == "disco" || $result[$i]['option_3'] == "disco"){
       $prix_disco= $result2[1]['prix'];
    }
    else{
        $prix_disco=0;
    }
    if($result[$i]['option_1'] == "pack" || $result[$i]['option_2'] == "pack" || $result[$i]['option_3'] == "pack"){
       $prix_pack= $result2[3]['prix'];
    }
    else{
        $prix_pack=0;
    }

    $total= ($prix_borne * $nb_days + $prix_disco * $nb_days + $prix_pack * $nb_days) + ($nb_emplacement*$prix_emplacement)*$nb_days;
   
    echo $total ."<br />";
    
 }

?>