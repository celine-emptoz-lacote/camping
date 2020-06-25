<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location:index.php");
}


$db= mysqli_connect("localhost","root","","camping");
// REQUETE DATA TARIF
$req_table="SELECT * FROM `tarifs`";
$query_table= mysqli_query($db, $req_table);
$table_prices=mysqli_fetch_all($query_table);

// END DATA TARIF

// REQUETE DATA RESERVATIONS
$req_data_booking="SELECT * FROM reservations";
$query_data_booking=mysqli_query($db, $req_data_booking);
$data_booking=mysqli_fetch_all($query_data_booking, MYSQLI_ASSOC);


//END DATA RESERVATION

//REQUETE UPDATE PRIX
 if(isset($_POST["submit_price"])){

    $new_price=intval($_POST['new_price']);
    $id=intval($_GET['id']);

    $req_update_prices="UPDATE `tarifs` SET `prix`= $new_price WHERE id=$id";
    mysqli_query($db, $req_update_prices);
    header("Location:espace-admin.php");
    
}
//END REQUETE

//REQUETE DELETE RESERVATION

if(isset($_GET['id_booking'])){

    $id=intval($_GET['id_booking']);

    $req_delete_booking="DELETE FROM `reservations` WHERE `id`= $id ";
    mysqli_query($db, $req_delete_booking);
    header("Location:espace-admin.php");
    
}
//END REQUETE RESERVATION


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="font/fontello/css/fontello.css">

    <title>Espace-administrateur</title>
</head>
<body>
<header><?php include("php/include/header.php");?></header>
<main class="main_admin">
    <h1 id="title_admin">Espace administrateur</h1>
    <?php if(isset($_SESSION['success'])):?>
        <p class="success"><?= $_SESSION['success']?></p>
    <?php endif ?>

    <h1>Les tarifs</h1>
    <section>
        <form action="" method="POST">
        <?php if(!isset($_GET['id'])):?>
            <table class="table_prices">
                <thead>
                <tr>
                <th>NOM</th>
                <th>PRIX</th>
                <th>MODIFIER</th>
                
                
                </tr>
                
                </thead>
                <tbody>
                <?php for($i=1; $i<=count($table_prices); $i++ ){

                    $req_prices="SELECT * FROM `tarifs` WHERE id=$i";
                    $query_prices=mysqli_query($db, $req_prices);
                    $prices=mysqli_fetch_all($query_prices, MYSQLI_ASSOC);
                    ?>
                    <tr>
                        <td class="option_name"><?= $prices[0]['nom']?></td>

                        <?php if(!isset($_GET['id'])):?>

                        <td> <?=$prices[0]['prix']?>€</td>
                        <td><a href="espace-admin.php?id=<?php echo $i?>" class="link_to"></a></td>
                    
                        <?php endif ?>
                        
                    </tr>

                <?php }?>
        
                </tbody>
            
            </table>
            <?php endif ?>

            <?php if(isset($_GET['id'])):?>
            <?php $id=$_GET['id'];
            $req_prices="SELECT * FROM `tarifs` WHERE id=$id";
            $query_prices=mysqli_query($db, $req_prices);
            $prices=mysqli_fetch_all($query_prices, MYSQLI_ASSOC);
            ?>
            <div class="change_price">
                <p>Veuillez entrer le nouveau prix pour l'option <?= $prices[0]['nom']?>:</p>
                <input type="number" name="new_price" value= <?= $prices[0]['prix']?>>
                <button type="submit" name="submit_price" class="submit_price">Valider</button>
            </div>

            <?php endif ?>

            
        </form>
    </section>
    <h1>Les réservations</h1>
    <section>
        <table class="table_booking">
            <thead>
                <tr>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Type</th>
                    <th>Emplacement</th>
                    <th>Option Borne</th>
                    <th>Option Disco</th>
                    <th>Option Pack activité</th>
                    <th>Supprimer</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0; $i<count($data_booking); $i++):?>
                    
                    <tr>
                        <td><?= strftime('%d-%m-%Y',strtotime($data_booking[$i]['debut']))?></td>
                        <td><?= strftime('%d-%m-%Y',strtotime($data_booking[$i]['fin']))?></td>

                        <td><?php if($data_booking[$i]['type']==1){
                            echo "tente";}
                            elseif($data_booking[$i]['type']==2){
                             echo "Camping-Car";}?>
                        </td>

                        <td><?= $data_booking[$i]['emplacement']?></td>
                        <td><?php if(empty($data_booking[$i]['option_1'])){
                            echo "<img src='src/img/close.png' alt='red icon'>";}
                                  else{
                                      echo "<img src='src/img/tick.png' alt='green icon'>";                                 
                                       } 
                            ?></td>
                        <td><?php if(empty($data_booking[$i]['option_2'])){
                            echo "<img src='src/img/close.png' alt='red icon'>";}
                                  else{
                                      echo "<img src='src/img/tick.png' alt='green icon'>";                                 
                                       } 
                            ?></td>
                        <td><?php if(empty($data_booking[$i]['option_3'])){
                            echo "<img src='src/img/close.png' alt='red icon'>";}
                                  else{
                                      echo "<img src='src/img/tick.png' alt='green icon'>";                                 
                                       } 
                            ?></td>
                        <td><a href="espace-admin.php?id_booking=<?=$data_booking[$i]['id']?>" class="delete"></a></td>
                        <td><a href="change-reservation.php?id_booking=<?=$data_booking[$i]['id']?>" class="link_to"></a></td>
                        
                        
                    </tr>
                <?php endfor?>
            </tbody>
        </table>


    </section>

</main>

    
</body>
</html>
<?php unset($_SESSION['success'])?>