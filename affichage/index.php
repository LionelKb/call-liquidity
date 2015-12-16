<?php
session_start();
include_once 'dbconnect.php';

if(isset($_POST['btn-save']))
{
	$ref = mysqli_real_escape_string($connect,$_POST['ref']);
	$intervent = mysqli_real_escape_string($connect,$_POST['intervent']);
	$dateh = mysqli_real_escape_string($connect,$_POST['dateh']);
	$duree = mysqli_real_escape_string($connect,$_POST['duree']);
	$_SESSION['history'] = $ref;
	
	if(mysqli_query($connect,"INSERT INTO history_offers(id,int_amount,dateh,duree) VALUES($ref,'$intervent','$dateh','$duree')"))
	{
		?>
        <script>alert(' Appel d\'offres enregistré ');</script>
        <?php
        header("Location: formulaire_offre.php");
	}
	else
	{
		?>
        <script>alert('Erreur dans l\'enregistrement');</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CALL FOR LIQUIDITY</title>
<link rel="stylesheet" href="style2.css" type="text/css" />
<link rel="stylesheet" href="style3.css" type="text/css" />
</head>
</div>
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="number" name="ref" placeholder="N° de référence" required /></td>
</tr>
<tr>
<td><input type="number" name="intervent" placeholder="Montant de l'intervention" required min="0"/></td>
</tr>
<tr>
<td><input type="date" name="dateh" required /></td>
</tr>
<tr>
<td><input type="number" name="duree" placeholder="Durée" required min="0"/></td>
</tr>
<tr>
<td><button type="submit" name="btn-save">Enregistrer</button></td>
</tr>
<tr>
<td><button id="work"><a href="list2.php">Liste des offres</a></button></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>