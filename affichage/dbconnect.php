<?php
    $connect = mysqli_connect("localhost","root",""); 
    $db = mysqli_select_db($connect,"liquidity");
    if(!mysqli_connect("localhost","root",""))
    {
    	die('oops connection problem ! --> '.mysql_error());
    }
    if(!mysqli_select_db(mysqli_connect("localhost","root",""),"liquidity"))
    {
    	die('oops database selection problem ! --> '.mysql_error());
    }
?> 