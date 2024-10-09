<?php

    require 'connection.php';

    $user_id = $_POST['user_id'];

    try 
    {
        $query = "SELECT username FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            $response = array('status' => 'success', 'username' => $row['username']);
            echo json_encode($response);
        } 
        else 
        {
            $response = array('status' => 'error', 'message' => 'User not found');
            echo json_encode($response);
        }

        $stmt->close();
        $conn->close();
    } 
    catch (Exception $e) 
    {
        $response = array('status' => 'error', 'message' => 'Error: ' . $e->getMessage());
        echo json_encode($response);
    }
?>
