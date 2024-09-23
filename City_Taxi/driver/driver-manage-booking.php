<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $d_id = $_SESSION['d_id'];

  // End Trip
  if(isset($_GET['end_trip'])) {
      $b_id = $_GET['end_trip'];
      $b_status = 'Ended';
      
      $query = "UPDATE tms_bookings SET b_status=? WHERE b_id=? AND d_id=?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('sii', $b_status, $b_id, $d_id);
      $stmt->execute();
      
      if($stmt) {
          $_SESSION['success'] = "Trip Ended Successfully";
          header("Location: driver-manage-booking.php");
          exit();
      } else {
          $err = "Please Try Again Later";
      }
  }
?>
<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

<body id="page-top">

    <?php include("vendor/inc/nav.php");?>
    
    <div id="wrapper">

        <?php include('vendor/inc/sidebar.php');?>

        <div id="content-wrapper">

            <div class="container-fluid">
                
                <?php
                if(isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            ' . $_SESSION['success'] . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                    unset($_SESSION['success']);
                }
                ?>
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Bookings</a>
                    </li>
                    <li class="breadcrumb-item active">Manage</li>
                </ol>
                
                <!--Bookings-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Manage Bookings
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pickup Location</th>
                                        <th>Return Location</th>
                                        <th>Booking Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM tms_bookings WHERE d_id = ? ORDER BY b_date DESC";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param('i', $d_id);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    $cnt = 1;
                                    while ($row = $res->fetch_object()) {
                                    ?>
                                    
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row->pickup_location;?></td>
                                        <td><?php echo $row->return_location;?></td>
                                        <td><?php echo $row->b_date;?></td>
                                        <td><?php echo $row->hire;?></td>
                                        <td>
                                            <?php 
                                            switch($row->b_status) {
                                                case "Pending":
                                                    echo '<span class="badge badge-warning">'.$row->b_status.'</span>';
                                                    break;
                                                case "Approved":
                                                    echo '<span class="badge badge-success">'.$row->b_status.'</span>';
                                                    break;
                                                case "Ongoing":
                                                    echo '<span class="badge badge-info">'.$row->b_status.'</span>';
                                                    break;
                                                case "Ended":
                                                    echo '<span class="badge badge-secondary">'.$row->b_status.'</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-dark">'.$row->b_status.'</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($row->b_status == "Pending"){ ?>
                                                <a href="driver-approve-booking.php?b_id=<?php echo $row->b_id;?>" class="badge badge-success"><i class="fa fa-check"></i> Accept</a>
                                            <?php } elseif($row->b_status == "Ongoing") { ?>
                                                <a href="driver-manage-booking.php?end_trip=<?php echo $row->b_id;?>" class="badge badge-danger"><i class="fa fa-stop"></i> End Trip</a>
                                            <?php } else { ?>
                                                <span class="badge badge-secondary">No Action</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>

                                </tbody>
                            </table>
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
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>

</body>
</html>
