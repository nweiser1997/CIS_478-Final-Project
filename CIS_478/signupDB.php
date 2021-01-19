<?php
// Connect to database
 require_once 'database.php';
 
// Create & initialize new field variables and error variables
$name = $email = $username = $password = $confirmPassword = $ip = "";
$name_error = $email_error =  $username_error = $password_error = $confirmPassword_error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $name = trim($_POST["name"]);
	

	// VALIDATE EMAIL FUNCTION NEEDS MORE WORK	
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_error = "Please enter your email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM login_users WHERE email = ?";
 
          // Set parameters
        $param_email = $email;
		
        if($stmt = mysqli_prepare($link, $sql)){
 
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $email);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
 
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_error = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
			
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
	
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM login_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
			
			// Set parameters
            $param_username = trim($_POST["username"]);
			
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_error = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 15){
        $password_error = "Password must be the combination of 15 characters, including upper and lower cases, numbers, special cases";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPassword_error = "Please confirm password.";     
    } else{
        $confirmPassword = trim($_POST["confirmPassword"]);
        if(empty($password_error) && ($password != $confirmPassword)){
            $confirmPassword_error = "Password did not match.";
        }
    }
	
	// Validate security questions
	if (empty(trim($_POST["sec1Fld"])))
	{
		$sec1_error = "Please answer the first security question.";
	}
	
	if (empty(trim($_POST["sec2Fld"])))
	{
		$sec2_error = "Please answer the second security question.";
	}
	
	if (empty(trim($_POST["sec3Fld"])))
	{
		$sec3_error = "Please answer the third security question.";
	}
	
        // Check input errors before inserting in database
    if(empty($name_error) && empty($email_error) && empty($username_error) && empty($password_error) && empty($confirmPassword_error && empty($sec1_error) && empty($sec2_error) && empty($sec3_error))){
		
		// Generates random 6-digit one-time security code
		$code=substr(mt_rand(),0,6);

 // Prepare a select statement
        $sql = "INSERT INTO login_otp (otp,expired,created) VALUES ('" . $code . "', 0, '" . date("Y-m-d H:i:s"). "')";
 
          // Set parameters
        $param_otp = $code;
		
        if($stmt = mysqli_prepare($link, $sql)){
 
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_otp);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

				// Set security questions' answers
				// Prepare an update statement
					$sec1ans = $_POST["sec1Fld"];
					$sec2ans = $_POST["sec2Fld"];
					$sec3ans = $_POST["sec3Fld"];
					$sec1sql = "UPDATE login_users SET Security1 = '$sec1ans',
							Security2 = '$sec2ans', Security3 = '$sec3ans' 
							WHERE username = '$username'";
				
				// Execute the query
				mysqli_query($link, $sec1sql);
				
				// Redirect to login page
				header("location: login.php");
						
				$body = 'Thanks for signing up, ' .$username . '! Here is your one-time security code: '. $code. '.
						
Please click this link to activate your account: http://bscacad3.buffalostate.edu/~abdikaqa01/loginsystem/activate.php?username='.$username.'
		  		  
				';
				$to = $email;
				$subject = "Registration security code";
				$from = "LOGINSYSTEM@NO-REPLY.COM";
				$headers = "From:".$from;
				mail($to,$subject,$body,$headers);
				
				
        // Prepare an insert statement
        $sql = "INSERT INTO login_users (name, email, username, password, IpAddress, Security1, Security2, Security3) VALUES (? , ? , ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){

			//Gets the IP address
			if (!empty($_SERVER['HTTP_CLIENT_IP']))
			{
				$param_ip = $_SERVER['HTTP_CLIENT_IP'];
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
				$param_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				$param_ip = $_SERVER['REMOTE_ADDR'];
			}

			// Set parameters
			$param_name = $name;
			$param_email = $email;
            $param_username = $username;
			$param_secfld1 = $_POST["sec1Fld"];
			$param_secfld2 = $_POST["sec2Fld"];
			$param_secfld3 = $_POST["sec3Fld"];
			
			// Creates a password hash
            $param_password = password_hash($password, PASSWORD_BCRYPT);
			
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_name, $param_email, $param_username, $param_password, $param_ip, $param_secfld1, $param_secfld2, $param_secfld3);
			
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				echo "A security code has been sent to you.";	
				
            } else{
                echo "Something went wrong. Please try again.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
			}
			else{
                echo "Email could not be sent. Please check your email and try again.";
            }
		} 

            // Close statement
            mysqli_stmt_close($stmt);
        }
		
		
	// Close connection
    mysqli_close($link);
}	
?>