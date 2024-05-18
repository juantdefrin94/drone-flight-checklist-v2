<?php

include_once 'class/database/connect.php';

date_default_timezone_set('Asia/Jakarta');

class MasterDatabase {

    private $conn = null;

    function __construct(){
        $this->conn = (new Connect())->getConnection();
    }

    function validateLogin($username, $password){
        $sql = "SELECT * FROM user WHERE username='$username' and `password`='$password'";
        $result = $this->conn->query($sql);

        
        if ($result->num_rows === 1) {
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            if($row['username'] === $username){
                if($row['password'] === $password){
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
    
                    return "success";
                }else{
                    return "incorrect password";
                }
            }
        }else{
            //incorrect
            return "username is not exist";
        }
    }

    function validateUnique($username){
        $sql = "SELECT * FROM user WHERE username='$username'";
        $result = $this->conn->query($sql);

        if ($result->num_rows === 1) {
            // not unique
            return 'Username already exists';
        }else{
            // unique
            return 'unique';
        }
    }

    function registUser($email, $username, $password){;
        $sql = "INSERT INTO `user`(`username`, `email`, `password`) VALUES ('$username','$email','$password')";
        if ($this->conn->query($sql) === TRUE){
            return true;
        }
        return false;
    }

    function fetchAllForms($query){
        $sql = "SELECT * FROM `form` WHERE `formName` LIKE '%$query%' OR `formType` LIKE '%$query%' OR `updatedBy` LIKE '%$query%' ORDER BY updatedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $resString = "";
        $user = $_GET['user'];

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $num = $no % 2 == 0 ? 'even' : 'odd';
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td class='col-1'>" . $no . "</td>" . "<td class='col-2'>" . $row["formName"] . "</td>" . "<td class='col-3'>" . $row["formType"] . "</td>" . "<td class='col-4'>" . $row["updatedBy"] . "</td>" . "<td class='col-5'>" . $row["updatedDate"] . "</td>" . "<td class='col-6'><a href='index.php?view=viewForms&user=". $user . "&id=". $row['id'] . "'><i id='edit-".$row['id'] . "' class='fa-solid fa-pen-to-square fa-lg action-icon edit-icon'></i></a><i id='delete-".$row['id'] . "' class='fa-solid fa-trash fa-lg action-icon delete-data delete-icon'></i></td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="5">No Data Available</td></tr>';
        }

