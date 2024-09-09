<?php
session_start();
include('vendor/inc/config.php'); // Include configuration file

if(isset($_POST['user_login'])) {
    $u_email = $_POST['u_email'];
    $u_pwd = $_POST['u_pwd'];

    // Hash the entered password using MD5
    $hashed_pwd = md5($u_pwd);

  
    $stmt = $mysqli->prepare("SELECT u_email, u_pwd, u_id FROM tms_user WHERE u_email=? AND u_pwd=?");
    $stmt->bind_param('ss', $u_email, $hashed_pwd); 
    $stmt->execute();
    $stmt->store_result(); 
    $stmt->bind_result($db_email, $db_pwd, $u_id);

    $rs = $stmt->fetch();

    if($rs) { // 
        $_SESSION['u_id'] = $u_id;
        header("location:driver-dashboard.php"); 
        exit();
    } else {
        $error = "Username & Password do not match";
    }

    $stmt->close(); 
    $mysqli->close(); 
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>City Taxi - Driver Login</title>


    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="vendor/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
    
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login For Driver</div>
            <div class="card-body">

                <?php if(isset($error)) { ?>
          
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
                    <a class="d-block small mt-3" href="driver-register.php">Register an Account</a>
                    <a class="d-block small" href="../index.php">Home</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  
    <script src="vendor/js/swal.js"></script>

</body>
</html>
