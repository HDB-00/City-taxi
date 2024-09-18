<?php
include('vendor/inc/config.php');

if(isset($_POST['v_id'])) {
    $v_id = $_POST['v_id'];
    
    $query = "SELECT v.v_cost, v.d_id, CONCAT(d.d_fname, ' ', d.d_lname) AS driver_name 
              FROM tms_vehicle v 
              LEFT JOIN tms_driver d ON v.d_id = d.d_id 
              WHERE v.v_id = ?";
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $v_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()) {
        $response = array(
            'driver_name' => $row['driver_name'],
            'd_id' => $row['d_id'],
            'v_cost' => $row['v_cost']
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Vehicle or driver not found'));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('error' => 'No vehicle ID provided'));
}

$mysqli->close();
?>
