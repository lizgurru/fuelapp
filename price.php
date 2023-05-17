<?php
    session_start();
    include ("connection.php");

    $email = $_SESSION['email'];
    if(!isset($email)){
        header("Location: index.html");
        exit();
    }

    //valid check if gallons, address and delivery date
    function price($gallons, $address1, $deliveryD){
        if (!empty($gallons) && !empty($address1) && !empty($deliveryD)){
            return true;
        }
        else{
            return false;
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $address1 = $_GET['address1'];
        $gallonReq = $_GET['galreq'];
        $delivery = $_GET['delivery'];
        

        if (price($gallonReq, $address1, $delivery)){
          
            $companyProfitFactor = 0.10;
            $currPrice = 1.50;

            //check state location from delivery 
            $sqlState = "SELECT State FROM ClientInformation WHERE user_ID = '$email'";
	        $result = mysqli_query($con, $sqlState);
            
            while($row1 = mysqli_fetch_array($result)){
                $location = $row1['State'];
            }

            if($location == 'TX'){
                $locationFactor = 0.02;
            }
            else{
                $locationFactor = 0.04;
            }
            
            //check fuelTable to see if there are rows
            $sqlTable = "SELECT price FROM FuelOrders WHERE userID = '$email'";
            $resultTable = mysqli_query($con, $sqlTable);

            while($row2 = mysqli_fetch_array($resultTable)){
                $checkifRow = $row2['price'];
            }

            if (isset($checkifRow)){
                $rateHistory = 0.01;
            }
            else{
                $rateHistory = 0;
            }

            //check if gallons requested more than 1000
            if ($gallonReq < 1000){
                $gallonFactor = 0.03;
            }
            else{
                $gallonFactor = 0.02;
            }
            
            $margin = $currPrice * ($locationFactor - $rateHistory + $gallonFactor + $companyProfitFactor);
           
            $suggestPrice = $currPrice + $margin;

            $totalPrice = $gallonReq * $suggestPrice;


           // echo "PRICE WORKS";
           /*
            if($result){
                echo "RESULT WORKED";
            }
            else{
                echo "RESULT DIDNT WORK";
            }
            */
        }
	/*
        else{
            echo "INVALID";
        }
	*/
        
    
    }

    else{
        header("Location: fuelQuoteForm.php");
        exit('Invalid Inputs');
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
							<p>Review Your Fuel Quote</p>
					</div>
				</div>
                <!--submitting here would move push all information in the fueql-form to the fuel table-->
				<form class="fuelq-form" action = "submitQuote.php" method = "post">
                    <label for="Gallons">Gallons Requested</label>
					<input type="number" name = "galreq" value = "<?php echo ($gallonReq);?>" readonly/>

                    <label for="Address">Delivery Address</label> 
                    <!--Getting the Address value from Client Profile Management.php-->
                    <input type = "text" name = "address1" value = "<?php echo ($address1);?>" readonly/>
        
                    <label for="Date">Delivery Date</label>
					<input type="date" name = "delivery" value = "<?php echo ($delivery);?>" readonly/>

                    <!--Info from pricing in above php gets echoed down here-->

                    <label for="suggestPrice">Suggested Price</label>
					<input type="number" name = "price" value = "<?php echo ($suggestPrice);?>" readonly>
					
                    <label for="Total">Total Amount Due</label>
					<input type="number" name = "total" value = "<?php echo ($totalPrice);?>" readonly>
                    
                    <button>Submit Fuel Quote</button>
                    <br></br>
                </form>

                <!--send to submit php -->
              <!--  
                <form class = "submit" action = "submitQuote.php" method = "post">
                    <button>Submit Fuel Quote</button>
                    <br></br>
                </form>
-->
                <form class = "modify" action = "fuelQuoteForm.php">
                    <button>Modify Fuel Quote</button>
				</form>
			</div>
		</div>
	</body>

</html>
