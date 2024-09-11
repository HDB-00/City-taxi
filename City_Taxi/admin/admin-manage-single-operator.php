<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Update Operator Details Code
if (isset($_POST['update_operator'])) {
    $o_id = $_GET['o_id'];
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
    $query = "UPDATE tms_operator SET o_fname=?, o_lname=?, o_phone=?, o_nic=?, o_addr=?, o_email=?, o_pwd=? WHERE o_id=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind the parameters to the SQL query
        $stmt->bind_param('sssssssi', $o_fname, $o_lname, $o_phone, $o_nic, $o_addr, $o_email, $hashed_pwd, $o_id);

        if ($stmt->execute()) {
            $succ = "Telephone Operator Updated";
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
                        <a href="#">Telephone Operators</a>
                    </li>
                    <li class="breadcrumb-item active">Update Telephone Operator</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Update Telephone Operator
                    </div>
                    <div class="card-body">
                        <?php
                        $aid = $_GET['o_id'];
                        $ret = "SELECT * FROM tms_operator WHERE o_id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="o_fname">First Name</label>
                                    <input type="text" value="<?php echo $row->o_fname; ?>" required class="form-control" id="o_fname" name="o_fname">
                                </div>
                                <div class="form-group">
                                    <label for="o_lname">Last Name</label>
                                    <input type="text" class="form-control" value="<?php echo $row->o_lname; ?>" id="o_lname" name="o_lname">
                                </div>
                                <div class="form-group">
                                    <label for="o_phone">Contact</label>
                                    <input type="text" class="form-control" value="<?php echo $row->o_phone; ?>" id="o_phone" name="o_phone">
                                </div>
                                <div class="form-group">
                                    <label for="o_nic">NIC No</label>
                                    <input type="text" class="form-control" value="<?php echo $row->o_nic; ?>" id="o_nic" name="o_nic">
                                </div>
                                <div class="form-group">
                                    <label for="o_addr">Address</label>
                                    <input type="text" class="form-control" value="<?php echo $row->o_addr; ?>" id="o_addr" name="o_addr">
                                </div>
                                <div class="form-group">
                                    <label for="o_email">Email Address</label>
                                    <input type="email" value="<?php echo $row->o_email; ?>" class="form-control" id="o_email" name="o_email">
                                </div>
                                <div class="form-group">
                                    <label for="o_pwd">Password</label>
                                    <input type="password" class="form-control" id="o_pwd" name="o_pwd">
                                </div>

                                <button type="submit" name="update_operator" class="btn btn-success">Update Telephone Operator</button>
                            </form>
                        <?php } ?>
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

    <?php include("vendor/inc/logout.php"); ?>

    <?php include("vendor/inc/scripts.php"); ?>

</body>
</html>
