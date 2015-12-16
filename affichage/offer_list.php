<?php
    include "dbconnect.php";
    $id_history = $_POST["ref"];
    $sql = mysqli_query($connect, "select id,int_amount from history_offers");
    while($data=mysqli_fetch_array($sql))
    {
    	echo "<form action=analysis.php method=post>";
    	echo ($ab = $data['id']. " ".$data['int_amount']);
    	echo "<button type=submit name=analyse>Analyse</button>";
    	echo "</form>";
    }
?>