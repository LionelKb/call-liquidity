<?php
    include "dbconnect.php";
    $id_history = 1;
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset = "utf-8"/>
    	<link rel="stylesheet" href="depouillement.css"/>
    	<title>Dépouillement-CFL</title>
    </head>
    <body>
    	<div>
    		<h2>Dépouillement des offres de liquidités</h2>
    		<?php
    		    $get_intervention_amount = mysqli_query($connect,"select int_amount,dateh from history_offers WHERE id =$id_history");
    		    $data = mysqli_fetch_row($get_intervention_amount);
    		    $intervention_amount = $data[0];
    		    $date = $data[1];
    		    echo"<table>";
    		    echo ("<tr><td>Montant du prêt (en BIF): ".$intervention_amount."</td></tr>");
    		    echo ("<tr><td>Soumission à taux libre</td></tr>");
    		    echo ("<tr><td>Adjudication : taux multiples</td></tr>");
    		    echo ("<tr><td>Nombre maximum d'offres par banques: 5</td></tr>");
    		    echo "</table>";
    		?>
    		<h4><?php echo "Appel d'offres n°$id_history du $date" ?></h4>
    		<h5><?php echo "Semaine du 12 au 19 novembre 2015" ?></h5>
    	</div>
    	<div class="container">
    		<table class="table-form">
    			<thead>
    			<tr>
    				<th><strong>Taux</strong></th>
    				<?php
    				    $get_banks = mysqli_query($connect,"select distinct name from banks ORDER BY name");
    				    $banks = array();
    				    while($result = mysqli_fetch_array($get_banks))
    				    {
    				    	$name_bank = $result['name'];
    				    	echo "<th>".$name_bank."</th>";
    				    }
    				?>
    				<th>Total</th>
    				<th>Cumul</strong></th>
    				<th>Résiduel</th>
    			</tr>
    			</thead>
    			<?php
    			    include "depouillement.php";
    			    foreach($banks AS $rate => $bank_offer)
    			    {
    			    	echo "<tbody>";
    			    	echo "<tr>";
    			    	echo "<td>$rate</td>";
    			    	foreach($bank_offer AS $banks => $amount )
    			    	{
    			    		echo ("<td>".number_format($amount,0,',',' ')."</td>");
    			    	}
    			    	echo ("<td>".number_format($totals[$rate],0,',',' ')."</td>");
    			    	echo ("<td>".number_format($accumulations[$rate],0,',',' ')."</td>");
    			    	echo ("<td>".number_format($residuals[$rate],0,',',' ')."</td>");
    			    	echo "</tr>";
    			    	echo "</tbody>";
    			    }
    			?>
    		</table>
    	</div>
    	<a href="Adjudication.php">Adjudication</a>
    </body>
</html>