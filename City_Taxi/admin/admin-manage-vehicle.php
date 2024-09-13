<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['a_id'];

  if(isset($_GET['del']))
{
      $id=intval($_GET['del']);
      $adn="delete from tms_vehicle where v_id=?";
      $stmt= $mysqli->prepare($adn);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $stmt->close();	 

        if($stmt)
        {
          $succ = "Vehicle Removed";
        }
          else
          {
            $err = "Try Again Later";
          }
  }
?>

 <!DOCTYPE html>
 <html lang="en">

 <?php include('vendor/inc/head.php');?>

 <body id="page-top">

     <?php include("vendor/inc/nav.php");?>
     

     <div id="wrapper">

         <!-- Sidebar -->
         <?php include('vendor/inc/sidebar.php');?>

         <div id="content-wrapper">

             <div class="container-fluid">
                 <!-- Breadcrumbs-->
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item">
                         <a href="#">Vehicles</a>
                     </li>
                     <li class="breadcrumb-item active">Manage Vehicles</li>
                 </ol>
                 <?php if(isset($succ)) {?>
                 <!--code for an alert-->
                 <script>
                 setTimeout(function() {
                         swal("Success!", "<?php echo $succ;?>!", "success");
                     },
                     100);
                 </script>

                 <?php } ?>
                 
                 <?php if(isset($err)) {?>
                 
                 <script>
                 setTimeout(function() {
                         swal("Failed!", "<?php echo $err;?>!", "Failed");
                     },
                     100);
                 </script>

                 <?php } ?>

                
                 <!-- Data table structure -->
                 <div class="card mb-3">
                     <div class="card-header">
                         <i class="fas fa-users"></i>
                         Manage Vehicle
                     </div>
                     <div class="card-body">
                         <div class="table-responsive">
                             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                 <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Vehicle Name</th>
                                         <th>Registration Number</th>
                                         <th>Driver</th>
                                         <th>Category</th>
                                         <th>Status</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php
                                    $ret="SELECT v.*, CONCAT(d.d_fname, ' ', d.d_lname) as driver_name 
                                          FROM tms_vehicle v 
                                          LEFT JOIN tms_driver d ON v.d_id = d.d_id";
                                    $stmt= $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res=$stmt->get_result();
                                    $cnt=1;
                                    while($row=$res->fetch_object())
                                    {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row->v_name;?></td>
                                        <td><?php echo $row->v_reg_no;?></td>
                                        <td><?php echo $row->driver_name;?></td>
                                        <td><?php echo $row->v_category;?></td>
                                        <td><?php echo $row->v_status;?></td>
                                        <td>
                                            <a href="admin-manage-single-vehicle.php?v_id=<?php echo $row->v_id;?>" class="badge badge-success">Update</a>
                                            <a href="admin-manage-vehicle.php?del=<?php echo $row->v_id;?>" class="badge badge-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $cnt = $cnt+1; }?>
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
     <script src="vendor/datatables/jquery.dataTables.js"></script>
     <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin.min.js"></script>

     <!-- Demo scripts for this page-->
     <script src="js/demo/datatables-demo.js"></script>
     
 </body>
 </html>