        return $resString;
    }

    function fetchDetailForm($id){
        $sql = "SELECT * FROM form WHERE id='$id'";
        $result = $this->conn->query($sql);
        $json = "";

        
        if ($result->num_rows === 1) {
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            if($row['id'] === $id){
                $formName = $row['formName'];
                $formType = $row['formType'];
                $updatedBy = $row['updatedBy'];
                $updatedDate = $row['updatedDate'];
                $formData = $row['formData'];
                $json = "{\"formName\": \"$formName\", \"formType\": \"$formType\", \"updatedBy\": \"$updatedBy\", \"updatedDate\": \"$updatedDate\", \"formData\": $formData}";
            }
        }
        return $json;
    }

    function saveForm($id, $formName, $formType, $user, $json){
        $user = base64_decode($user);
        $currentDateTime = new DateTime();
        $date = $currentDateTime->format("Y-m-d H:i:s");

        
        $sql = "";
        if($id == 0){
            $sql = "INSERT INTO `form`(`id`, `formName`, `formType`, `updatedBy`, `updatedDate`, `formData`) VALUES (NULL,'$formName','$formType','$user','$date','$json')";
        }else{
            $sql = "UPDATE `form` SET `formName` = '$formName', `formType` = '$formType', `updatedBy` = '$user', `updatedDate` = '$date', `formData` = '$json' WHERE `id` = $id"; 
        }

        if ($this->conn->query($sql) === TRUE){
            return true;
        }
        return false;
    }

    function deleteForm($id){
        $sql = "DELETE FROM `form` WHERE id = $id";
        if ($this->conn->query($sql) === true) {
            return true;
        }
        return false;
    }

    function fetchAllTemplate($query){
        $sql = "SELECT * FROM `template` WHERE `templateName` LIKE '%$query%' OR `updatedBy` LIKE '%$query%' ORDER BY updatedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $resString = "";
        $user = $_GET['user'];

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $num = $no % 2 == 0 ? 'even' : 'odd';
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td class='col-1'>" . $no . "</td>" . "<td class='col-2'>" . $row["templateName"] . "</td>" . "<td class='col-4'>" . $row["updatedBy"] . "</td>" . "<td class='col-5'>" . $row["updatedDate"] . "</td>" . "<td class='col-6'><a href='index.php?view=viewTemplates&user=$user&id=" . $row['id'] . "'><i id='edit-".$row['id'] . "' class='fa-solid fa-pen-to-square fa-lg action-icon edit-icon'></i></a><i id='delete-".$row['id'] . "' class='fa-solid fa-trash fa-lg action-icon delete-data delete-icon'></i></td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="4">No Data Available</td></tr>';
        }
        return $resString;
    }

    function getAllForm(){
        $sql = "SELECT id, formName, formType FROM `form` ORDER BY updatedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $json = "";

        if (mysqli_num_rows($result) > 0) {
            $json = "[";
            while($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $formName = $row['formName'];
                $formType = $row['formType'];
                $json .= "{\"id\": \"$id\", \"formName\" : \"$formName\", \"formType\" : \"$formType\"},";
            }
            $json = substr($json, 0, -1);
            $json .= "]";
        }

        return $json;
    }

    function fetchDetailTemplate($id){
        if($id != 0){
            $sql = "SELECT * FROM template WHERE id='$id'";
            $result = $this->conn->query($sql);
            $json = "";

            
            if ($result->num_rows === 1) {
                // output data of each row
                $row = mysqli_fetch_assoc($result);
                if($row['id'] === $id){
                    $templateName = $row['templateName'];
                    $assessmentId = $row['assessmentId'];
                    $preId = $row['preId'];
                    $postId = $row['postId'];
                    $json = "{\"templateName\": \"$templateName\", \"assessmentId\": \"$assessmentId\", \"preId\": \"$preId\", \"postId\": \"$postId\"}";
                }
            }
            return $json;
        }
    }

    function saveTemplate($id, $templateName, $assessmentId, $preId, $postId, $user){
        $user = base64_decode($user);
        $currentDateTime = new DateTime();
        $date = $currentDateTime->format("Y-m-d H:i:s");

        $sql = "";
        if($id == 0){
            $sql = "INSERT INTO `template`(`id`, `templateName`, `assessmentId`, `preId`, `postId`, `updatedBy`, `updatedDate`) VALUES (NULL,'$templateName','$assessmentId','$preId','$postId','$user','$date')";
        }else{
            $sql = "UPDATE `template` SET `templateName`='$templateName',`assessmentId`='$assessmentId',`preId`='$preId',`postId`='$postId',`updatedBy`='$user',`updatedDate`='$date' WHERE `id` = $id";
        }

        if ($this->conn->query($sql) === TRUE){
            return true;
        }

        return false;
    }

    function deleteTemplate($id){
        $sql = "DELETE FROM `template` WHERE id = $id";
        if ($this->conn->query($sql) === true) {
            return true;
        }
        return false;
    }

    function fetchAllSubmission($query){
        $sql = "SELECT * FROM `submission` WHERE `submissionName` LIKE '%$query%' OR `submittedBy` LIKE '%$query%' ORDER BY submittedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $resString = "";
        $user = $_GET['user'];

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $num = $no % 2 == 0 ? 'even' : 'odd';
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'> <td class='col-1'>" . $no . "</td>" . "<td class='col-2'>" . $row["submissionName"] . "</td>" . "<td class='col-4'>" . $row["submittedBy"] . "</td>" . "<td class='col-5'>" . $row["submittedDate"] . "</td></tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="4">No Data Available</td></tr>';
        }

        // mysqli_close($this->conn);
        return $resString;
    }

    function fetchDetailSubmission($id){
        $sql = "SELECT * FROM submission WHERE id='$id'";
        $result = $this->conn->query($sql);
        $json = "";

        
        if ($result->num_rows === 1) {
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            if($row['id'] === $id){
                $submissionName = $row['submissionName'];
                $templateId = $row['templateId'];
                $submittedBy = $row['submittedBy'];
                $submittedDate = $row['submittedDate'];
                $formData = $row['formData'];
                $json = "{\"submissionName\": \"$submissionName\", \"templateId\": \"$templateId\", \"submittedBy\": \"$submittedBy\", \"submittedDate\": \"$submittedDate\", \"formData\": $formData}";
            }
        }
        return $json;       
    }
}