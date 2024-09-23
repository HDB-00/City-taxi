<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $uid = $_SESSION['u_id'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include("vendor/inc/head.php");?>


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
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="user-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Booking</li>
                    <li class="breadcrumb-item active">View My Bookings</li>
                </ol>
                
                <!-- My Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        My Bookings
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Driver Name</th>
                                        <th>Driver Contact No</th>
                                        <th>Vehicle Type</th>
                                        <th>Vehicle Reg. No</th>
                                        <th>Pickup Location</th>
                                        <th>Return Location</th>
                                        <th>Amount</th>
                                        <th>Booking Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT b.*, v.v_category, v.v_reg_no, d.d_fname, d.d_lname, d.d_phone
                                            FROM tms_bookings b
                                            JOIN tms_vehicle v ON b.v_id = v.v_id
                                            LEFT JOIN tms_driver d ON v.d_id = d.d_id
                                            WHERE b.u_id = ?";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $uid);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row->b_id; ?></td>
                                            <td><?php echo $row->d_fname . ' ' . $row->d_lname; ?></td>
                                            <td><?php echo $row->d_phone; ?></td>
                                            <td><?php echo $row->v_category; ?></td>
                                            <td><?php echo $row->v_reg_no; ?></td>
                                            <td><?php echo $row->pickup_location; ?></td>
                                            <td><?php echo $row->return_location; ?></td>
                                            <td><?php echo $row->hire; ?></td>
                                            <td><?php echo $row->b_date; ?></td>
                                            <td>
                                                <?php 
                                                if($row->b_status == "Pending"){ 
                                                    echo '<span class="badge badge-warning">'.$row->b_status.'</span>'; 
                                                } elseif($row->b_status == "Approved") {
                                                    echo '<span class="badge badge-success">'.$row->b_status.'</span>';
                                                } else {
                                                    echo '<span class="badge badge-secondary">'.$row->b_status.'</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <?php include("vendor/inc/footer.php");?>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <?php include("vendor/inc/logout.php");?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vendor/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="vendor/js/demo/datatables-demo.js"></script>

</body>
</html>