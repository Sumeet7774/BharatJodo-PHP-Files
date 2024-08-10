<?php

    require 'connection.php';

    $phone_number = $_POST['phone_number'];

    try
    {
        $query = "select email_id from users where phone_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $phone_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            echo $row['email_id'];
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