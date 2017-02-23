<?php
$servername = "localhost";
$username = "admindev_db";
$password = "T3mpp4ss!";
$dbname = "push_notification_app";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if($db->connect_error) {
	die('Database connection failed: '  . $db->connect_error);
}

switch($_REQUEST['action']) {
	case 'get_notifications' :
		echo json_encode(getNotifications());
		break;
	case 'insert_notification' :
		insertNotification($_POST);
		break;
	default :
		echo 'Invalid Request';
		break;
}

function getNotifications(){
	global $db;

	$sql = "SELECT * FROM notification";
	$res = $db->query($sql);
	$data = $res->fetch_array(MYSQLI_ASSOC);

	if($res->num_rows > 0) return $data;
}

function insertNotification($data){
	global $db;

	$sql = "INSERT INTO notification(message, sent_date, user_create) (?, NOW(), 'appCreate')";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('s', $data['message']);
	$stmt->execute();
}

?>