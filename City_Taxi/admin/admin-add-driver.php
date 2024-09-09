<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Add Driver Code
if (isset($_POST['add_driver'])) {
    $u_fname = $_POST['u_fname'];
    $u_lname = $_POST['u_lname'];
    $u_phone = $_POST['u_phone'];
    $u_license_or_ID = $_POST['u_license_or_ID'];
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
        $stmt->bind_param('ssssssss', $u_fname, $u_lname, $u_phone, $u_license_or_ID, $u_addr, $u_category, $u_email, $hashed_pwd);

        
        if ($stmt->execute()) {
            $succ = "Driver Added";
        } else {
            $err = "Error: Could not execute the query. Please try again.";
        }

        
        $stmt->close();
    } else {
        $err = "Error: Could not prepare the query. Please try again.";
    }

    
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">

    <!--Navigation Bar-->
    <?php include("vendor/inc/nav.php"); ?>
    
    
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php"); ?>
        
        <div id="content-wrapper">
            
            <div class="container-fluid">
                <?php if (isset($succ)) { ?>

                <!--code for an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ; ?>", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err; ?>", "error");
                    },
                    100);
                </script>
                <?php } ?>
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Drivers</a>
                    </li>
                    <li class="breadcrumb-item active">Add Driver</li>
                </ol>
                <hr>
                
                <div class="card">
                    <div class="card-header">
                        Add Driver
                    </div>
                    <div class="card-body">
                        <!--Add User Form-->
                        <form method="POST">
                            <div class="form-group">
                                <label for="u_fname">First Name</label>
                                <input type="text" required class="form-control" id="u_fname" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="u_lname">Last Name</label>
                                <input type="text" class="form-control" id="u_lname" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="u_phone">Contact</label>
                                <input type="text" class="form-control" id="u_phone" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="u_license_or_ID">Driving License No</label>
                                <input type="text" class="form-control" id="u_license_or_ID" name="u_license_or_ID">
                            </div>
                            <div class="form-group">
                                <label for="u_addr">Address</label>
                                <input type="text" class="form-control" id="u_addr" name="u_addr">
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="u_category">Category</label>
                                <input type="text" class="form-control" id="u_category" value="Driver" name="u_category">
                            </div>
                            <div class="form-group">
                                <label for="u_email">Email Address</label>
                                <input type="email" class="form-control" id="u_email" name="u_email">
                            </div>
                            <div class="form-group">
                                <label for="u_pwd">Password</label>
                                <input type="password" class="form-control" id="u_pwd" name="u_pwd">
                            </div>

                            <button type="submit" name="add_driver" class="btn btn-success">Add Driver</button>
                        </form>
                        
                    </div>
                </div>

                <hr>

                <!-- Footer -->
                <?php include("vendor/inc/footer.php"); ?>

            </div>
            

        </div>
        

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        
        <!-- Logout code-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModal">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="admin-logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript code-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Page level plugin JavaScript code-->
        <script src="vendor/chart.js/Chart.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="vendor/js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="vendor/js/demo/datatables-demo.js"></script>
        <script src="vendor/js/demo/chart-area-demo.js"></script>
        
        <!--Inject Sweet alert js-->
        <script src="vendor/js/swal.js"></script>
        
</body>
</html>
