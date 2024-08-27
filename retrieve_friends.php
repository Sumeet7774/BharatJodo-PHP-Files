<?php

    require "connection.php";

    $user_id = $_POST['user_id'];           // id of the user which will technically be friend_id in the database table for which u want to retrieve his all friends

    $query="select f.friendship_id, u.username, u.phone_number 
                from friendship f
                join users u on (f.user_id=u.user_id or f.friend_id=u.user_id)
                where (f.user_id='$user_id' or f.friend='$user_id')
                and f.status='accepted'
                and u.user_id!='$user_id'";

    $result = $conn->query($query);

    if($result->num_rows > 0)
    {
        $allFriends = array();

        while($row = $result->fetch_assoc())
        {
            $allFriends[] = $row;
        }

        echo json_encode($allFriends);
    }
    else
    {
        echo json_encode(array("message" => "No friends found"));
    }

    $conn->close();
?>