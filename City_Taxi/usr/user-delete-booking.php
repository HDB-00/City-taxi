<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['u_id'];

// Delete Booking
if (isset($_POST['delete_booking'])) {
    $u_id = $_SESSION['u_id'];
    $u_car_regno = $_POST['u_car_regno'];
    $u_car_type = $_POST['u_car_type'];
    $v_id_query = "SELECT v_id FROM tms_vehicle WHERE v_reg_no=?";
    $stmt = $mysqli->prepare($v_id_query);
    $stmt->bind_param('s', $u_car_regno);
    $stmt->execute();
    $stmt->bind_result($v_id);
    $stmt->fetch();
    $stmt->close();

    // Update the booking status in tms_user
    $query = "UPDATE tms_user SET u_car_type=?, u_car_regno=?, u_car_bookdate=?, u_car_book_status='Canceled' WHERE u_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssi', $u_car_type, $u_car_regno, $_POST['u_car_bookdate'], $u_id);
    $stmt->execute();

    // If booking is canceled successfully, update the vehicle status to 'Available'
    if ($stmt) {
        $update_query = "UPDATE tms_vehicle SET v_status='Available' WHERE v_id=?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('i', $v_id);
        $update_stmt->execute();
        $update_stmt->close();

        $succ = "Booking Cancelled and Vehicle Status Updated";
    } else {
        $err = "Please Try Again Later";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('vendor/inc/head.php');?>

<body id="page-top">
    <!--Start Navigation Bar-->
    <?php include("vendor/inc/nav.php");?>
    <!--Navigation Bar-->

    <div id="wrapper">
        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php");?>
        <!--End Sidebar-->

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ;?>", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err;?>", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="user-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Booking</li>
                    <li class="breadcrumb-item active">Cancel My Booking</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Cancel Booking
                    </div>
                    <div class="card-body">
                        <!--Cancel Booking Form-->
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
                                <label for="exampleInputEmail1">First Name</label>
                                <input type="text" readonly value="<?php echo $row->u_fname;?>" required class="form-control" id="exampleInputEmail1" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Name</label>
                                <input type="text" readonly class="form-control" value="<?php echo $row->u_lname;?>" id="exampleInputEmail1" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Contact</label>
                                <input type="text" readonly class="form-control" value="<?php echo $row->u_phone;?>" id="exampleInputEmail1" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <input type="text" readonly class="form-control" value="<?php echo $row->u_addr;?>" id="exampleInputEmail1" name="u_addr">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" readonly value="<?php echo $row->u_email;?>" class="form-control" name="u_email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehicle Category</label>
                                <input type="text" readonly value="<?php echo $row->u_car_type;?>" class="form-control" name="u_car_type">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehicle Registration Number</label>
                                <input type="text" readonly value="<?php echo $row->u_car_regno;?>" class="form-control" name="u_car_regno">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Booking Date</label>
                                <input type="text" readonly value="<?php echo $row->u_car_bookdate;?>" class="form-control" name="u_car_bookdate">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Booking Status</label>
                                <input type="text" readonly value="<?php echo $row->u_car_book_status;?>" class="form-control" id="exampleInputEmail1" name="u_car_book_status">
                            </div>

                            <button type="submit" name="delete_booking" class="btn btn-danger">Cancel Booking</button>
                        </form>
                        <!-- End Form-->
                        <?php }?>
                    </div>
                </div>

                <hr>
                <!-- Sticky Footer -->
                <?php include("vendor/inc/footer.php");?>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#wrapper -->

        <!-- Scroll to Top Button-->
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
                        <a class="btn btn-danger" href="user-logout.php">Logout</a>
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
        <script src="vendor/js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="vendor/js/demo/datatables-demo.js"></script>
        <script src="vendor/js/demo/chart-area-demo.js"></script>
        <!-- Inject SweetAlert JS -->
        <script src="vendor/js/swal.js"></script>
    </div>
</body>
</html>
