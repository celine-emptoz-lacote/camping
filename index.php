<?php 
session_start();
$bd = mysqli_connect("localhost","root","","camping");

$requete = "SELECT * FROM tarifs";
$query = mysqli_query($bd,$requete);
$resultat = mysqli_fetch_all($query,MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="font/fontello/css/fontello.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><?php include 'php/include/header.php'?></header>
    <main class="index_main">
        <section>
            <h2 class="index_h2">Nos emplacements</h2>
            <div class="emplacement">
                <div>
                    <img src="src/img/lieux1.jpg" alt="">
                    <h3>Le Maquis</h3>
                    <p>Plantez votre tente dans un bel espace délimité, de minimum 70 m² </p>
                </div>
                <div>
                    <img src="src/img/lieux2.jpg" alt="">
                    <h3>La Plage</h3>
                    <p>Profiter de la vie en pleine nature et en toute liberté.</p>
                </div>
                <div>
                    <img src="src/img/lieux3.jpg" alt="">
                    <h3>La Pins</h3>
                    <p>Emplacement de camping dans un écrin de verdure où calme et sérénité prédominent. Un havre de paix, un parenthèse verte !</p>
                </div>
            </div>
        </section>
        <section >
            <h2 class="index_h2">Nos Options</h2>
            
            
            <div class="option_flex">    
                <img src="src/img/electricite.png" alt="Borne electrique">
                <div>
                    <h3>Borne electrique</h3> 
                    <p>Accès à la borne électrique</p>
                </div>
                <p>Tarif : <?= $resultat[0]['prix'] ?> euros / jour </p> 
            </div> 
            <div class="option_flex">
                        
                <img src="src/img/d.png" alt="disco club">
                <div>
                    <h3>Disco Club</h3>          
                    <p>Acces à la discotèque</p>
                </div>
                <p>Tarif : <?= $resultat[1]['prix'] ?> euros / jour</p>
            </div>   

            <div class="option_flex">            
                <img src="src/img/pack.png" alt="pack d'activités">
                <div>
                    <h3>Pack d'activités</h3>
                    <p>Ce pack d'activités comprends :
                     Un cours de Yoga , Un tournois de Fresbee ,Une heure de ski nautique </p>
                </div>  
                <p>Tarif : <?= $resultat[2]['prix'] ?> euros / jour</p>           
            </div> 
        </section>
        <section>
            <h2 class="index_h2">Pourquoi choisir notre camping ?</h2>
            <div class="index_div_choix">
                <div>
                    <img src="src/img/ampoule.png" alt="ampoule">
                    <h3 class="index_div_h3">Une approche novatrice</h3>
                    <hr>
                    <p>A travers des hébergements innovants, pour un bien être à l’intérieur de chez soi, comme à l’extérieur</p>
                </div>
                <div>
                    <img src="src/img/plante.png" alt="Plante">
                    <h3 class="index_div_h3">Approche écologique</h3>
                    <hr>
                    <p>Dans le fonctionnement du camping, mais aussi dans le déroulement des vacances</p>
                </div>
                <div>
                    <img src="src/img/tonges.png" alt="Tonges">
                    <h3 class="index_div_h3">Lieu convivial</h3>
                    <hr>
                    <p>Une ambiance familiale et convivial</p>
                </div>
            </div>
        </section>
        <section class="index_section_payement">
            <div>
                <img src="src/img/picto1.png" alt="">
                <p>Paiement en 1, 2 ou 4 fois sans frais</p>
            </div>
            <div>
                <img src="src/img/picto2.png" alt="">
                <p>Garantie annulation</p>
            </div>
            <div>
                <img src="src/img/picto3.png" alt="">
                <p>Site et paiement sécurisés</p>
            </div>
            <div>
                <img src="src/img/picto4.png" alt="">
                <p>CB, ANCV, Chèque & Virement</p>
            </div>
        </section>
    </main>
    <footer><?php include 'php/include/footer.php' ?></footer>
</body>
</html>