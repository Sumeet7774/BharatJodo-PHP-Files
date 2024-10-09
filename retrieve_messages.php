<?php
require "connection.php";

$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];

$query = "SELECT * FROM messages WHERE (sender_id='$sender_id' AND receiver_id='$receiver_id') OR (sender_id='$receiver_id' AND receiver_id='$sender_id')";
$result = mysqli_query($conn, $query);

$messages = array();

while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

$response = array('status' => 'success', 'messages' => $messages);
echo json_encode($response);
?>
