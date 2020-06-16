<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="php/traitement/formulaire_reservation.php" method="POST">

    <label for="date_debut">Date de debut :</label>
    <input type="date" id="date_debut" name="date_debut">

    <label for="date_fin">Date de fin :</label>
    <input type="date" id="date_fin" name="date_fin">

    <label for="emplacement">Choisir l'emplacement :</label>

    <select name="emplacement" id="emplacement">
        <option value="">Choissir un emplacement</option>
        <option value="La Plage">La Plage</option>
        <option value="Les Pins">Les Pins</option>
        <option value="Le Maquis">Le Maquis</option>
    </select>

    <label for="emplacement">Choisir l'emplacement :</label>
    <select name="type" id="type">
        <option value="">Choissir un type </option>
        <option value="tente">Tente</option>
        <option value="camping cars">Camping cars</option>
    </select>

    <p>Options :</p>
    <input type="checkbox" id="borne_electrique" name="borne_electrique" value="1">
    <label for="borne_electrique" >Borne électrique</label>

    <input type="checkbox" id="disco-club" name="disco-club" value="2">
    <label for="disco-club" >Disco club</label>

    <input type="checkbox" id="pack" name="pack" value="3">
    <label for="pack" >Pack</label>

    

    <input type="submit" name="submit">





</form>

</body>
</html>