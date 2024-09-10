<?php
session_start();
include('vendor/inc/config.php'); 
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Update Driver Details code
if (isset($_POST['update_driver'])) {
    $d_id = $_GET['d_id'];
    $d_fname = $_POST['d_fname'];
    $d_lname = $_POST['d_lname'];
    $d_phone = $_POST['d_phone'];
    $d_license = $_POST['d_license'];
    $d_addr = $_POST['d_addr'];
    $d_email = $_POST['d_email'];

    // Prepare the SQL query
    $query = "UPDATE tms_driver SET d_fname=?, d_lname=?, d_phone=?, d_license=?, d_addr=?, d_email=? WHERE d_id=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param('ssisssi', $d_fname, $d_lname, $d_phone, $d_license, $d_addr, $d_email, $d_id);

        if ($stmt->execute()) {
            $succ = "Driver Updated";
        } else {
            $err = "Error: Could not execute the update. Please try again.";
        }

        $stmt->close();
    } else {
        $err = "Error: Could not prepare the query. Please try again.";
    }
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
                    <li class="breadcrumb-item active">Update Driver</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Update Driver
                    </div>
                    <div class="card-body">
                        <!-- Form -->
                        <?php
                        $aid = $_GET['d_id'];
                        $ret = "SELECT * FROM tms_driver WHERE d_id=?";
                        $stmt = $mysqli->prepare($ret);
                        
                        if ($stmt) {
                            $stmt->bind_param('i', $aid);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            while ($row = $res->fetch_object()) {
                        ?>
                        
                        <form method="POST">
                            <div class="form-group">
                                <label for="d_fname">First Name</label>
                                <input type="text" value="<?php echo $row->d_fname; ?>" required class="form-control" id="d_fname" name="d_fname">
                            </div>
                            <div class="form-group">
                                <label for="d_lname">Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $row->d_lname; ?>" id="d_lname" name="d_lname">
                            </div>
                            <div class="form-group">
                                <label for="d_phone">Contact</label>
                                <input type="text" class="form-control" value="<?php echo $row->d_phone; ?>" id="d_phone" name="d_phone">
                            </div>
                            <div class="form-group">
                                <label for="d_license">Driving License No</label>
                                <input type="text" class="form-control" value="<?php echo $row->d_license; ?>" id="d_license" name="d_license">
                            </div>
                            <div class="form-group">
                                <label for="d_addr">Address</label>
                                <input type="text" class="form-control" value="<?php echo $row->d_addr; ?>" id="d_addr" name="d_addr">
                            </div>
                            <div class="form-group">
                                <label for="d_email">Email address</label>
                                <input type="email" value="<?php echo $row->d_email; ?>" class="form-control" id="d_email" name="d_email">
                            </div>

                            <button type="submit" name="update_driver" class="btn btn-success">Update Driver</button>
                        </form>
                        
                        <?php 
                            }
                            $stmt->close();
                        } else {
                            echo "Error: Could not prepare the query.";
                        }
                        ?>
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
