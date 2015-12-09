<?php
	include "config.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BRB Appel d'Offres</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- Leave those next 4 lines if you care about users using IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="container">
  		<div class="text-center">
  			<h2>Reprise de liquidités</h2>
  			<?php
  			$id_history = '8';
	  		$get_intervention_amount = mysql_query("select intervention_amount,date from history_offers where id='$id_history'");
			$data = mysql_fetch_row($get_intervention_amount);
			$intervention_amount = $data[0];
			$date = $data[1]
			?>
			<h4><?php echo "Appel d'offre du $date" ?></h4>
  			</div>

  		<table class="table table-striped table-hover table-bordered text-center">
	  		<tr>
	  			<td><strong>Taux</strong></td>
	  			<?php
	  			$get_banks = mysql_query("select distinct name from banks order by name");
	  			$i = 0;
	  			$empty_offers = array();
	  			while ($data = mysql_fetch_assoc($get_banks)) {
	  				$empty_offer = array();
	  				$name_bank = $data['name']; 
	  				echo "<td><strong>".$name_bank."</strong></td>";
	  				$array_banks[$name_bank] = $i;
	  				$empty_offer[$name_bank] = 0;
					array_push($empty_offers,$empty_offer);
					$i++;
				}
				#print_r($array_banks);
				#$name_bank = 'BCB';
				#print_r($empty_offers[$array_banks[$name_bank]][$name_bank]);
				#print_r($empty_offers);
				# empty_offers contient : 
				#Array ( [0] => Array ( [Bancobu] => 0 ) [1] => Array ( [BCB] => 0 ) [2] => Array ( [IBB] => 0 ) )
				#Array ( [0] => Array ( [Bancobu] => 0 ) [1] => Array ( [BCB] => 0 ) [2] => Array ( [IBB] => 0 ) )
	  			?>
	  			<td><strong>Total</strong></td>
	  			<td><strong>Cumul</strong></td>
	  			<td><strong>Résiduel</strong></td>
	  		</tr>
			<?php

	  			$get_rates = mysql_query("select distinct rate from offers where id_history = '$id_history' order by rate desc");
	  			#$get_rates = mysql_query("select distinct rate from offers where rate = '5.2'");
				$array_rates = array();
				$rates_amount = array();
				while ($data = mysql_fetch_assoc($get_rates)) {
					$rate = $data['rate'];
					array_push($array_rates,$data['rate']);
					$number_banks = sizeof($array_banks);
					$bank_offers = $empty_offers;
					$get_amount_by_rates = mysql_query("select rate,offers.amount as amount,banks.name as name_bank 
					from offers 
					inner join banks on banks.id = offers.id_bank 
					where rate = '$rate' and id_history = '$id_history'");
					while ($data_1 = mysql_fetch_assoc($get_amount_by_rates)) {
						$name_bank = $data_1['name_bank'];
						$amount = $data_1['amount'];
						$bank_offers[$array_banks[$name_bank]][$name_bank] = $amount;
					}
					$rates_amount[$rate] = $bank_offers;
				}


				$get_totals = mysql_query("select rate, sum(amount) as total 
					from offers 
					where id_history = '$id_history'
					group by rate 
					order by rate desc");
				$totals=array(); 
				while ($data = mysql_fetch_assoc($get_totals)) {
					$rate = $data['rate'];
					$amount = $data['total'];
					$totals[$rate] = $amount;
				}

				$accumulations = array();
				$accumulations[$previous_rate] = 0;
				foreach ($totals as $rate => $amount) {
					$accumulations[$rate] = $accumulations[$previous_rate] + $totals[$rate];
					$previous_rate = $rate;
				}

				$residuals = array();
				foreach ($accumulations as $rate => $amount) {
					$residuals[$rate] = $intervention_amount - $accumulations[$rate];
				}

				#print_r($totals);
				#print_r($rates_amount);
				foreach ($rates_amount as $rate => $bank_offers) {
					echo "<tr>";
					echo("<td>$rate</td>");
					foreach ($bank_offers as $bank_offer) {
						foreach ($bank_offer as $name_bank => $amount) {
							#echo ("$name_bank :$amount");
							echo ("<td>".number_format($amount,0,',',' ') ."</td>");
							foreach ($variable as $key => $value) {
								# code...
							}
						}
					}
					#print_r($bank_offers);
					echo ("<td>".number_format($totals[$rate],0,',',' ') ."</td>");
					echo ("<td>".number_format($accumulations[$rate],0,',',' ') ."</td>");
/*					echo ("<td>".$residuals[$rate]."</td>");*/
					echo ("<td>".number_format($residuals[$rate],0,',',' ') ."</td>");
					/*number_format($totals['Fees'], 2);*/
				}
			?>
	  	</table>
  	</div>

    <!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>