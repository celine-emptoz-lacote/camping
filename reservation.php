<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="php/traitement/formulaire_reservation.php" method="POST">
    <?php if (isset($_SESSION['erreur_resa'])) { echo "<p>".$_SESSION['erreur_resa']."</p>";} ?>
    <?php if (isset($_SESSION['erreur_date_debut'])) { echo "<p>".$_SESSION['erreur_date_debut']."</p>";} ?>
    <label for="date_debut">Date de debut :</label>
    <input type="date" id="date_debut" name="date_debut">

    <?php if(isset($_SESSION['erreur_date_fin'])) {echo "<p>".$_SESSION['erreur_date_fin']."</p>" ;} ?>
    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin">

    <label for="emplacement">Choisir l'emplacement :</label>

    <?php if(isset($_SESSION['erreur_type'])) { echo "<p>".$_SESSION['erreur_type']."</p>" ;} ?>
    <select name="emplacement" id="emplacement">
        <option value="">Choissir un emplacement</option>
        <option value="La Plage">La Plage</option>
        <option value="Les Pins">Les Pins</option>
        <option value="Le Maquis">Le Maquis</option>
    </select>

    <label for="emplacement">Choisir l'emplacement :</label>
    <?php if(isset($_SESSION['erreur_emplacement'])) { echo "<p>".$_SESSION['erreur_emplacement']."</p>"; } ?>
    <select name="type" id="type">
        <option value="">Choissir un type </option>
        <option value="1">Tente</option>
        <option value="2">Camping cars</option>
    </select>

    <p>Options :</p>
    <input type="checkbox" id="borne_electrique" name="options1" value="borne_electrique">
    <label for="borne_electrique" >Borne électrique</label>

    <input type="checkbox" id="disco-club" name="options2" value="disco_club">
    <label for="disco-club" >Disco club</label>

    <input type="checkbox" id="pack" name="options3" value="pack">
    <label for="pack" >Pack</label>

    

    <input type="submit" name="submit">





</form>

</body>
</html>

<?php unset($_SESSION['erreur_date_debut'],$_SESSION['erreur_date_fin'],$_SESSION['erreur_type'],$_SESSION['erreur_emplacement']); ?>