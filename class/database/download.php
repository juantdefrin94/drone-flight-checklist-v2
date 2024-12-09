<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');

    include 'connect.php';
    
    $templateId = $_POST['templateId'];

    $conn = (new Connect())->getConnection();
    $sql = "SELECT * FROM `template` WHERE `id` = '$templateId'";

    $result = $conn->query($sql);
    if ($result->num_rows === 1) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        
        $id = $row['id'];
        $templateName = $row['templateName'];
        $assessmentId = $row['assessmentId'];
        $preId = $row['preId'];
        $postId = $row['postId'];

        $json = "{\"id\": $id, \"templateName\": \"$templateName\",";
        
        $sql = "SELECT * FROM `form` WHERE `id` = '$assessmentId'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {

            $row = mysqli_fetch_assoc($result);

            $assessmentData = $row['formData'];
            $json .= "\"assessment\": $assessmentData,";
        }

        $sql = "SELECT * FROM `form` WHERE `id` = '$preId'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {

            $row = mysqli_fetch_assoc($result);

            $preData = $row['formData'];
            $json .= "\"pre\": $preData,";
        }

        $sql = "SELECT * FROM `form` WHERE `id` = '$postId'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {

            $row = mysqli_fetch_assoc($result);

            $postData = $row['formData'];
            $json .= "\"post\": $postData}";
        }

        echo $json;

    }else{
        //incorrect
        echo 'Not Success';
        mysqli_close($conn);
        exit();
    }
    