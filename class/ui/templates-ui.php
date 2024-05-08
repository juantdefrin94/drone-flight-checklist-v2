<?php

class TemplatesUI{

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
            <script src="script/templates.js"></script>
            <title>Template List Page</title>
        </head>
        <body>
            <div id="modal" style="display: none;">
                Are you sure want to delete this data?
                <form method="POST">
                    <input type="text" name="templateId" id="template-id" style="display: none;">
                    <a href='index.php?view=templates&user=anVhbnRkZWZyaW4='>No</a>
                    <button>Yes</button>
                </form>
            </div>
            <div>
                <div>
                    <a href="index.php?view=forms&user=anVhbnRkZWZyaW4=">Forms</a>
                    <a href="index.php?view=templates&user=anVhbnRkZWZyaW4=">Templates</a>
                    <a href="index.php?view=submissions&user=anVhbnRkZWZyaW4=">Submission</a>
                    <a href="index.php">Logout</a>
                </div>
                <div>
                    Template List
                    <button>Create New Template</button>
                    <input type="text" placeholder="Search...">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Updated By</th>
                            <th>Updated Date</th>
                            <th>Action</th>
                        </tr>
    HTML;

    public function __construct($db){
        $this->db = $db;
        $this->getAllData();
    }

    private function getAllData(){
        $templateList = $this->db->fetchAllTemplate();
        $this->view .= $templateList;
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
           $templateId = $_POST['templateId'];
           if ($templateId != 0) {
                $deleteSuccess = $this->db->deleteTemplate($templateId);
                if ($deleteSuccess) {
                    echo "<script>alert('Delete Successful');</script>";
                    header("Location: index.php?view=templates&user=anVhbnRkZWZyaW4=");
                }
                else {
                    echo "<script>alert('Something Wrong');</script>";
                } 
           }
        }
    }
}