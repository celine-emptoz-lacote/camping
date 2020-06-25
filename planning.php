<?php  session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
    <link rel="stylesheet" href="font/fontello/css/fontello.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><?php include 'php/include/header.php'?></header>
    <main class="main_planning"> 

    <?php 

    require 'php/traitement/functions.php';

    if (!isset($_SESSION['numero_mois'])) {
        $_SESSION['numero_mois'] = intval(date("m"));
    }

    if (isset($_POST['next'])){
        $_SESSION['numero_mois'] += 1;
    }

    if (isset($_POST['previous'])){
        $_SESSION['numero_mois'] -= 1;
    }

    $mois = date("m");
    $premier_jour_mois = mktime (0,0,0,$_SESSION['numero_mois'],1,date("Y")); 
    $nombre_jours_mois = cal_days_in_month ( CAL_JULIAN, $_SESSION['numero_mois'], 2020) ;
    ?>

    <?php $mois = date('Y-m-d',strtotime('+'.$_SESSION['numero_mois'].' month'));
    $mois_en_cours = mktime(0, 0, 0,($_SESSION['numero_mois'] +1 ), 0, date("Y"));  
    ?>

    <section class="planning">
        <form class="form_planning" action="planning.php" method="POST">
            <input type="submit" value ="< Précédant" name ="previous">
        </form>

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
            if ($cles['emplacement'] == "La plage"){
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

            if( $cles['emplacement'] == "Les pins"){
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

        <?php $days = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
        $months = array ('Janvier','Fevirer','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
        $year = date('Y');

        $dates = getAll($year);

        ?>

            <?php $dates = current($dates);?>
                <div class="div_planning">
                <?php foreach ($dates as $m => $mois) :?>
                
                <?php  $mois_en_cours = date("m",mktime(0, 0, 0,($_SESSION['numero_mois'] + 1), 0, date("Y"))); ?>
                <?php if ($m == $mois_en_cours ) :?>
                    <div><?php echo "<h2>".$months[$m-1]."</h2>" ;?></div>
                    <table class="table_planning">
                        <thead>
                            <tr>
                                <?php foreach ($days as $d=>$value) :?>
                                    <th><?=  $value ?></th>
                                <?php endforeach ;?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <?php 
                                foreach ($dates[$m] as $d=>$w) :?>
                                
                                <?php $time = strtotime("$year-$m-$d") ;?>
                                
                                    <?php if (  $d == 1 && $d != $w ) :?>
                                        <td colspan="<?php echo $w-1 ;?>"></td>
                                    <?php endif; ?>
                                    

                                    <td ><a class="lien-planning" href='planning.php?jour=<?php  echo date("Y-m-d" , strtotime("+ ".( $d - 1 ). " days",$premier_jour_mois)) ;?>' ><?php echo $d; ?></a></td>
        
                                    
                                <?php if ( $w == 7) :?> 
                                </tr>
                                <tr>
                                <?php endif ;?>
                                
                            <?php endforeach ;?>
                        
                        </tbody>
                    </table>
                    
                <?php endif ;?>
            
                <?php endforeach ;?>
                </div>
                <form class="form_planning" action="planning.php" method="POST">
            
            <input type="submit" value ="Suivant >" name ="next">

        </form>

    </section>
    <?php if (isset($_GET['jour'])) :?>
        <section class="section_planning_reservation">
        
    
            <h2><?= date ("d-m-Y",strtotime($_GET['jour'])) ?></h2>
            <table class="table_planning_reservation">
                <thead>
                    <tr>
                        <th></th>
                        <th>La Plage</th>
                        <th>Les Pins</th>
                        <th>Le Maquis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1 ; $i < 5 ; $i++) :?>
                        <tr>
                            <td><?php echo "Emplacement ".$i ?></td>
                            <?php for ($lieu = 0 ; $lieu < 3 ; $lieu++) :?>
                                <?php if (!empty($resultat) && $capacite[$lieu] >= $i ) :?>
                                    <td class="nondispo" >Reservé</td>
                                <?php else :?>
                                    <?php if (isset($jour)) :?>
                                    
                                        <td class="dispo"><a class="lien_resa"href="reservation-form.php?emplacement=<?= $i ?>&lieu=<?= $lieu ?>&jour=<?= $jour ?>">Disponible</a></td>
                                    
                                    <?php endif ;?>
                                <?php endif ;?>
                            <?php endfor;?>
                        </tr>
                    <?php endfor ;?>
                </tbody>
            </table>
        <?php endif ;?>
        </section>
    </main>
    <footer><?php include 'php/include/footer.php' ?></footer>
</body>
</main>