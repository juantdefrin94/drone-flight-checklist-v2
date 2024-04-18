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
                <a href="index.php">Logout</a>
            </div>
            <div>
                Form List
                <button>Create New Form</button>
                <input type="text" placeholder="Search...">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Updated By</th>
                        <th>Updated Date</th>
                        <th>Action</th>
                    </tr>
    HTML;

    public function __construct($db){
        $this->db = $db;
        
    }

    public function getAllData(){
        $formList = $this->db->fetchAllForms();
        $this->view .= $formList;
    }

    public function getView(){
        $this->view .= <<<HTML
                </table>
                </div>
            </div>
            </body>
            </html>
        HTML;
        echo $this->view;
    }

    public function verifyData($username, $password){
        return true;
    }

}