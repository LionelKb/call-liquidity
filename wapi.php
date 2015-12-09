 <?php
    $id_history = 8;
    $connect = mysqli_connect("localhost","root","Callhome2015!");
	$db = mysqli_select_db($connect,"call_for_liquidity");
	$sql = mysqli_query($connect,"SELECT DISTINCT rate FROM offers WHERE id_history = '$id_history' ORDER BY rate DESC");
	$rates = array();
	$banks = array();
	$cumul = array();
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
				$banks[$rate][$name]=$amount;
				$totals[$rate] = array_sum($banks[$rate]);
			}
		}
	}
	$previous_rate = 0;
	$cumul[$previous_rate] = 0;
	$cumulf = array ();
	foreach($totals AS $rate => $amount)
	{
		$cumul[$rate] = $cumul[$previous_rate] + $totals[$rate];
		$previous_rate=$rate;
		$cumulf[$rate] = $cumul[$rate];
	}
	$sql3 = "select intervention_amount from history_offers where id = '$id_history';";
	$res3 = mysqli_query($connect,$sql3) or die ("erreur3");
	while($resid = mysqli_fetch_array($res3))
	{
		$intervention = $resid['intervention_amount'];
	}
	foreach($cumulf AS $rate => $amount)
	{
		$residuel[$rate] = $intervention - $cumulf[$rate];
	}
	print_r($rates);
	echo '</br>';
	echo '<pre>';
	print_r($banks);
	echo '</pre>';
	echo '<pre>';
	print_r($totals);
	echo '</pre>';
	echo '<pre>';
	print_r($cumulf);
	echo '</pre>';
	echo '<pre>';
	print_r($residuel);
	echo '</pre>';
	/* afficher*/

?>