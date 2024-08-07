<?php

    require 'connection.php';

    $email_id = $_POST['email_id'];

    try
    {
        $query = "select username from users where email_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $response = array('status' => 'found', 'username' => $row['username']);
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