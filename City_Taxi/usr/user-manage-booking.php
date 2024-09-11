<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid = $_SESSION['u_id'];
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
                    <li class="breadcrumb-item active">Manage My Booking</li>
                </ol>
                
                <?php
                if(isset($_GET['success'])) {
                    echo '<div class="alert alert-success">' . $_GET['success'] . '</div>';
                }
                if(isset($_GET['error'])) {
                    echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
                }
                ?>

                <!-- My Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Bookings
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Vehicle Reg No</th>
                                        <th>Driver Name</th>
                                        <th>Driver Contact</th>
                                        <th>Pickup Location</th>
                                        <th>Return Location</th>
                                        <th>Amount</th>
                                        <th>Booking Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                    $aid = $_SESSION['u_id'];
                    $ret = "SELECT b.*, v.v_reg_no, d.d_fname, d.d_lname, d.d_phone 
                            FROM tms_bookings b
                            JOIN tms_vehicle v ON b.v_id = v.v_id
                            LEFT JOIN tms_driver d ON v.d_id = d.d_id
                            WHERE b.u_id = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $aid);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while($row = $res->fetch_object())
                    {
                ?>
                                    <tr>
                                        <td><?php echo $row->b_id;?></td>
                                        <td><?php echo $row->v_reg_no;?></td>
                                        <td><?php echo $row->d_fname . ' ' . $row->d_lname;?></td>
                                        <td><?php echo $row->d_phone;?></td>
                                        <td><?php echo $row->pickup_location;?></td>
                                        <td><?php echo $row->return_location;?></td>
                                        <td><?php echo $row->hire;?></td>
                                        <td><?php echo $row->b_date;?></td>
                                        <td>
                                            <?php 
                                            switch($row->b_status) {
                                                case "Pending":
                                                    echo '<span class="badge badge-warning">'.$row->b_status.'</span>';
                                                    break;
                                                case "Ongoing":
                                                    echo '<span class="badge badge-primary">'.$row->b_status.'</span>';
                                                    break;
                                                case "Ended":
                                                    echo '<span class="badge badge-success">'.$row->b_status.'</span>';
                                                    break;
                                                case "Cancelled":
                                                    echo '<span class="badge badge-danger">'.$row->b_status.'</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-secondary">'.$row->b_status.'</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch($row->b_status) {
                                                case "Pending":
                                                case "Cancelled":
                                                    echo 'No action available';
                                                    break;
                                                case "Ongoing":
                                                    echo '<a href="user-give-trip-feedback.php?b_id='.$row->b_id.'" class="btn btn-primary btn-sm">Give Feedback</a>';
                                                    break;
                                                case "Ended":
                                                    echo '<a href="user-make-payment.php?b_id='.$row->b_id.'&amount='.urlencode($row->hire).'" class="btn btn-success btn-sm mr-2">Make Payment</a>';
                                                    echo '<a href="user-give-trip-feedback.php?b_id='.$row->b_id.'" class="btn btn-primary btn-sm">Give Feedback</a>';
                                                    break;
                                                default:
                                                    echo 'No action available';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php  }?>
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
