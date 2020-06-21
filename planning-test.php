<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>






<?php 
session_start();
$mois = date("m");

if (!isset($_SESSION['numero_mois'])) {
    $_SESSION['numero_mois'] = intval($mois);
}


if (isset($_POST['next'])){
    $_SESSION['numero_mois'] += 1;
}

if (isset($_POST['previous'])){
    $_SESSION['numero_mois'] -= 1;
}
var_dump($_SESSION) ;

$premier_jour_mois = mktime (0,0,0,$_SESSION['numero_mois'],1,date("Y")); 

$nombre_jours_mois = cal_days_in_month ( CAL_JULIAN, $_SESSION['numero_mois'], 2020) ;






?>

<?php $mois = date('Y-m-d',strtotime('+'.$_SESSION['numero_mois'].' month'));
$mois_en_cours = mktime(0, 0, 0,($_SESSION['numero_mois'] + 1), 0, date("Y"));  

?>

<form action="planning-test.php" method="POST">
    <input type="submit" value ="< récédant" name ="previous">

    <?php echo "<h1>".date('F Y', $mois_en_cours)."</h1>";?>
    <input type="submit" value ="Suivant >" name ="next">
    

</form>




            <?php for($i = 0 ; $i < $nombre_jours_mois ; $i++) :?>
            <div style="display: inline-block;width:5%">
                <a href='planning-test.php?jour=<?php  echo date("Y-m-d" , strtotime("+ ".$i." days",$premier_jour_mois)) ;?>' ><?php echo date("d M " , strtotime('+ '.$i.' days',$premier_jour_mois)) ;?></a>
            </div>
            <?php endfor ;?>
        
  

<?php if (isset($_GET['jour'])) {

    $jour = $_GET['jour'];

    $bd = mysqli_connect("localhost","root","","camping");

    $requete ="SELECT emplacement,`type`,debut ,fin  FROM `reservations` WHERE  `debut` <= '$jour' AND '$jour' <=`fin` ";
    $query = mysqli_query($bd,$requete);
    $resultat = mysqli_fetch_all($query,MYSQLI_ASSOC);

  

    $capacite_plage = 0;
    $capacite_pins = 0;
    $capacite_maquis = 0;

    foreach($resultat as $cles){
        if ($cles['emplacement'] == "La Plage"){
            if ($cles['type'] == '1' ) {
                $capacite_plage = $capacite_plage + 1;
            }
            elseif($cles['type'] == '2') {
                $capacite_plage += 2;
            }
        }


        if ($cles['emplacement'] == "Le Maquis"){
            if ($cles['type'] == '1' ) {
                $capacite_maquis += 1;
            }
            elseif($cles['type'] == '2') {
                $capacite_maquis += 2;
            }
        }

        if( $cles['emplacement'] == "Les Pins"){
            if ($cles['type'] == '1') {
                $capacite_pins = $capacite_pins + 1 ;
            }
            if ($cles['type'] == '2') {
                $capacite_pins = $capacite_pins + 2 ;
            }
        }

        
    }

    $capacite = [$capacite_plage,$capacite_pins,$capacite_maquis];

} 


?>

<table>
    <thead>
        <tr>
            <td></td>
            <td>La Plage</td>
            <td>Les Pins</td>
            <td>Le Maquis</td>
        </tr>
    </thead>
    <tbody>
        <?php for ($i = 1 ; $i < 5 ; $i++) :?>
            <tr>
                <td><?php echo "Emplacement ".$i ?></td>
                <?php for ($lieu = 0 ; $lieu < 3 ; $lieu++) :?>
                    <?php if (!empty($resultat) && $capacite[$lieu] >= $i ) :?>
                        <td style="background-color:grey">Reserver</td>
                    <?php else :?>
                        <td><a href="reservation.php">Disponible</a></td>
                    <?php endif ;?>
                <?php endfor;?>
            </tr>
        <?php endfor ;?>
    </tbody>
</table>


    

</body>
</html>