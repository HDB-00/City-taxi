<?php
session_start();
include('vendor/inc/config.php'); 
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Update User Code
if (isset($_POST['update_user'])) {
    $u_id = $_GET['u_id'];
    $u_fname = $_POST['u_fname'];
    $u_lname = $_POST['u_lname'];
    $u_phone = $_POST['u_phone'];
    $u_addr = $_POST['u_addr'];
    $u_email = $_POST['u_email'];

    // Prepare the SQL query for update
    $query = "UPDATE tms_user SET u_fname=?, u_lname=?, u_phone=?, u_addr=?, u_email=? WHERE u_id=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param('sssssi', $u_fname, $u_lname, $u_phone, $u_addr, $u_email, $u_id);

        
        if ($stmt->execute()) {
            $succ = "User Updated";
        } else {
            $err = "Please Try Again Later";
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
                        swal("Success!", "<?php echo $succ; ?>!", "success");
                    },
                    100);
                </script>

                <?php } ?>
                <?php if (isset($err)) { ?>
                
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err; ?>!", "error");
                    },
                    100);
                </script>

                <?php } ?>

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Users</a>
                    </li>
                    <li class="breadcrumb-item active">Update User</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Update User
                    </div>
                    <div class="card-body">
                        <!--Form-->
                        <?php
            $aid = $_GET['u_id'];
            $ret = "SELECT * FROM tms_user WHERE u_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute(); 
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="First Name">First Name</label>
                                <input type="text" value="<?php echo $row->u_fname; ?>" required class="form-control"
                                    id="First Name" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="Last Name">Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_lname; ?>"
                                    id="Last Name" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="Contact">Contact</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_phone; ?>"
                                    id="Contact" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_addr; ?>"
                                    id="Address" name="u_addr">
                            </div>

                            <div class="form-group" style="display:none">
                                <label for="Category">Category</label>
                                <input type="text" class="form-control" id="Category" value="User"
                                    name="u_category">
                            </div>

                            <div class="form-group">
                                <label for="Email address">Email address</label>
                                <input type="email" value="<?php echo $row->u_email; ?>" class="form-control"
                                    name="u_email">
                            </div>

                            <button type="submit" name="update_user" class="btn btn-success">Update User</button>
                        </form>
                        
                        <?php } ?>
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal"
            aria-hidden="true">
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
        
        <!--INject Sweet alert js-->
        <script src="vendor/js/swal.js"></script>

</body>
</html>
