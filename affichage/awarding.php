<?php
    $i = 0;
	$j = 0;
	$adjud_rate =0;
	$ad_amount = 0;
	foreach($residuals as $rate => $amount)
	{
		if ($amount > 0)
		{
			$j = $rate;
			$ad_amount = $amount;
		}
		if($amount <= 0)
		{
			$temp[]=$rate;//tableau de rate où le résiduel est nul et/ou négatif
			$i = max($temp);
		}
	}
	/*echo $j;
	echo $i;*/
	$awards = $banks;
	$submit = $banks;//conservation des offres initiales
	$resid = $residuals;//conservation des résiduels initiaux
	foreach($awards as $rate => $awards_amount)
	{
		foreach($awards_amount as $banks => $amount)
		{
			/*if($adjud_amount == $i)*/
			if($rate < $i)
			{
				$awards[$rate][$banks]= 0;//annulation des montants non adjugés
				$residuals[$rate] = 0;
				$totals[$rate] = 0;
				$accumulations[$rate] = 0;
			}
			if($residuals[$j] >0 and $residuals[$i] < 0 and $rate<=$i)
			{
				$awards[$i][$banks] = $amount*$ad_amount/$totals[$i];
				/*echo $amount;
				echo $ad_amount;
				echo $totals[$i];*/
				$totals[$rate] = array_sum($awards[$i]);
				$accumulations[$rate] = $accumulations[$j] + $totals[$rate];
				$residuals[$rate] = $intervention_amount - $accumulations[$rate];
			}
		}
	}
	$banks=$awards;
    $av_rate = array_sum($rates)/sizeof($rates);
    $marg_rate = array_sum($rates);
?>