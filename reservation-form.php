<?php
require("php/traitement/reservation-form.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="font/fontello/css/fontello.css">

    <title>Document</title>
</head>
<body>

<header><?php include("php/include/header.php");?></header>

    <main class="main_reservation_form">
        <section class="container_reservation">
            <div class="div_booking">
                <h1>Formulaire</h1>
                <?php if(isset($_SESSION['error'])):?>
                <p class="error"><?= $_SESSION['error'] ?></p>
                <?php endif ?>
                <form action="php/traitement/reservation-form.php" method="post">
    
                   <select name="place_choice" id="place">
                        <option value="">Choisissez votre emplacement</option>
                        <option value="La plage">La PLAGE</option>
                        <option value="Les pins">Les PINS</option>
                        <option value="Le Maquis">Le MAQUIS</option>
                    </select>
                    
                    <select name="type" id="type">
                        <option value="">Type:</option>
                        <option value="1">Tente</option>
                        <option value="2">Camping-Car</option> 
                    </select>
                    
                    <div class="dates">
                        <div class="date_form">
                            <label for="debut">Date de début</label>
                            <input type="date" name="date_debut" id="debut">
                        </div>
                        <div class="date_form">
                            <label for="fin">Date de fin</label>
                            <input type="date" name="date_fin" id="fin">
                        </div>
                    </div>
                    
                        <div class="option_choice">
                            <label for="options">Choissisez vos options:</label>
                        </div>
                        <div class="all_options">
                            <div>
                                <label for="borne">Borne électrique 2€</label>
                                <input type=checkbox name="option_choice[]" id="borne" value="borne">
                            </div>
                            <div>
                                <label for="disco">Disco-club 17€</label>
                                <input type=checkbox id="disco" name="option_choice[]" value="disco">
                            </div>
                            <div>
                                <label for="pack">Pack activité 30€</label>
                                <input type=checkbox id="pack" name="option_choice[]" value="pack">
                            </div>
                            
                        </div>
                    
                
                    <button type="submit" name="validate">Valider</button>


                </form>

            </div>
            <div class="div_text">
                <h1>Réserver maintenant</h1>
                <p>Vérifiez nos disponibilités et n'attendez pas pour réserver votre séjour au camping Les Happy Sardines !</p>
            </div>
        </section>
    </main>
    
    <footer><?php include("php/include/footer.php");?></footer>
    
</body>
</html>
<?php
unset($_SESSION['error']); 
 
?>