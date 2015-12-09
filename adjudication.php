 <?php
    $id_history = 2;
    $connect = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connect,"liquidity");
	$sql = mysqli_query($connect,"SELECT DISTINCT rate FROM offers WHERE id_history = '$id_history' ORDER BY rate DESC");
	$rates = array();
	$banks = array();
	while($rate_tab = mysqli_fetch_array($sql))
	{
		$rate = $rate_tab['rate'];
		$rates[] = $rate_tab['rate'];
		$sql2 = "SELECT DISTINCT name FROM banks ORDER BY name;";
		$res1 = mysqli_query($connect,$sql2);
	    while($bank = mysqli_fetch_array($res1))
		{
			$name = $bank['name'];
			$banks[$rate][$name]=0;
			$sql2 = "select rate,offers.amount as amount,banks.name as name_bank 
			from offers inner join banks on banks.id = offers.id_bank 
			where rate = '$rate' and banks.name='$name' and id_history = '$id_history';";
			$res2 = mysqli_query($connect,$sql2) or die ("erreur2");
			while ($montant = mysqli_fetch_array($res2))
			{
				
				$amount=$montant['amount'];
				$banks[$rate][$name]=$amount;//constitution du tableau des taux, nom de banque et montant
				$totals[$rate] = array_sum($banks[$rate]);
			}
		}
	}
	$previous_rate = 0;
	$cumul[$previous_rate] = 0;
	$cumulf = array();
	$residuel = array();
	foreach($totals AS $rate => $amount)
	{
		$cumul[$rate] = $cumul[$previous_rate] + $totals[$rate];
		$previous_rate=$rate;
		$cumulf[$rate] = $cumul[$rate];//contient le cumul à chaque rate
	}
	$sql3 = "select int_amount from history_offers where id = '$id_history';";
	$res3 = mysqli_query($connect,$sql3) or die ("erreur3");
	while($resid = mysqli_fetch_array($res3))
	{
		$intervention = $resid['int_amount'];
	}
	foreach($cumulf AS $rate => $amount)
	{
		$residuel[$rate] = $intervention - $cumulf[$rate];
	}
	/* afficher*/
	$final=array($banks,$totals,$cumulf,$residuel);//tous les tableaux en un seul.
	echo '<pre>';
	print_r($final);
	echo '</pre>';
	$i = 0;
	foreach($residuel as $rate => $amount)
	{
		if($amount < 0)
		{
			$temp[]=$rate;//rate où le résiduel est négatif
			$i = max($temp);
			echo '</br>';
		}
	}
	foreach($banks as $rate => $bank_amount)
	{
		foreach($bank_amount as $banks => $amount)
		{
			if($bank_amount == $i)
			{
				echo $amount;
				echo '</br>';
			}
		}
	}
?>