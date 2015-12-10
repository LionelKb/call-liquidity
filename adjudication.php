 <?php
    $id_history = 2;
    $connect = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connect,"liquidity");
	$sql = mysqli_query($connect,"SELECT DISTINCT rate FROM offers WHERE id_history = '$id_history' ORDER BY rate DESC");
	$rates = array();
	$banks = array();
	$totals = array();
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
	$offers = $banks;
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
	/*adjudication*/
	echo '</br>';
	echo "ADJUDICATION</br>";
	echo "----------------------</br>";
	$i = 0;
	$j = 0;
	$adjud_rate =0;
	$ad_amount = 0;
	$adjud = $banks;
	foreach($residuel as $rate => $amount)
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
	foreach($adjud as $rate => $adjud_amount)
	{
		foreach($adjud_amount as $banks => $amount)
		{
			/*if($adjud_amount == $i)*/
			if($rate < $i)
			{
				$adjud[$rate][$banks]= 0;//annulation des montants non adjugés
			}
			if($residuel[$j] >0 and $residuel[$i] < 0)
			{
				$adjud[$i][$banks] = $amount*$ad_amount/$totals[$i];
			}
		}
	}
	echo '<pre>';
	print_r($adjud);
	echo'</pre>';
	/*notifications*/
	echo "NOTIFICATION!";
	echo '</br>';
	foreach ($adjud as $rate => $adjud_amount)
	{
		foreach($adjud_amount as $adjud => $amount)
		{
			if($amount > 0)
			{
				$adjud_banks[$adjud][$rate] = $amount;// tableau contenant les montants adjugés classés par banque
			}
		}
	}
	echo '<pre>';
	print_r($adjud_banks);
	echo '</pre>';
	$key_notify = array();
	for($offset=0;$offset<sizeof($adjud_banks);$offset++)
	{
		/*echo '<pre>';
		print_r(array_slice($adjud_banks,$offset,true));
		echo '</pre>';*/
		$notify_banks = array_slice($adjud_banks,$offset,true);
        $key_adjud = key($notify_banks);
    }
    /*notification par banque*/
    $banks_2 = array();
    foreach($offers as $rate => $amount)
    {
    	foreach($amount as $offers=> $amount)
    	{
    		$banks_2 [$offers][$rate] = $amount;
    	}
    }
    echo '<pre>';
	print_r($banks_2);
	echo '</pre>';
	echo "LES BANQUES ET LEURS OFFRES";
	for($offset=0;$offset<sizeof($banks_2);$offset++)
	{
		echo '<pre>';
		print_r(array_slice($banks_2,$offset,true));
		echo '</pre>';
		$offers_banks = array_slice($banks_2,$offset);//tableau de chaque banque et ses offres
        $key_submit = key($offers_banks);
    }
    $notification = array();
    $sql4 = "select distinct name FROM banks";
    $res4 = mysqli_query($connect,$sql4);
    while($bank_names = mysqli_fetch_array($res4))
    {
    	if($key_submit==$bank_names['name'] and $key_adjud == $bank_names['name'])
    	{
    		$notification = array($offers_banks,$notify_banks);
    	}
    }
    echo '<pre>';
	print_r($notification);
	echo '</pre>';
?>