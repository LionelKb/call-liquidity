<?php
    session_start();
    include_once "dbconnect.php";
    $id_history = $_SESSION['history'];
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset = "utf-8"/>
    	<link rel="stylesheet" href="style1.css" type="text/css" />
    	<link rel="stylesheet" href="style2.css" type="text/css" />
        <link rel="stylesheet" href="style3.css" type="text/css" />
    	<title>Résultats d'adjudication-CFL</title>
    </head>
    <body>
    	<div class= "header">
    		<div id= "left">
    			<label>Appels d'offres N°<?php echo $id_history ?></label>
    		</div>
            <div id="right">
                <div id="content">
                    <a href="logout.php?logout">Acceuil</a>
                </div>
            </div>
    	</div>
        <center>
    	<div class= "title">
    	<div class="note">
            <p>
                Les banques soumissionnaires à l'appel d'offres n°<strong><?php echo $id_history ?></strong> sont:
            </p>
            <?php
            $get_banks_offering = mysqli_query($connect, "select distinct banks.id, banks.name as name from offers INNER JOIN banks 
                on offers.id_bank = banks.id WHERE id_history = $id_history order by banks.name");
            $winners = array();
            while($data = mysqli_fetch_array($get_banks_offering))
            { 
                echo $data['name']. ' : '.$data['id'];
                echo '</br>';
            }
            ?>
            <form action ="details.php" method="post">
            <tr>
            <td><input type="number" name="winner" id="call" placeholder="Code de la banque" required /></td>
            </tr>
            <button class="work" type="submit">VOIR</button></td>
            </form>
    	</div>
    </div>
    <center>
    </body>
</html>