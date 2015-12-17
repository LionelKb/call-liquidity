<?php
    session_start();
    include_once "dbconnect.php";
    $id_history = $_SESSION['history'];
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset = "utf-8"/>
    	<link rel="stylesheet" href="style1.css" type="text/css" />
    	<link rel="stylesheet" href="style2.css" type="text/css" />
    	<title>Publication-CFL</title>
    </head>
    <body id="bg_pub">
    	<div class= "header">
    		<div id= "left">
    			<label>Publication des résultats</label>
    		</div>
    		<div id="right">
                <div id="content">
                    <a href="logout.php?logout">Accueil</a>
                </div>
            </div>
    	</div>
    	<?php
            include"info.php";
        ?>
        <div class="public">
		    <p>
			    L'adjudication au titre de l'appel d'offres d'apport de liquidité de  
				<strong><?php echo number_format($intervention_amount,0,',',' ') ?> BIF</strong> aux banques pour la semaine du <?php echo $debut ?> au 
				<?php echo $maturity ?> a donné les résultats suivants:
			</p>
		</br>
			<p>
				<h4 class="pub">I. Caractéristiques de l'appel d'offres :</h4>
			</br>
				<table>
					<ol>
				    <tr><td><li>N° Réf. Appel d'offres</td><td> : <?php echo $id_history ?> </td></li></tr>

					<tr><td><li>Date de l'appel d'offres</td><td> : <?php echo $date ?> </td></li></tr>

					<tr><td><li>Opération</td><td> : Apport de liquidité </td></li></tr>

					<tr><td><li>Type d'appel d'offres</td><td> : Taux variables </td></li></tr>

					<tr><td><li>Méthodes d'adjudication</td><td> : Taux multiples </td></li></tr>

					<tr><td><li>Taux de soumission</td><td> : Libres </td></li></tr>

					<tr><td><li>Date de dépôts des soumissions </td><td> : <?php echo $date ?> </td></li></tr>

					<tr><td><li>Date d'adjudication </td><td>: <?php echo $date ?> </td></li></tr>

					<tr><td><li>Date Valeur </td><td> : <?php echo $date ?> </td></li></tr>

					<tr><td><li>Echéance </td><td> : <?php echo $maturity ?> </td></li></tr>

					<tr><td><li>Durée </td><td>: <?php echo $term?> jours </td></li></tr>

					<tr><td><li>Nombre maximum d'offres par banque </td><td>: 5 </td></li></tr>
				</table>
					<tr><li><td>Montants d'offres exprimés en multiples de 100 millions de BIF</td></li></tr>
					<tr><li><td>Les taux seront exprimés en pourcentage annuel et en multiples de 5 points de base</td></li></tr>
                    <tr><li><td>Les taux seront classés par ordre décroissant.</td></li></tr>
                </ol>
            </p>
            </br>
            <p
            	<?php
            	    $numb_bank = mysqli_fetch_row(mysqli_query($connect,"select count(distinct id_bank) from offers where id_history=$id_history"));
            	    $num = $numb_bank[0];
            	    include "analysing.php";
            	    include "awarding.php";
				?>
				<h4 class="pub">Résultat d'adjudication</h4>
				<table>
                <ol>
                    <tr><td><li>N° Réf. Appel d'offres</td><td> : <?php echo $id_history ?> </td></li></tr>

					<tr><td><li>Date de l'appel d'offres</td><td> : <?php echo $date ?> </td></li></tr>

                    <tr><td><li>Nombre de participants </td><td> : <a href="notifications.php" id="notify"><?php echo $num." banques" ?></a></td></li></tr>

                    <tr><td><li>Montant total des offres </td><td> : <?php echo number_format(array_sum($startin_offers),0,',',' ') ?></td></li></tr>

                    <tr><td><li>Total des montants adjugés </td><td> : <?php echo number_format(array_sum($totals),0,',',' ')?></td></li></tr>

                    <tr><td><li>Montant total adjugé/ Total des offres </td><td> : <?php echo array_sum($totals)/array_sum($startin_offers)*100 ?></td></li></tr>

					<tr><td><li>Taux marginal </td><td>  : <?php echo $marg_rate ?></td></li></tr>

					<tr><td><li>Taux minimum offert </td><td> : <?php echo min($rates); ?></td></li></tr>

					<tr><td><li>Taux maximum offert </td><td>: <?php echo max($rates); ?></td></li></tr>

					<tr><td><li>Taux moyen pondéré</td><td> : <?php echo $av_rate; ?></td></li></tr>
				</ol>
			    </table>
        </div>
	</body>
</html>