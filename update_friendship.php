<?php

    require 'connection.php';

    $friendshipId = $_POST['friendship_id'];
    $status = $_POST['status'];

    try 
    {
        $query = "update friendship set status = ? WHERE friendship_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $friendshipId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) 
        {
            $response = array('status' => 'success', 'message' => 'Friendship status updated');
            echo json_encode($response);
        } 
        else 
        {
            $response = array('status' => 'failed', 'message' => 'Failed to update status');
            echo json_encode($response);
        }

        $stmt->close();
        $conn->close();
    } 
    catch (Exception $e) 
    {
        echo "Error: " . $e->getMessage();
    }
?>
