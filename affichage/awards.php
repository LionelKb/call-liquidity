<?php
    session_start();
    include "dbconnect.php";
    $id_history = $_SESSION['history'];
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset = "utf-8"/>
    	<link rel="stylesheet" href="style1.css" type="text/css" />
    	<link rel="stylesheet" href="style2.css" type="text/css" />
    	<title>Résultats d'adjudication-CFL</title>
    </head>
    <body>
    	<div class= "header">
    		<div id= "left">
    			<label>Résultats d'adjudication</label>
    		</div>
                <div id="right">
                    <div id="content">
                        <a href="logout.php?logout">Accueil</a>
                    </div>
                </div>
    	</div>
    	<div class= "title">
    	<div>
    		<?php
                include"info.php";
    		    echo"<table>";
    		    echo ("<tr><td>Montant du prêt (en BIF): ".number_format($intervention_amount,0,',',' ')."</td></tr>");
    		    echo ("<tr><td>Soumission à taux libre</td></tr>");
    		    echo ("<tr><td>Adjudication : taux multiples</td></tr>");
    		    echo ("<tr><td>Nombre maximum d'offres par banques: 5</td></tr>");
    		    echo "</table>";
    		?>
    		<h3><?php echo "Appel d'offres n°$id_history du $date" ?></h3>
    		<h4><?php echo "Semaine du $debut au $maturity" ?></h4>
    	<div class="container">
            <center>
    		<table class="table-form">
    			<thead>
    			<tr>
    				<th><strong>Taux</strong></th>
    				<?php
    				    $get_banks = mysqli_query($connect,"select DISTINCT name FROM banks inner join offers on banks.id = offers.id_bank where offers.id_history=id_history ORDER BY name;");
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
    			    include "analysing.php";
    			    include "awarding.php";
    			    foreach($banks AS $rate => $bank_offer)
    			    {
    			    	if($rate>=$i)
    			    	{
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
    			        }
    			    }
    			?>
    		</table>
            <button class="work" id="righty"><a href="publication.php" id ="link_right" >Publications</a></button>
            <button class="work" id="lefty"><a href="analysis.php" id="link_left">Dépouillement</a></button>
        </center>
    	</div>
        </div>
    </body>
</html>