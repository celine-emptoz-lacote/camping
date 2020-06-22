<?php
session_start();
if(!isset($_SESSION['id'])){
    header('Location:connexion.php?access_denied');
}
$id_session=$_SESSION["id"];

date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d H:i:s');
$what_day= date('w', strtotime($date));

$db= mysqli_connect("localhost","root","","reservationsalles");
$error=null;

if(isset($_POST["send"])){
     $titre= htmlspecialchars($_POST["titre"]);
     $description= htmlspecialchars($_POST["description"]);
     $debut= htmlspecialchars($_POST["date_debut"])." ". htmlspecialchars($_POST["heure_debut"]);
     
     $fin= htmlspecialchars($_POST["date_debut"])." ". htmlspecialchars($_POST["heure_fin"]) ;
    
    
     
    
    if(!empty($titre) && !empty($description) && !empty($debut) && 
     !empty($fin) )
    {
        $req_event_datetime= "SELECT COUNT(*) FROM `reservations`
         WHERE (`debut` <= '$debut' AND '$debut' <=`fin`) OR (`debut`< '$fin'AND '$fin' <`fin`)";
        $query_datetime=mysqli_query($db, $req_event_datetime);
        $datetime_event=mysqli_fetch_all($query_datetime);
        $what_day_debut= date('w', strtotime($debut));
        $what_day_fin= date('w', strtotime($fin));

        if($datetime_event[0][0] != 0){
            $error= "Vous ne pouvez pas réserver à cette date";
        }
        elseif($debut < $date){
            $error= "Vous ne pouvez pas réserver à une date antérieure";
        }
        elseif($what_day_debut == 6 || $what_day_debut== 0 ){
            $error= "Vous ne pouvez pas réserver pendant le week-end";
        }
        elseif($_POST['heure_debut']== $_POST['heure_fin']){
            $error="Veuillez renseigner une heure de fin valide";
        }
        else{
            $req="INSERT INTO `reservations`( `titre`, `description`, `debut`, `fin`, `id_utilisateurs`) VALUES ('$titre','$description','$debut','$fin','$id_session')";
                 mysqli_query($db, $req);
                 header("Location:planning.php");
        }
     }
     else{
         $error="Veuillez remplir tous les champs";
     }
     
              
}     
       
      
           
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire de réservation</title>
</head>
<body>
    <header><?php include("header.php");?></header>

    <main class="main_booking">

        <h1>Formulaire de réservation</h1>

        <?php if($error):?>
        <div class=error>
            
            <?= $error?>
           
        </div>
        <?php endif?>

        <section class=booking_form>
            <form action="" method="post">
                
                    <div class="title">
                        <input type="text" name="titre" placeholder="Titre de l'événement">
                    </div>
                    
                <div class="big_container">
                    <div class="datetime">
                        <div class="date">
                            <label for="date_debut">Date de début</label>
                            <input type="date" name="date_debut" id="debut" value=<?=$date?>>
                        </div> 
                                
                                <div class="label">
                                    <label>Heure de début</label>
                                    <input type="time" name="heure_debut" id="heure_debut" value="09:00" min="09:00" max="19:00" step="3600">
                                </div>

                                <div class="label">
                                    <label>Heure de fin</label>
                                    <input type="time" name="heure_fin" id="heure_fin" value="19:00" min="09:00" max="19:00" step="3600">
                                </div>
                    </div> 
                       

                    <div class="description">
                            <textarea name="description" placeholder="Description de l'événement"></textarea>
                    </div>
               </div> 
                <button type="submit" name="send">Valider</button>
            </form>
    </main>
    <footer><?php include("footer.php");?></footer>
    
</body>
</html>