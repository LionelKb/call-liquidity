<?php
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: formulaire_offre.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-saving']))
{
	$ref = mysqli_real_escape_string($connect,$_POST['ref']);
	$intervent = mysqli_real_escape_string($connect,$_POST['intervent']);
	$op = mysqli_real_escape_string($connect,$_POST['op']);
	$date = mysqli_real_escape_string($connect,$_POST['dateh']);
	$duree = mysqli_real_escape_string($connect,$_POST['duree']);
	
	if(mysqli_query($connect,"INSERT INTO history_offers(ref,intervention_amount,op,date_history,duree) VALUES('$ref','$intervent','$op','$date','$duree'"))
	{
		?>
        <script>alert(' Appel d\'offres enregistré ');</script>
        <?php
	}
	else
	{
		?>
        <script>alert('error while registering you...');</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CALL FOR LIQUIDITY</title>
<link rel="stylesheet" href="style3.css" type="text/css" />
</head>
    <div class= "header">
    	<div id= "left">
    		<label>Résultats d'adjudication</label>
    	</div>
</div>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="ref" placeholder="N° de référence" required /></td>
</tr>
<tr>
<td><input type="number" name="intervent" placeholder="Montant de l'intervention" required min="0"/></td>
</tr>
<tr>
<td><label for operation><select name="op"><option value="1">Apport de liquidité</option>
		                                   <option value="2">Reprise de liquidité</option>
	                                       </select></label></td>
</tr>
<tr>
<td><input type="date" name="dateh" required /></td>
</tr>
<tr>
<td><input type="number" name="duree" placeholder="Durée" required min="0" max="14"/></td>
</tr>
<tr>
<td><button type="submit" name="btn-saving">ENREGISTRER</button></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>