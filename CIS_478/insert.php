<?php
session_start();

        // Prepare an insert statement
        $sql = "INSERT INTO login_users (name, email, username, password) VALUES (? , ? , ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){

			// Set parameters
			$param_name = $name;
			$param_email = $email;
            $param_username = $username;

			// Creates a password hash
            $param_password = password_hash($password, PASSWORD_BCRYPT);
			
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_username, $param_password);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				header("location: activate.php";
            } else{
                echo "Something went wrong. Please try again.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
?>