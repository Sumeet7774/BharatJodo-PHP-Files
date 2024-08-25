<?php

    require "connection.php";

    $friendship_id = $_POST['friendship_id'];
    $status = $_POST['status'];

    try
    {
        $query = "update friendship set status=? where friendship_id=? ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si",$status,$friendship_id);
        $stmt->execute();

        if($stmt->affected_rows > 0)
        {
            echo "Friendship status updated";
        }
        else
        {
            echo "failed";
        }

        $stmt->close();
        $conn->close();
    }   
    catch(Exception $e)
    {
        echo "Error";
    }
?>