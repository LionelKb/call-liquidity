<?php
    			$totals = array();
    			$banks = array();
    			    $get_rates = mysqli_query($connect,"select distinct rate from offers where id_history = $id_history ORDER BY rate DESC");
    			    while($rate_tab = mysqli_fetch_array($get_rates))
    			    {
    			    	$rate = $rate_tab['rate'];
    			    	$rates[] = $rate_tab['rate'];
    			    	$sql2 = "SELECT DISTINCT name FROM banks ORDER BY name;";
    			    	$res1 = mysqli_query($connect,$sql2);
    			    	while($result = mysqli_fetch_array($res1))
    			    	{
    			    		$name_bank = $result['name'];
    			    		$banks[$rate][$name_bank]=0;
    			    		$sql2 = "select rate,offers.amount as amount,banks.name as name_bank 
    			    		from offers inner join banks on banks.id = offers.id_bank 
    			    		where rate = '$rate' and banks.name= '$name_bank' and id_history = '$id_history'";
    			    		$res2 = mysqli_query($connect,$sql2) or die ("erreur2");
    			    		while ($result = mysqli_fetch_array($res2))
    			    		{
    			    			$amount=$result['amount'];
    			    			$banks[$rate][$name_bank]=$amount;//constitution du tableau des taux, nom de banque et montant
    			    			$totals[$rate] = array_sum($banks[$rate]);
    			    		}
    			    	}
    			    }
    			    /*echo '<pre>';
    			    print_r($totals);
    			    echo '</pre>';
    			    echo '<pre>';
    			    print_r($banks);
    			    echo '</pre>';*/
    			    $pre_cumul = array();
    			    $previous_rate = 0;
    			    $pre_cumul[$previous_rate]=0;
    			    $accumulations = array();
    			    foreach($totals AS $rate => $amount)
    			    {
    			    	$pre_cumul[$rate] = $pre_cumul[$previous_rate] + $totals[$rate];
    			    	$previous_rate=$rate;
    			    	$accumulations[$rate] = $pre_cumul[$rate];//contient le cumul à chaque rate
    			    }
    			    /*echo '<pre>';
    			    print_r($pre_cumul);
    			    echo '</pre>';
    			    echo '<pre>';
    			    print_r($accumulations);
    			    echo '</pre>';*/
    			    $residuals = array();
    			    foreach($accumulations AS $rate => $amount)
    			    {
    			    	$residuals[$rate] = $intervention_amount - $accumulations[$rate];
    			    }
    			    /*echo '<pre>';
    			    print_r($residuals);
    			    echo '</pre>';*/
                    $startin_offers = $totals;
?>