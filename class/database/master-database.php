<?php

include_once 'class/database/connect.php';

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
            if($row['username'] === $username && $row['password'] === $password){
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;

                mysqli_close($this->conn);
                return true;
            }
        }else{
            //incorrect
            mysqli_close($this->conn);
            return false;
        }
    }

    function validateUnique($email, $username, $password){
        return true;
    }

    function registUser($email, $username, $password){
        return true;
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
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td>" . $no . "</td>" . "<td>" . $row["form_name"] . "</td>" . "<td>" . $row["form_type"] . "</td>" . "<td>" . $row["updated_by"] . "</td>" . "<td>" . $row["updated_date"] . "</td>" . "<td><a href='../views/flight-form.php?mode=edit&id=". $row['id'] . "&name=" . $row["form_name"] . "'><i id='edit-".$row['id'] . "' class='fa-solid fa-pen-to-square action-icon'></i></a><i id='delete-".$row['id'] . "' class='fa-solid fa-trash action-icon delete-data'></i></td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="5">No Data Available</td></tr>';
        }

        mysqli_close($this->conn);
        return $resString;
    }

    function fetchFormSearch($query){
        return "string";
    }

    function fetchDetailForm($id){
        return "string";
    }

    function updateForm($id, $json, $updatedBy, $updatedDate){
        return true;
    }

    function deleteForm($id){

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
                $resString .= "<tr class='table-data ". $num . "' id='data-" . $row['id'] . "'><td>" . $no . "</td>" . "<td>" . $row["form_name"] . "</td>" . "<td>" . $row["form_type"] . "</td>" . "<td>" . $row["updated_by"] . "</td>" . "<td>" . $row["updated_date"] . "</td>" . "<td><a href='../views/flight-form.php?mode=edit&id=". $row['id'] . "&name=" . $row["form_name"] . "'><i id='edit-".$row['id'] . "' class='fa-solid fa-pen-to-square action-icon'></i></a><i id='delete-".$row['id'] . "' class='fa-solid fa-trash action-icon delete-data'></i></td>" . "</tr>";
                $no = $no + 1;
            }
        } else {
            return '<tr class="table-data"><td colspan="5">No Data Available</td></tr>';
        }

        mysqli_close($this->conn);
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
        return true;
    }

    function fetchAllSubmission(){
        return "data";
    }

    function fetchDetailSubmission($id){
        return "data";
    }
}