<?php

    require 'connection.php';

    $user_id = $_POST['user_id'];

    try
    {
        $query = "select username from users where user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            echo $row['username'];
        }
        else
        {
            echo "user not found"; 
        }

        $stmt->close();
        $conn->close();
    }
    catch(Exception $e)
    {
        echo "Error";
    }
?>