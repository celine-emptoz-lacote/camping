<?php
session_start();
$db= mysqli_connect("localhost","root","","camping");
date_default_timezone_set('Europe/Paris');
$date=date('Y-m-d');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning</title>
</head>
<body>
    <main>
        <table>
        <thead>
                    <tr>
                        
                        <th>&nbsp;</th>
                        <?php
                        $monday_this_week = date("Y-m-d",strtotime('monday this week'));
                        for($i=0;$i<=6;$i++): ?>

                        <?php $date = date('d-M-Y', strtotime("+$i days", strtotime($monday_this_week)));
                        $day=date('l', strtotime($date));
                        
                        $fr_days= strftime('%a', strtotime($date));
                        $fr_date= strftime('%d-%b-%G', strtotime($date));
                        ?>
                        
                        <th>

                        <?php echo  $fr_days . " " . $fr_date ; ?>
                    
                        </th> 
                        <?php endfor ?>
                    </tr>
                <thead>
                <tbody>
                    <?php for($i=1; $i<=4; $i++):?>
                        <tr>
                            <td></td>

                        </tr>
                </tbody>
        </table>
    </main>
    
</body>
</html>