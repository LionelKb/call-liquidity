<?php
session_start();
include_once 'dbconnect.php';
$id_history = $_SESSION['history'];
if(isset($_POST['btn-save']))
{
	$bank = mysqli_real_escape_string($connect,$_POST['bank']);
	$rate = mysqli_real_escape_string($connect,$_POST['rate']);
	$amount = mysqli_real_escape_string($connect,$_POST['amount']);
	
	if(mysqli_query($connect,"INSERT INTO offers(id_bank,rate,amount,id_history) VALUES('$bank','$rate','$amount','$id_history')"))
	{
		?>
        <script>alert(' Offre enregistrée ');</script>
        <?php
        header("Location: formulaire_offre.php");
	}
	else
	{
		?>
        <script>alert('Erreur d\'enregistrement de l\'offre');</script>
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
<body>
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><label><select name="bank"><option value="1">Banque de Crédit de Bujumbura</option>
		                        <option value="2">Banque Commerciale du Burundi</option>
							    <option value="3">Banque Burundaise pour le Commerce et l'Investissement</option>
								<option value="4">Interbank Burundi</option>
								<option value="5">Banque de Gestion et de financement</option>
								<option value="6">Ecobank</option>
								<option value="7">Finbank</option>
								<option value="8">DTB Burundi</option>
								<option value="9">KCB Burundi</option>
								<option value="10">CRDB Burundi</option>
	                            </select></label></td>
</tr>
<tr>
<td><input type="float" name="rate" placeholder="Taux" required min="0"/></td>
</tr>
<tr>
<td><input type="number" name="amount" placeholder="Montant de l'offre" required min="0"/></td>
</tr>
<tr>
<td><button type="submit" name="btn-save">ENREGISTRER</button></td>
</tr>
<tr>
<td><button id="work"><a href="list2.php">Terminer</a></button></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>