<?php    
    foreach($awards as $rate => $awards_amount)
	{
		foreach($awards_amount as $awards => $amount)
		{
			if($amount >0)
			{
				$adjud_banks[$awards][$rate] = $amount;
			}
			if($residuals[$rate]=0 and $submit[$rate][$awards]>0)
			{
				$adjud_banks[$awards][$rate] = 0;
			}
		}
	}
	foreach($submit as $rate => $submit_amount)
	{
		foreach($submit_amount as $submit => $amount)
		{
			if($amount >0)
			{
				$submit_banks[$submit][$rate] = $amount;
			}
		}
	}
	/*echo '<pre>';
	print_r($submit_banks);
	echo '</pre>';*/
	/*echo '<pre>';
	print_r($adjud_banks);
	echo '</pre>';*/
	$award = array();
	$offer_bank = array();
	for($offset=0;$offset<=sizeof($adjud_banks);$offset++)
	{	
		$winners_amount = array_slice($adjud_banks,$offset,true);
		if(key($winners_amount)==$winner)
		{
			/*echo '<pre>';
			print_r($winners_amount);
			echo '</pre>';*/
			$award = $winners_amount;
		}
	}
	for($offset=0;$offset<=sizeof($submit_banks);$offset++)
	{	
		$offers_amount = array_slice($submit_banks,$offset,true);
		if(key($offers_amount)==$winner)
		{
			/*echo '<pre>';
			print_r($winners_amount);
			echo '</pre>';*/
			$offer_bank = $offers_amount;
		}
	}
	/*echo '<pre>';
	print_r($offer_bank);
	echo '</pre>';
	echo '<pre>';
	print_r($award);
	echo '</pre>';*/
	$interest = array();
	foreach($award as $name_bank => $award_amount)
	{
		foreach($award_amount as $award => $amount)
		{
			$aw_amount[$award] = $amount;
			$tot_award = array_sum($aw_amount);
			$interest[$award] = floor($amount*$award/360);
			$tot_interest = array_sum($interest);
		}
	}
	foreach($offer_bank as $name_bank => $offer_amount)
	{
		foreach($offer_amount as $offer_bank => $amount)
		{
			$of_amount[$offer_bank] = $amount;
			$tot_submit = array_sum($of_amount);
		}
	}
	/*echo $tot_amount;
	echo '<pre>';
	print_r($interest);
	echo '</pre>';
	echo $tot_interest_bank;
	echo '</br>';
	print_r($tot_interest_bank);*/
?>