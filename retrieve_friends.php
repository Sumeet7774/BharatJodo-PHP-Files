<?php

    require "connection.php";

    $user_id = $_POST['user_id'];                // id of the user which will technically be friend_id in the database table for which you want to retrieve his all friends

    $query="select f.friendship_id, u.username, u.phone_number 
            from friendship f
            join users u on f.user_id=u.user_id
            where f.friend_id = '$user_id'
            and f.status = 'accepted'
            and u.user_id != '$user_id'";

    $result = $conn->query($query);

    $response = array();

    if ($result->num_rows > 0)
    {
        $allFriends = array();

        while ($row = $result->fetch_assoc()) 
        {
            $allFriends[] = $row;
        }

        $response['friends'] = $allFriends;
    } 
    else
    {
        $response['message'] = "No friends found";
    }

    echo json_encode($response);

    $conn->close();
?>
