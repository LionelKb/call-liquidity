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
				$residuals[$rate] = 0;
				$totals[$rate] = 0;
				$accumulations[$rate] = 0;
			}
			if($residuals[$j] >0 and $residuals[$i] < 0)
			{
				$adjud[$i][$banks] = $amount*$ad_amount/$totals[$i];
				$residuals[$rate] = 0;
				$totals[$rate] = 0;
				$accumulations[$rate] = 0;
			}
		}
	}
	$banks=$awards;
?>