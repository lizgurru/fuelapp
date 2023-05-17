<?php
    session_start();
    include ("connection.php");
    $email = $_SESSION['email'];
    if (!isset($email)){
        header("Location: index.html");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $galReq = $_POST['galreq'];
        $address = $_POST['address1'];
        $delivery = $_POST['delivery'];
        $suggestPrice = $_POST['price'];
        $totalPrice = $_POST['total'];

        $query = "INSERT INTO FuelOrders (userID, gallons, deliveryAddress, deliveryDate, price, total)
                  VALUES ('$email', '$galReq', '$address', '$delivery', '$suggestPrice', '$totalPrice')";
        $result = mysqli_query($con, $query);
    
    }
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
							<p>Your Fuel Quote Has Been Submitted!</p>
					</div>
				</div>
                <!--submitting here would move push all information in the fueql-form to the fuel table-->
				<form class="fuelq-form" method = "get">
                    <label for="Gallons">Gallons Requested</label>
					<input type="number" name = "galreq" value = "<?php echo ($galReq);?>" readonly/>

                    <label for="Address">Delivery Address</label> 
                    <!--Getting the Address value from Client Profile Management.php-->
                    <input type = "text" name = "address1" value = "<?php echo ($address);?>" readonly/>
        
                    <label for="Date">Delivery Date</label>
					<input type="date" name = "delivery" value = "<?php echo ($delivery);?>" readonly/>

                    <!--Info from pricing in above php gets echoed down here-->

                    <label for="suggestPrice">Suggested Price</label>
					<input type="number" name = "price" value = "<?php echo ($suggestPrice);?>" readonly>
					
                    <label for="Total">Total Amount Due</label>
					<input type="number" name = "total" value = "<?php echo ($totalPrice);?>" readonly>
                </form>

                <form class = "history" action = "fuelTable.php">
                    <button>View Fuel Quote History</button>
                    <br></br>
                </form>

                <form class = "modify" action = "fuelQuoteForm.php">
                    <button>Create a New Fuel Quote</button>
				</form>
			</div>
		</div>
	</body>

</html>
