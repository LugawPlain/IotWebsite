<?php
$servername = "sql107.infinityfree.com";
$dBUsername = "if0_34931116";
$dBPassword = "cG3lqgoxvLrZf";
$dBName = "if0_34931116_yortechdb";
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
header("Content-Type: applcation/json");
$response = array();
//Read the database
if (isset($_POST['check_status'])) {
	$id = $_POST['check_status'];
	$sql = "SELECT * FROM led_status WHERE id = '$id';";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);

	$led_status = ($row['status'] == 0) ? "LED_is_off" : "LED_is_on";

    $response['status'] = $led_status;
}
echo json_encode($response);
?>