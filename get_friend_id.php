<?php

require 'connection.php';

$username = $_POST['username'];

try {
    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'user_id' => $row['user_id']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An error occurred']);
}
