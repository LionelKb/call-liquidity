<?php
    include "dbconnect.php";
    $id_history = 1;

    if(isset($_POST['btn-details']))
    {
        $win = mysqli_real_escape_string($connect, $_POST['$win']);
        $get_banks_offering = mysqli_query($connect, "select distinct banks.name as bank_name from offers INNER JOIN banks 
            on offers.id_bank = banks.id WHERE id_history = $id_history order by banks.name");
        $row=mysqli_fetch_array($get_banks_offering);
    
        if($row['bank_name']== $win)
        {
            $_SESSION['winner'] = $row['bank_name'];
            header("Location: details.php");
        }
        else
        {
            ?>
            <script>alert('matricule et/ou mot de passe incorrect(s)');</script>
            <?php
        }
    }
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
    	</div>
        <center>
    	<div class= "title">
    	<div class="note">
            <p>
                Les banques soumissionnaires à l'appel d'offres n°<strong><?php echo $id_history ?></strong> sont:
            </p>
            <?php
            $get_banks_offering = mysqli_query($connect, "select distinct banks.name from offers INNER JOIN banks 
                on offers.id_bank = banks.id WHERE id_history = $id_history order by banks.name");
            $winners = array();
            while($data = mysqli_fetch_array($get_banks_offering))
            {
                $winners = $data['name'];
                $win = $data['name'];
                echo "<table><tr>";
                echo "<td><button type=submit name=btn-details>";
                echo $win = $data['name'];
                echo "</button></td>";
                echo "</tr></table>";
            }
            print_r($winners);
            ?>
    	</div>
    </div>
    <center>
    </body>
</html>