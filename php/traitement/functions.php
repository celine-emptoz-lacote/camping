<?php 

function option ($data){
    if (isset($_POST[$data])) {
        $option = $_POST[$data];
    }
    else {
    $option= NULL;
    
    } 
    return  $option;
}

function insertion ($bd,$debut,$fin,$type,$emplacement,$id,$option1,$option2,$option3) {
    $requete_inser = "INSERT INTO `reservations`( `debut`, `fin`, `type`, `emplacement`, `id_utilisateur`, `option_1`, `option_2`, `option_3`) VALUES ('$debut','$fin',$type,'$emplacement',$id,'$option1','$option2','$option3')";
    $query_inser = mysqli_query($bd,$requete_inser);
}


/** CALENDAR **/
function getAll($year){
    $r = array();
    $date = strtotime($year."-01-01");

    while (date('Y',$date) <= $year){
    $y = date('Y',$date);
    $m = date('n',$date);
    $d = date('j',$date);
    $w = str_replace('0','7',date('w',$date));


    $r[$y][$m][$d] = $w;
    
    $date = strtotime(date('Y-m-d',$date).' +1 DAY');
    }

    return $r;
 }

 