<?php
    $get_intervention_amount = mysqli_query($connect,"select int_amount,date_format(dateh,'%e/%c/%Y'), 
    date_format(adddate(dateh,duree),'%e/%c/%Y'),day(dateh)+1,date_format(dateh+1,'%e/%c/%Y'), duree from history_offers WHERE id =$id_history");
    $data = mysqli_fetch_row($get_intervention_amount);
    $intervention_amount = $data[0];
    $date = $data[1];
    $maturity = $data[2];
    $debut = $data[3];
    $full_debut = $data[4];
    $term = $data[5];
?>