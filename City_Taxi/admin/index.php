<?php
session_start();
include('vendor/inc/config.php'); 

if (isset($_POST['admin_login'])) {
    $a_email = $_POST['a_email'];
    $a_pwd = $_POST['a_pwd']; 

    // Hash the password using md5
    $hashed_pwd = md5($a_pwd);

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("SELECT a_id, a_pwd FROM tms_admin WHERE a_email = ?");
    $stmt->bind_param('s', $a_email); 
    $stmt->execute(); 
    $stmt->bind_result($a_id, $db_pwd); 

    if ($stmt->fetch()) { 
        // Compare the input password hashed with the stored hashed password
        if ($hashed_pwd === $db_pwd) { 
            $_SESSION['a_id'] = $a_id; 
            header("location:admin-dashboard.php");
        } else {
            $error = "Admin Username & Password Not Match";
        }
    } else {
        $error = "Admin Username & Password Not Match";
    }

    $stmt->close(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vehicle Booking System Transport Saccos, Matatu Industry">
    <meta name="author" content="MartDevelopers">
    <title>Online Car Booking System - Admin Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <?php if (isset($error)) { ?>
    <script>
    setTimeout(function() {
            swal("Failed!", "<?php echo $error; ?>", "error");
        }, 100);
    </script>
    <?php } ?>
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login For Admin</div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" id="inputEmail" name="a_email" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                            <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" id="inputPassword" name="a_pwd" class="form-control" placeholder="Password" required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    
                    <input type="submit" class="btn btn-success btn-block" name="admin_login" value="Login">
                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" href="../index.php">Home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/js/swal.js"></script>
</body>
</html>
