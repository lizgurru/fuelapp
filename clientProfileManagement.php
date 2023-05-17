<?php
	session_start();
  include("connection.php");

  //make sure the user is logged in
  if(!isset($_SESSION['email']))
  {
    //not logged in so redirect to login page
    header("Location: login.html");
    exit();
  }

  function completeProfile($fullName, $address1, $address2, $city, $state, $zip)
  {
    //validate inputs
    if(!empty($fullName) && !empty($address1) && !empty($city) && !empty($state) && !empty($zip) && is_numeric($zip))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

  //form submitted
  if($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
    //gets values from the 'clientProfileManagement.html' form
    $fullName = $_POST['fullName'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $email = $_SESSION['email'];

    //check validity of inputs
    if(completeProfile($fullName, $address1, $address2, $city, $state, $zip))
    {
      if(!empty($address2) && isset($address2))
      {
        //store the completed profile information with 2 address fields into the database here
        $query = "INSERT INTO ClientInformation(FullName, Address1, Address2, City, State, Zipcode, user_ID)
          VALUES ('$fullName', '$address1', '$address2', '$city', '$state', '$zip', '$email')";
        $result = mysqli_query($con, $query);

          if($result)
          {
            header("Location: fuelQuoteForm.php");
          }
          //else {
            //echo "<div class='text-red'><br>ERROR ADDING DATA!</div>";
          //}
      }
      else
      {
        //store the completed profile information with 1 address field into the database here
        $query = "INSERT INTO ClientInformation(FullName, Address1, City, State, Zipcode, user_ID)
          VALUES ('$fullName', '$address1', '$city', '$state', '$zip', '$email')";
        $result = mysqli_query($con, $query);

          if($result)
          {
            header("Location: fuelQuoteForm.php");

          }
          //else {
          //  echo "<div class='text-red'><br>ERROR ADDING DATA!</div>";
          //}
      }
      
      //once information is stored in the database proceed to the fuel quote form
      header("Location: fuelQuoteForm.php");
      exit();
    }
    else
    {
      //invalid inputs
      header("Location: clientProfileManagement.html");
      exit('Invalid inputs');
    }
  }
    
?>
