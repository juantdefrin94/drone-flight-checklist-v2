<?php

require_once 'class/ui/master-ui.php';
class FormsUI extends MasterUI{

    private $db = null;
    private $view = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>Form List Page</title>
        </head>
        <body>
           <div>
            <div>
                <a href="">Forms</a>
                <a href="">Templates</a>
                <a href="">Submission</a>
                <a href="">Logout</a>
            </div>
            <div>
                Form List
                <button>Create New Form</button>
                <input type="text" placeholder="Search...">
                <table>
                    <th>
                        <td>No</td>
                        <td>Type</td>
                        <td>Name</td>
                        <td>Updated By</td>
                        <td>Updated Date</td>
                        <td>Action</td>
                    </th>
                </table>
            </div>
           </div>
        </body>
        </html>
    HTML;

    public function __construct($db){
        $this->db = $db;
    }

    public function getView(){
        echo $this->view;
    }

    private function verifyData($username, $password){
        return true;
    }
    public function login($username, $password){
        $verified = $this->verifyData($username, $password);
        if($verified){
            $validated = $this->db->validateLogin($username, $password);
            if($validated){
                return true;
            }
        }
        return false;
    }

    

}