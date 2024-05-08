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

    function fetchAllForms(){
        $sql = "SELECT * FROM `form` ORDER BY updatedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $resString = "";

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $num = $no % 2 == 0 ? 'even' : 'odd';
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td>" . $no . "</td>" . "<td>" . $row["formName"] . "</td>" . "<td>" . $row["formType"] . "</td>" . "<td>" . $row["updatedBy"] . "</td>" . "<td>" . $row["updatedDate"] . "</td>" . "<td><a href='../views/flight-form.php?mode=edit&id=". $row['id'] . "&name=" . $row["formName"] . "'><i id='edit-".$row['id'] . "' class='fa-solid fa-pen-to-square action-icon'></i></a><i id='delete-".$row['id'] . "' class='fa-solid fa-trash action-icon delete-data'></i></td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="5">No Data Available</td></tr>';
        }

        

        return $resString;
    }

    function fetchFormSearch($query){
        return "string";
    }

    function fetchDetailForm($id){
        if($id != 0){

        }
        return "";
    }

    function saveForm($id, $formName, $formType, $user, $json){
        $user = base64_decode($user);
        $currentDateTime = new DateTime();
        $date = $currentDateTime->format("Y-m-d H:i:s");

        echo "<script>alert('$id');</script>";
        if($id == 0){
            $sql = "INSERT INTO `form`(`id`, `formName`, `formType`, `updatedBy`, `updatedDate`, `formData`) VALUES (NULL,'$formName','$formType','$user','$date','$json')";

            if ($this->conn->query($sql) === TRUE){
                return true;
            }
            return false;
        }
    }

    function deleteForm($id){
        $sql = "DELETE FROM `form` WHERE id = $id";
        if ($this->conn->query($sql) === true) {
            return true;
        }
        return false;
    }

    function fetchAllTemplate(){
        $sql = "SELECT * FROM `template` ORDER BY updatedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $resString = "";

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $num = $no % 2 == 0 ? 'even' : 'odd';
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td>" . $no . "</td>" . "<td>" . $row["templateName"] . "</td>" . "<td>" . $row["updatedBy"] . "</td>" . "<td>" . $row["updatedDate"] . "</td>" . "<td><a href=''><i id='edit-".$row['id'] . "' class='fa-solid fa-pen-to-square action-icon'></i></a><i id='delete-".$row['id'] . "' class='fa-solid fa-trash action-icon delete-data'></i></td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="4">No Data Available</td></tr>';
        }
        return $resString;
    }

    function fetchTemplateSearch($query){
        return "string";
    }

    function fetchDetailTemplate($id){
        return "string";
    }

    function updateTemplate($id, $templateName, $assessmentId, $preId, $postId){
        return true;
    }

    function deleteTemplate($id){
        $sql = "DELETE FROM `template` WHERE id = $id";
        if ($this->conn->query($sql) === true) {
            return true;
        }
        return false;
    }

    function fetchAllSubmission(){
        $sql = "SELECT * FROM `submission` ORDER BY submittedDate DESC";
        $result = mysqli_query($this->conn, $sql);
        $resString = "";

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $no = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $num = $no % 2 == 0 ? 'even' : 'odd';
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td>" . $no . "</td>" . "<td>" . $row["submissionName"] . "</td>" . "<td>" . $row["submittedBy"] . "</td>" . "<td>" . $row["submittedDate"] . "</td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="4">No Data Available</td></tr>';
        }

        // mysqli_close($this->conn);
        return $resString;
    }

    function fetchDetailSubmission($id){
        return "data";
    }
}