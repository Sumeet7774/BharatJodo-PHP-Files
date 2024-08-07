<?php

    require 'connection.php';

    $username = $_POST['username'];

    try
    {
        $query = "select email_id from users where username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $response = array('status' => 'found', 'email_id' => $row['email_id']);
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