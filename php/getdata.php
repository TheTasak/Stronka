<?php
    $username = "homeuser";
    $password = "Admin123";
    $host = "localhost";
    $database="stronka";

    $mysqli = new mysqli($host, $username, $password, $database);
    if(isset($_GET['data_index']))
    {
		$data_index = $_GET['data_index'];
    }
	if(isset($_GET['stock_name']))
	{
		$stock_name = $_GET['stock_name'];
	}
  if(isset($_GET['year']))
	{
		$year = $_GET['year'];
	}
  	if (mysqli_connect_errno()) {
  		printf("Connect failed: %s\n", mysqli_connect_error());
  		exit();
  	}
    $data = array();
	$stock = array();
	$myquery = "
	SELECT idspolki FROM `spis` WHERE spolki='{$stock_name}';
	";
  	$query = mysqli_query($mysqli, $myquery);

	if ( ! $query ) {
		echo mysqli_error($mysqli);
		die;
	}
  	$stock = $query->fetch_assoc();
	$stock_value = reset($stock);

	$i = 0;
	for($i = 0; $i <= (2020 - $year); $i++) {
		$date = ($year+$i);
  		$myquery = "
  		SELECT * FROM `{$date}_dane` WHERE idspolki='{$stock_value}' AND dane_ksiegowe='{$data_index}';
  		";
  		$query = mysqli_query($mysqli, $myquery);

  		if ( ! $query ) {
  			echo mysqli_error($mysqli);
  			die;
  		}
  		$row = $query->fetch_assoc();
  		$data[$i] = $row["{$date}"];
	  }
    echo json_encode($data);
    mysqli_close($mysqli);
?>
