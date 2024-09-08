<?php
session_start();
include('vendor/inc/config.php'); // Include configuration file

// Add User
if (isset($_POST['add_user'])) {
    $u_fname = $_POST['u_fname'];
    $u_lname = $_POST['u_lname'];
    $u_phone = $_POST['u_phone'];
    $u_NIC = $_POST['u_NIC'];
    $u_addr = $_POST['u_addr'];
    $u_email = $_POST['u_email'];
    $u_pwd = $_POST['u_pwd'];
    $u_category = $_POST['u_category'];

    // Hash the password using MD5
    $hashed_pwd = md5($u_pwd);

    // Prepare the SQL query
    $query = "INSERT INTO tms_user (u_fname, u_lname, u_phone, u_license_or_ID, u_addr, u_category, u_email, u_pwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param('ssssssss', $u_fname, $u_lname, $u_phone, $u_NIC, $u_addr, $u_category, $u_email, $hashed_pwd);

        // Execute the query
        if ($stmt->execute()) {
            $succ = "Account Created. Proceed To Log In";
        } else {
            $err = "Error: Could not execute the query. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $err = "Error: Could not prepare the query. Please try again.";
    }

    // Close the database connection
    $mysqli->close();
}
?>
<!--End Server Side Scripting-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Transport Management System, Saccos, Matwana Culture">
    <meta name="author" content="MartDevelopers ">

    <title>City Taxi Client - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">
    <?php if (isset($succ)) { ?>
    <!--This code for injecting an alert-->
    <script>
    setTimeout(function() {
            swal("Success!", "<?php echo $succ; ?>", "success");
        },
        100);
    </script>
    <?php } ?>
    <?php if (isset($err)) { ?>
    <!--This code for injecting an alert-->
    <script>
    setTimeout(function() {
            swal("Failed!", "<?php echo $err; ?>", "error");
        },
        100);
    </script>
    <?php } ?>
    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">Create An Account With Us</div>
            <div class="card-body">
                <!--Start Form-->
                <form method="post">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" required class="form-control" id="exampleInputEmail1" name="u_fname">
                                    <label for="firstName">First name</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" id="u_lname" name="u_lname">
                                    <label for="u_lname">Last name</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" id="u_phone" name="u_phone">
                                    <label for="u_phone">Contact</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-label-group">
                                    <input type="text" class="form-control" id="u_NIC" name="u_NIC">
                                    <label for="u_NIC">NIC No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="text" class="form-control" id="u_addr" name="u_addr">
                            <label for="u_addr">Address</label>
                        </div>
                    </div>
                    <div class="form-group" style="display:none">
                        <div class="form-label-group">
                            <input type="text" class="form-control" id="exampleInputEmail1" value="User" name="u_category">
                            <label for="inputEmail">User Category</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" class="form-control" name="u_email">
                            <label for="inputEmail">Email address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="password" class="form-control" name="u_pwd" id="exampleInputPassword1">
                                    <label for="inputPassword">Password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="add_user" class="btn btn-success">Create Account</button>
                </form>
                <!--End Form-->
                <div class="text-center">
                    <a class="d-block small mt-3" href="index.php">Login Page</a>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!--Inject Sweet alert js-->
    <script src="vendor/js/swal.js"></script>

</body>
</html>
