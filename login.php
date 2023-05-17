<?php

	function login($email, $password)
	{
		
		// Database login information
		$serverName = "cosc4353-group25.mysql.database.azure.com";
		$userName = "adminUser";
		$serverPassword = "COSC4353GROUP25UH23!";
		$dbname = "db";
		
		// Create database connection
		$con = new mysqli($serverName, $userName, $serverPassword, $dbname);
		
		// Connection error check
		if ($con->connect_error)
		{
			die("Connection has failed: " . $con->connect_error);
		}
		
		// Creates the SQL query for email address
		$sql = "SELECT * FROM UserCredentials WHERE ID = ?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		
		// Gets result
		$emailResult = $stmt->get_result();
		
		// This triggers if the entered email matches a registered user's email
		if ($emailResult->num_rows == 1)
		{
			// Gets the hashed password
			$row = $emailResult->fetch_assoc();
			$hashPassword = $row['password'];
			
			// This triggers if the entered password matches the hashed password
			if (password_verify($password, $hashPassword))
			{
				return true;
			}
			
			// This triggers if the entered password does not match the hashed password
			else
			{
				return false;
			}
		
		} 
		// This triggers if the entered email does not match a registered user's email
		else
		{
			return false;
		}
	
		// Closes the connection
		$con->close();
	
	}
	
	// Start login process
	session_start();

	// Gets email and password from the 'login.html' form
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Calls 'login' function to validate entered credentials
	$result = login($email, $password);
	
	// Triggered if '$result' is true
	if ($result)
	{
	
		// Create session
		$_SESSION['email'] = $email;
		
		// Redirects the user to the 'fuelQuoteForm.php' page
		header("Location: fuelQuoteForm.php");
		exit();
		
	}
	
	// Triggered if '$result' is false
	else
	{
		
		// Displays an error message
		header("Location: login.php?error=1");
		exit();
		
	}
	
?>