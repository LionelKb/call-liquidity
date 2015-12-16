<?php
    session_start();
    include_once 'dbconnect.php';

    if(isset($_POST['btn-save']))
    {
    	$id = mysqli_real_escape_string($connect, $_POST['ref']);
    	$res=mysqli_query($connect, "select * FROM history_offers WHERE id='$id'");
    	$row=mysqli_fetch_array($res);
    	$_SESSION['history'] = $row['id'];
    	header("Location: analysis.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset = "utf-8"/>
    	<link rel="stylesheet" href="style1.css" type="text/css" />
    	<link rel="stylesheet" href="style2.css" type="text/css" />
        <link rel="stylesheet" href="style3.css" type="text/css" />
    	<title>CALL FOR LIQUIDITY</title>
    </head>
    <body id="bg_pub">
    	<div class= "header">
    		<div id= "left">
    			<label>Liste des offres</label>
    		</div>
            <div id="right">
                <div id="content">
                    <a href="logout.php?logout">Acceuil</a>
                </div>
            </div>
    	</div>
        <div class="public">
        	<?php
        	    $sql = mysqli_query($connect,"select id, date_format(dateh,'%e/%c/%Y') from history_offers");
        	    $i = 0;
        	    $tab = array();
        	    while($data = mysqli_fetch_array($sql))
        	    {
        	    	$tab = $data['id'];
                    $date = $data[1];
        	    	echo 'Appel d\'offre n° '.$data['id']. ' du ' .$date. " </br>";
        	    	echo '</br>';
        	    }
        	?>
        	<form method="post">
        	<tr>
        	<td><input type="number" name="ref" id="call" placeholder="N° de référence" required /></td>
            </tr>
        	<button class="work" type="submit" name="btn-save">VOIR</button></td>
        </form>
        </div>
	</body>
</html>