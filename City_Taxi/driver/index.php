<?php
session_start();
include('vendor/inc/config.php'); // Include configuration file

if (isset($_POST['driver_login'])) {
    $d_email = $_POST['d_email'];
    $d_pwd = $_POST['d_pwd'];

    // Hash the entered password using MD5 to match the stored hash
    $hashed_pwd = md5($d_pwd);

    // Prepare the SQL statement to retrieve the driver details
    $stmt = $mysqli->prepare("SELECT d_id, d_fname, d_lname, d_phone, d_license, d_addr FROM tms_driver WHERE d_email = ? AND d_pwd = ?");
    if ($stmt) {
        $stmt->bind_param('ss', $d_email, $hashed_pwd);
        $stmt->execute(); // Remove any arguments from execute()
        $stmt->store_result();
        $stmt->bind_result($d_id, $d_fname, $d_lname, $d_phone, $d_license, $d_addr);

        if ($stmt->fetch()) {
            // Login successful
            $_SESSION['d_id'] = $d_id;
            $_SESSION['d_fname'] = $d_fname;
            $_SESSION['d_lname'] = $d_lname;
            $_SESSION['d_phone'] = $d_phone;
            $_SESSION['d_license'] = $d_license;
            $_SESSION['d_addr'] = $d_addr;
            $_SESSION['d_email'] = $d_email;
            
            // Redirect to driver dashboard
            header("Location: driver-dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }

        $stmt->close();
    } else {
        $error = "Error: Could not prepare SQL statement.";
    }
}

$mysqli->close();
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

    <title>Driver Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="vendor/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
    
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login For Driver</div>
            <div class="card-body">
                <!--Inject Sweet Alerts-->
                <?php if (isset($error)) { ?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $error; ?>", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Login Form -->
                <form method="POST">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" name="d_email" id="inputEmail" class="form-control" required="required" autofocus="autofocus">
                            <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" name="d_pwd" id="inputPassword" class="form-control" required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <input type="submit" name="driver_login" class="btn btn-primary btn-block" value="Login">
                </form>
                
                <div class="text-center">
                    <a class="d-block small mt-3" href="driver-register.php">Register an Account</a>
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
    <!--INject Sweet alert js-->
    <script src="vendor/js/swal.js"></script>
</body>
</html>
