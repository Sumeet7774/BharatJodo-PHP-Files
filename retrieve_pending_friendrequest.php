<?php

    require "connection.php";

    $user_id = $_POST['user_id'];               //id of the user who received friend requests for which we want to fetch the pending friend requests

    //$query = "select * from friendhip where friend_id='$user_id' and status='pending'";
    $query="select f.friendship_id, u.username, u.phone_number 
            from friendship f
            join users u on f.user_id=u.user_id
            where f.friend_id='$user_id' and f.status = 'pending'";
    
    $result = $conn->query($query);
    
    if($result->num_rows > 0)
    {
        $pendingRequests = array();

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