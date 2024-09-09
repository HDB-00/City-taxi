<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['a_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Vehicle Booking System Transport Saccos, Matatu Industry">
    <meta name="author" content="MartDevelopers">

    <title>City Taxi - Admin Dashboard</title>

    <!-- Custom fonts-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    
    <link href="vendor/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

    <!--Navigation Bar-->
    <?php include("vendor/inc/nav.php");?>
    

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php");?>
        
        <div id="content-wrapper">

            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="admin-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Overview</li>
                </ol>

                <!-- Icon Cards-->
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-dark o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-users"></i>
                                </div>
                                <?php
                                  $result ="SELECT count(*) FROM tms_user";
                                  $stmt = $mysqli->prepare($result);
                                  $stmt->execute();
                                  $stmt->bind_result($user);
                                  $stmt->fetch();
                                  $stmt->close();
                                ?>
                                <div class="mr-5"><span class="badge badge-danger"><?php echo $user;?></span> Users</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="admin-view-user.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-dark o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa fa-id-card"></i>
                                </div>
                                <?php
                                  $result ="SELECT count(*) FROM tms_driver";
                                  $stmt = $mysqli->prepare($result);
                                  $stmt->execute();
                                  $stmt->bind_result($driver);
                                  $stmt->fetch();
                                  $stmt->close();
                                ?>
                                <div class="mr-5"><span class="badge badge-danger"><?php echo $driver;?></span> Drivers</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="admin-view-driver.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-dark o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa fa-bus"></i>
                                </div>
                                <?php
                                  $result ="SELECT count(*) FROM tms_vehicle";
                                  $stmt = $mysqli->prepare($result);
                                  $stmt->execute();
                                  $stmt->bind_result($vehicle);
                                  $stmt->fetch();
                                  $stmt->close();
                                ?>
                                <div class="mr-5"><span class="badge badge-danger"><?php echo $vehicle;?></span> Vehicles</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="admin-view-vehicle.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-dark o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa fa-address-book"></i>
                                </div>
                                <?php
                                  $result ="SELECT count(*) FROM tms_bookings WHERE b_status = 'Approved' OR b_status = 'Pending'";
                                  $stmt = $mysqli->prepare($result);
                                  $stmt->execute();
                                  $stmt->bind_result($book);
                                  $stmt->fetch();
                                  $stmt->close();
                                ?>
                                <div class="mr-5"><span class="badge badge-danger"><?php echo $book;?></span> Bookings</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="admin-view-booking.php">
                                <span class="float-left">View Details</span>
                                <span class="float-right">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!--Bookings Details-->
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
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>User Phone</th>
                                        <th>Vehicle Reg No</th>
                                        <th>Booking Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret="SELECT b.*, u.u_fname, u.u_lname, u.u_phone, v.v_reg_no 
                                          FROM tms_bookings b 
                                          JOIN tms_user u ON b.u_id = u.u_id 
                                          JOIN tms_vehicle v ON b.v_id = v.v_id 
                                          WHERE b.b_status = 'Approved' OR b.b_status = 'Pending'";
                                    $stmt= $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res=$stmt->get_result();
                                    $cnt=1;
                                    while($row=$res->fetch_object())
                                    {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row->u_fname;?> <?php echo $row->u_lname;?></td>
                                        <td><?php echo $row->u_phone;?></td>
                                        <td><?php echo $row->v_reg_no;?></td>
                                        <td><?php echo $row->b_date;?></td>
                                        <td>
                                            <?php 
                                            if($row->b_status == "Pending"){ 
                                                echo '<span class="badge badge-warning">'.$row->b_status.'</span>'; 
                                            } else { 
                                                echo '<span class="badge badge-success">'.$row->b_status.'</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php  $cnt = $cnt +1; }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            

            <!-- Footer -->
            <?php include("vendor/inc/footer.php");?>

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

</body>
</html>