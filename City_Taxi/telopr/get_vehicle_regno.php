<?php
include('vendor/inc/config.php');

if(isset($_POST['v_category'])) {
    $v_category = $_POST['v_category'];
    $query = "SELECT v_id, v_reg_no FROM tms_vehicle WHERE v_category = ? AND v_status = 'Available'";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $v_category);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Select Vehicle Registration</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['v_id'] . '">' . $row['v_reg_no'] . '</option>';
    }
}
?>
