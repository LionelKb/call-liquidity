<?php
    $id_history = 1;
    $connect = mysqli_connect("localhost","root","Callhome2015!");
	$db = mysqli_select_db($connect,"call_for_liquidity");
	$sql = mysqli_query($connect,"SELECT DISTINCT rate FROM offers WHERE id_history = '$id_history' ORDER BY rate DESC");
	$rates = array();
	$banks = array();
	$amounts = array();
	while($rate_tab = mysqli_fetch_array($sql))
	{
		$rate = $rate_tab['rate'];
		$rates[] = $rate_tab['rate'];
		$sql2 = "SELECT DISTINCT name FROM banks ORDER BY name;";
		$res1 = mysqli_query($connect,$sql2);
	    while($bank = mysqli_fetch_array($res1))
		{
			$name = $bank['name'];
			$banks[$rate][$name][]=0;
			$sql2 = "select rate,offers.amount as amount,banks.name as name_bank 
			from offers inner join banks on banks.id = offers.id_bank 
			where rate = '$rate' and banks.name='$name' and id_history = '$id_history';";
			$res2 = mysqli_query($connect,$sql2) or die ("erreur");
			$current_name = $name;
			while ($montant = mysqli_fetch_array($res2))
			{
				if ($montant['rate']==$rate and $montant['name_bank']==$name)
				{
					$amount=$montant['amount'];
					$banks[$rate][$name][]=$amount ;

				}
			}
		}
	}
	print_r($rates);
	echo '</br>';
	echo '<pre>';
	print_r($banks);
	echo '</pre>';
?>


<?php
$id_history = 8;
    $connect = mysqli_connect("localhost","root","Callhome2015!");
	$db = mysqli_select_db($connect,"call_for_liquidity");
	$sql = mysqli_query($connect,"SELECT DISTINCT rate FROM offers WHERE id_history = '$id_history' ORDER BY rate DESC");
	while($rate_tab = mysqli_fetch_array($sql))
	{
		$rate = $rate_tab['rate'];
		$sql2 = "select rate,offers.amount as amount,banks.name as name_bank 
		from offers inner join banks on banks.id = offers.id_bank 
		where rate = '$rate' and id_history = '$id_history';";
		$result = mysqli_query($connect,$sql2);
		    while($montant = mysqli_fetch_array($result))
			{
				echo "</br>";
				echo $montant['rate']." - ".$montant['amount']." - ".$montant['name_bank'];
			}
	}

?>


<?php
    $connect = mysqli_connect("localhost","root","Callhome2015!");
	$db = mysqli_select_db($connect,"call_for_liquidity") or die ("erreur de connexion");
	$sql="SELECT Taux, TOTAL FROM (SELECT Taux, IBB, BCB, BANCOBU, IBB+BCB+BANCOBU AS TOTAL 
                              FROM (SELECT Taux,
	                                    SUM(IF (Banque = 'BANCOBU', Montant, 0)) AS BANCOBU,
								        SUM(IF (Banque = 'BCB', Montant, 0)) AS BCB,
                                        SUM(IF (Banque = 'IBB', Montant, 0)) AS IBB
	                                  FROM (SELECT offers.rate AS Taux, offers.amount AS Montant, banks.name AS Banque
                                                   FROM offers INNER JOIN banks 
					                                    ON offers.id_bank = banks.id
									                        ORDER BY offers.rate DESC) AS recap
										                        GROUP BY Taux 
										                          ORDER BY Taux DESC) AS Ordonne)AS total";
	

	$result = mysqli_query($connect,$sql);
	/*$totals = mysqli_fetch_array($result);*/
	$accumulations = array();
	/*$previous_rate=5.5;*/
	$accumulations[$previous_rate] = 0;
/*	foreach ($totals as $Taux => $TOTAL) */
	while ($totals = mysqli_fetch_array($result))
	{
/*	    $accumulations[$Taux] = $accumulations[$previous_rate] + $totals[$Taux];*/	
		$rate = $totals['Taux'];
		$total_amount = $totals['TOTAL'];
/*		echo "$rate $total_amount";
		echo"</br>";*/
		$accumulations[$rate] = $accumulations[$previous_rate] + $total_amount ;
		echo $rate. " ".$accumulations[$rate];
		echo"</br>";
	    $previous_rate = $rate;
	}
	mysql_close($connect);
?>
