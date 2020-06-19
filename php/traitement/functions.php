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