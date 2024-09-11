<?php
session_start();
include('vendor/inc/config.php');  
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Add Operator code
if (isset($_POST['add_operator'])) {
    $o_fname = $_POST['o_fname'];
    $o_lname = $_POST['o_lname'];
    $o_phone = $_POST['o_phone'];
    $o_nic = $_POST['o_nic'];
    $o_addr = $_POST['o_addr'];
    $o_email = $_POST['o_email'];
    $o_pwd = $_POST['o_pwd'];

    // Hash the password using MD5
    $hashed_pwd = md5($o_pwd);

    // Prepare the SQL query
    $query = "INSERT INTO tms_operator (o_fname, o_lname, o_phone, o_nic, o_addr, o_email, o_pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param('sssssss', $o_fname, $o_lname, $o_phone, $o_nic, $o_addr, $o_email, $hashed_pwd);

        if ($stmt->execute()) {
            $succ = "Operator Added Successfully";
        } else {
            $err = "Error: Could not execute the query. Please try again. " . $stmt->error;
        }

        $stmt->close();
    } else {
        $err = "Error: Could not prepare the query. Please try again. " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <?php if (isset($succ)) { ?>
        <!--This code for injecting an alert-->
        <script>
            setTimeout(function() {
                swal("Success!", "<?php echo $succ; ?>", "success");
            }, 100);
        </script>
    <?php } ?>
    <?php if (isset($err)) { ?>
        <!--This code for injecting an alert-->
        <script>
            setTimeout(function() {
                swal("Failed!", "<?php echo $err; ?>", "error");
            }, 100);
        </script>
    <?php } ?>

    <?php include("vendor/inc/nav.php"); ?>

    <div id="wrapper">
        <?php include("vendor/inc/sidebar.php"); ?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                    <script>
                        setTimeout(function() {
                            swal("Success!", "<?php echo $succ; ?>", "success");
                        }, 100);
                    </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                    <script>
                        setTimeout(function() {
                            swal("Failed!", "<?php echo $err; ?>", "error");
                        }, 100);
                    </script>
                <?php } ?>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Telephone Operator</a>
                    </li>
                    <li class="breadcrumb-item active">Add Telephone Operator</li>
                </ol>
                <hr>
                
                <div class="card">
                    <div class="card-header">
                        Add Telephone Operator
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="o_fname">First Name</label>
                                <input type="text" required class="form-control" id="o_fname" name="o_fname">
                            </div>
                            <div class="form-group">
                                <label for="o_lname">Last Name</label>
                                <input type="text" class="form-control" id="o_lname" name="o_lname">
                            </div>
                            <div class="form-group">
                                <label for="o_phone">Contact</label>
                                <input type="text" class="form-control" id="o_phone" name="o_phone">
                            </div>
                            <div class="form-group">
                                <label for="o_nic">NIC No</label>
                                <input type="text" class="form-control" id="o_nic" name="o_nic">
                            </div>
                            <div class="form-group">
                                <label for="o_addr">Address</label>
                                <input type="text" class="form-control" id="o_addr" name="o_addr">
                            </div>
                            <div class="form-group">
                                <label for="o_email">Email Address</label>
                                <input type="email" class="form-control" id="o_email" name="o_email">
                            </div>
                            <div class="form-group">
                                <label for="o_pwd">Password</label>
                                <input type="password" class="form-control" id="o_pwd" name="o_pwd">
                            </div>

                            <button type="submit" name="add_operator" class="btn btn-success">Add Telephone Operator</button>
                        </form>
                    </div>
                </div>

                <hr>

                <?php include("vendor/inc/footer.php"); ?>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

</body>
</html>
