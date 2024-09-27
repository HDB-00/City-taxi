<?php
session_start();
include('vendor/inc/config.php'); // Include the configuration file

if (isset($_POST['user_login'])) {
    $u_email = $_POST['u_email'];
    $u_pwd = $_POST['u_pwd'];

    // Hash the password using MD5 to match it with the hashed password in the database
    $hashed_pwd = md5($u_pwd);

    // Prepare the SQL statement to retrieve the user details based on the email and hashed password
    $stmt = $mysqli->prepare("SELECT o_id FROM tms_operator WHERE o_email = ? AND o_pwd = ?");
    if ($stmt) {
        $stmt->bind_param('ss', $u_email, $hashed_pwd); // Bind email and hashed password parameters
        $stmt->execute(); // Execute the query
        $stmt->store_result(); // Store the result to check if any row is returned
        $stmt->bind_result($u_id); // Bind result variables

        if ($stmt->num_rows > 0) {
            $stmt->fetch(); // Fetch the result
            
            // Login successful, set session and redirect to dashboard
            $_SESSION['u_id'] = $u_id; // Assign session to user id
            header("location:operator-dashboard.php"); // Redirect to operator dashboard
            exit();
        } else {
            $error = "User Name & Password Not Match"; // Set error message for incorrect credentials
        }

        $stmt->close(); // Close the statement
    } else {
        $error = "Error: Could not prepare SQL statement.";
    }
}

$mysqli->close(); // Close the database connection
?>

<!--End Server Side Script Injection-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>City Taxi - Telephone Operator Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
    
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login For Telephone Operator</div>
            <div class="card-body">
                <!-- Inject Sweet Alert for Errors -->
                <?php if (isset($error)) { ?>
                <!-- This code for injecting an alert -->
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $error;?>", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Login Form -->
                <form method="POST">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="u_email" id="inputEmail" class="form-control" required="required" autofocus="autofocus">
                            <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="u_pwd" id="inputPassword" class="form-control" required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <input type="submit" name="user_login" class="btn btn-success btn-block" value="Login">
                </form>
                <div class="text-center">
                    <a class="d-block small" href="../index.php">Home</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Inject Sweet Alert JS -->
    <script src="vendor/js/swal.js"></script>

</body>
</html>
