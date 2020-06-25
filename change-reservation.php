<?php
$id_booking=$_GET['id_booking'];
require("php/traitement/change-form.php")

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="font/fontello/css/fontello.css">
    <title>Modifier reservation</title>
</head>
<body>
    <header><?php include("php/include/header.php");?></header>
    <main class="main_change_booking">
        <h1>Modification de la réservation</h1>
        <section class="change_booking">
            <?php if(isset($_SESSION['error'])):?>
            <p class="error"><?= $_SESSION['error'] ?></p>
            <?php endif ?>
            <form action="php/traitement/change-form.php?id_booking=<?=$id_booking?>" method="POST">
                
                
                <select name="place_choice" id="place">
                    <option value="">Choissisez votre emplacement</option>

                    <option value="La plage" <?php if($emplacement_booked
                    == "La plage"){echo "selected";} ?>>La PLAGE</option>

                    <option value="Les pins" <?php if($emplacement_booked
                    == "Les pins"){echo "selected";} ?>>Les PINS</option>

                    <option value="Le Maquis" <?php if($emplacement_booked
                    == "Le Maquis"){echo "selected";} ?>>Le MAQUIS</option>
                </select>

                
                <select name="type" id="type">
                    <option value="">Type:</option>
                    <option value="1" <?php if($type_booked
                    == 1){echo "selected";} ?>>Tente</option>
                    <option value="2" <?php if($type_booked
                    == 2){echo "selected";} ?>>Camping-Car</option> 
                </select>

                <div class="dates">
                    <div class="date_form">
                    <label for="debut">Date de début</label>
                    <input type="date" name="date_debut" value= "<?= $debut_booked?>" id="debut">
                    </div>
                    
                    <div class="date_form">
                    <label for="fin">Date de fin</label>
                    <input type="date" name="date_fin" value= "<?= $fin_booked?>" id="fin">
                    </div>
                </div>

                <div class="option_choice">
                    <label for="options">Options</label>
                </div>
                <div class="all_options_booking">
                    <div>
                        <label for="borne">Borne électrique 2€</label>
                        <input type=checkbox name="option_choice[]" id="borne" value="borne"
                        <?php if($option_1_booked == "borne" || $option_2_booked =="borne" || $option_3_booked =="borne"){echo "checked";} ?>>
                    </div>

                    <div>
                    <label for="disco">Disco-club: Les girelles dansantes 17€</label>
                        <input type=checkbox id="disco" name="option_choice[]" value="disco"
                        <?php if($option_1_booked == "disco" || $option_2_booked =="disco" || $option_3_booked =="disco"){echo "checked";} ?>>
                    </div>
                    <div>
                        <label for="pack">Pack activité 30€</label>
                        <input type=checkbox id="pack" name="option_choice[]" value="pack" 
                        <?php if($option_1_booked == "pack" || $option_2_booked =="pack" || $option_3_booked =="pack"){echo "checked";} ?>> 
                    </div>
                </div>
            
                <button type="submit" name="validate">Valider</button>




            </form>
            <a href="espace-admin.php" class="go_back">RETOUR</a>


        </section>



    </main>
    
    
</body>
</html>
<?php unset($_SESSION['error']);?>