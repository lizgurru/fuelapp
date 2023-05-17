<?php

    session_start();
    include ("connection.php");

	$email = $_SESSION['email'];
	if (!isset($email)){
		header("Location: index.html");
		exit();
	}
	
	//getting address1 from client information table
	$sql = "SELECT Address1 FROM ClientInformation WHERE user_ID = '$email'";
	$result = mysqli_query($con, $sql);
	//$address1 = mysqli_fetch_assoc($result);
	while($row = mysqli_fetch_array($result)){
		$address1 = $row['Address1'];
	}
	
	//if ($temp == ''){echo "BLANK";

?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Fuel Quote Form</title>
	</head>
	
	<body>
		<div class="fuel-quote-form">
			<div class="form">
				<div class="fuel-quote">
					<div class="fuel-header">
						<h3>Fuel Quote Form</h3>
							<p>Please Fill Out Fuel Quote</p>
					</div>
				</div>
				<form class="fuelq-form" action = "price.php" method="get">
                    <label for="Gallons">Gallons Requested</label>
					<input type="number" name = "galreq" id="galreq" placeholder="Gallons requested" min="1" required/>

                    <label for="Address">Delivery Address</label> 
                   
                    <input type = "text" name = "address1" value = "<?php echo $address1;?>" readonly/>
        
                    <label for="Date">Delivery Date</label>
					<input type="date" name = "delivery" id="delivery" required/>

                	<button>Get Fuel Quote</button>
					<br></br>
				</form>
				
				<form class = "history" action = "fuelTable.php">
                    <button>View Fuel Quote History</button>
				</form>
			</div>
		</div>
	</body>

</html>
