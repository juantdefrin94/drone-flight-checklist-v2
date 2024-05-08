<?php
ob_start();

class FormsUI{

    private $db = null;
    private $view = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="script/forms.js"></script>
            <title>Form List Page</title>
        </head>
        <body>
            <div id="modal" style="display: none;">
                Are you sure want to delete this data?
                <form method="POST">
                    <input type="text" name="formId" id="form-id" style="display: none;">
                    
    HTML;

    public function __construct($db){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<a href='index.php?view=forms&user=$user'>No</a>";
        $this->view .= <<<HTML
            <button>Yes</button>
                </form>
            </div>
            <div>
                <div>
        HTML;
        $this->view .= "<a href='index.php?view=forms&user=$user'>Forms</a>";
        $this->view .= "<a href='index.php?view=templates&user=$user'>Templates</a>";
        $this->view .= "<a href='index.php?view=submissions&user=$user'>Submission</a>";
        $this->view .= <<<HTML
                <a href="index.php">Logout</a>
            </div>
            <div>
                Form List
        HTML;
        $this->view .= "<a href='index.php?view=viewForms&user=$user&id=0'>Create New Form</a>";
        $this->view .= <<<HTML
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
                
        $this->getAllData();
    }

    private function getAllData(){
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
        $this->deleteConfirm();
    }

    private function deleteConfirm(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           $formId = $_POST['formId'];
           $user = $_GET['user'];
           if ($formId != 0) {
                $deleteSuccess = $this->db->deleteForm($formId);
                if ($deleteSuccess) {
                    echo "<script>alert('Delete Successful');</script>";
                    header("refresh");
                }
                else {
                    echo "<script>alert('Something Wrong');</script>";
                } 
           }
        }
    }

}