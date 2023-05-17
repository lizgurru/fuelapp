<?php
    include("connection.php")  ;
    function createAccount($email, $password, $confirmPassword, $con) {
        $query = "SELECT * FROM usercredentials WHERE ID='$email'";
        $exists = mysqli_query($con, $query);

        if(!$exists || $password != $confirmPassword || $password == "" || $email == ""){
            return false;
        } else {
            return true;
        }
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    $result = createAccount($email, $password, $confirmPassword, $con);

    if($result){
        //encrypt password
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        //add account to db
        $query = "INSERT INTO usercredentials (ID, password)
                  VALUES ('$email', '$encryptedPassword')";
        $result = $con->query($query);
        //$result = mysqli_query($con, $query);

        /*if ($result) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $con->error;
          }*/

        //create session
        session_start();
        $_SESSION['email'] = $email;
        //redirects to clientProfileManagement for user to input details
        header("Location: clientProfileManagement.html");
        exit();
    } else {
        header("Location: clientRegistration.html?error=1");
        exit();
    }

?>