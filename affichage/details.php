<?php
    session_start();
    include_once "dbconnect.php";
    $id_history = $_SESSION['history'];
    $win = $_POST['winner'];
?>
    <!DOCTYPE html>
<html>
    <head>
    	<meta charset = "utf-8"/>
    	<link rel="stylesheet" href="style1.css" type="text/css" />
    	<link rel="stylesheet" href="style2.css" type="text/css" />
        <link rel="stylesheet" href="style3.css" type="text/css" />
    	<title>Détails individuels-CFL</title>
    </head>
    <body>
    	<div class= "header">
    		<div id= "left">
    			<label>Résultats d'adjudication : <?php $data = mysqli_fetch_row(mysqli_query($connect,"select name from banks where id = '$win'"));
    			                                        echo $winner = $data[0]; ?></label>
    		</div>
                <div id="right">
                    <div id="content">
                        <a href="logout.php?logout">Acceuil</a>
                    </div>
                </div>
    	</div>
    	<div class= "public" id = "letter">
    	<div>
    		<?php
    		    include"info.php";
    		?>
    	<p class = "objet">
    		<p id="date">Bujumbura, le <?php echo $full_debut;?> .</p>
    		<p><strong>Banque de la République du Burundi</strong></br>
    			Service Monétaire et financier</p></br>
    		<p id = "partner" >A la direction de : <?php echo $winner;?></br>
    		        BUJUMBURA</p></br></br>

    		<strong>Objet: </strong>Résultat d'adjudication</br></br>
    		Messieurs,</br></br>
    		Vous êtes informés que suite à votre soumission à l'appel d'offres n°<?php echo $id_history ;?></br>
    		effectuée ce jour, l'adjudication y relative a donné les résultats suivants pour votre banque: </br></br>
    	</p>
    </div>
    <div class="container">
	    <table class="table-form">
    			<thead>
    			<tr>
    				<th><strong>N° d'ordre</strong></th>
    				<th>Montant soumissionné</th>
    				<th>Taux offert</strong></th>
    				<th>Montant retenu</th>
    				<th>Intérêts</th>
    			</tr>
    			</thead>
    			<tbody>
    			<?php
    			   include "analysing.php";
    			   include "awarding.php";
    			   include "notifying.php";
    			$i=1;
    			foreach($of_amount as $rate => $amount)
    			{
    				echo '<tr>';
    				echo '<td>'.$i++.'</td>';
    				echo '<td>'.number_format($amount,0,',',' ').' BIF</td>';
    				echo '<td>'.$rate.'</td>';
    				echo '<td>'.number_format($aw_amount[$rate],0,',',' ').' BIF</td>';
    				echo '<td>'.number_format($interest[$rate],0,',',' ').' BIF</td>';
    				echo '</tr>';
    			}
    			?>
    		    </tbody>
    		    <tfoot>
    		    	<?php
    		    	    echo '<tr>';
    		    	    echo '<th>Total</th>';
    		    	    echo '<th>'.$tot_submit.' BIF</th>';
    		    	    echo '<th> </th>';
    		    	    echo '<th>'.$tot_award.' BIF</th>';
    		    	    echo '<th>'.$tot_interest.' BIF</th>';
    		    	?>
        </table>
    </br></br>
    <p>Votre compte courant sera crédité de <strong><?php echo number_format($tot_award,0,',',' ')." BIF au ".$full_debut; ?></strong>.</br>
    	Au <strong><?php echo $maturity?></strong>, il sera débité du montant retenu augmenté des intérêts soit 
    	<strong><?php echo number_format($tot_award+$tot_interest,0,',',' ').' BIF'; ?></strong>.</p></br>
    <p>Veuillez agréer, Messieurs, l'assurance de notre considération distinguée.</p></br></br>
    <h4>BANQUE DE LA REPUBLIQUE DU BURUNDI</h4>
    </div>
</br></br>
    <div id="content">
            <center>
            <button class="log2"><a href="notifications.php">Autre Soumissionnaire</a></button></br><br>
            </center>
        </div>
    </body>
</html>