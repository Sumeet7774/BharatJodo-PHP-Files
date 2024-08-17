<?php

    require "connection.php";

    $query = "select * from friendhip where status='pending' ";
    $result = $conn->query($query);
    
    if($result->num_rows > 0)
    {
        $pendingRequests = array();

        // Fetch each pending friend request
        while ($row = $result->fetch_assoc()) 
        {
            $pendingRequests[] = $row;
            echo json_encode($pendingRequests);
        }
    }
    else
    {
        echo "No pending friend requests";
    }

    $conn->close();
?>