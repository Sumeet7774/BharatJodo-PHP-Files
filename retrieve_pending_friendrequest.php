<?php

    require "connection.php";

    $user_id = $_POST['user_id'];               //id of the user who received friend requests for which we want to fetch the pending friend requests

    $query = "select * from friendhip where friend_id='$user_id' and status='pending'";
    $result = $conn->query($query);
    
    if($result->num_rows > 0)
    {
        $pendingRequests = array();

        // Fetch each pending friend request
        while ($row = $result->fetch_assoc()) 
        {
            $pendingRequests[] = $row;
        }
        echo json_encode($pendingRequests);
    }
    else
    {
        echo json_encode(array("message" => "No pending friend requests"));
    }

    $conn->close();
?>