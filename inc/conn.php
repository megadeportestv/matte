<?php
$conn = mysqli_connect("localhost","megaaxmg","UEkpjZOIzDnJk","besoccer"); //local
//$conn = mysqli_connect("localhost","u4396178_n57whzfm2yvo","SlowD2019","u4396178_besoccer"); //localHost
//$conn = mysqli_connect("localhost","iraffle1_root","z1CnB-*XSJ-W","iraffle1_besoccer"); //prod

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>