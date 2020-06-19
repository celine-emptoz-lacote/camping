<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php $monday_week = strtotime('Monday this week'); ?>

<table>
    <thead>
        <tr>
            <td>Lundi</td>
            <td>Mardi</td>
            <td>Mercredi</td>
            <td>Jeudi</td>
            <td>Vendredi</td>
            <td>Samedi</td>
            <td>Dimanche</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php for($i = 0 ; $i < 7 ; $i++) :?>
            <td><a href='planning.php?jour=<?php  echo date("Y-m-d" , strtotime("+ ".$i." days",$monday_week)) ;?>' ><?php echo date("d m Y" , strtotime('+ '.$i.' days',$monday_week)) ;?></a></td>
            <?php endfor ;?>
        </tr>
    </tbody>
</table>

<?php if (isset($_GET['jour'])) {

    $jour = $_GET['jour'];

    $bd = mysqli_connect("localhost","root","","camping");

    $requete ="SELECT emplacement,`type`,debut ,fin  FROM `reservations` WHERE debut = '$jour' ";
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
                        <td>Reserver</td>
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