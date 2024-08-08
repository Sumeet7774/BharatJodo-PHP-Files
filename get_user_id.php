<?php

    require 'connection.php';

    $phone_number = $_POST['phone_number'];

    try
    {
        $query = "select user_id from users where phone_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $phone_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $response = array('status' => 'found', 'user_id' => $row['user_id']);
        }
        else
        {
            $response = array('status' => 'not found', 'message' => 'user not found');
        }

        echo json_encode($response);

        $stmt->close();
        $conn->close();
    }
    catch(Exception $e)
    {
        $response = array('status' => 'error', 'message' => 'Error');
        echo json_encode($response);
    }
?>