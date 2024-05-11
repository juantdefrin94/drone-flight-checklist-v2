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
            <div id="modal" style="display: none;" name="delete-template">
                Are you sure want to delete this data?
                <form method="POST">
                    <input type="text" name="templateId" id="template-id" style="display: none;">
    HTML;

    public function __construct($db){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<a href='index.php?view=templates&user=$user&query'>No</a>";
        $this->view .= <<<HTML
            <button>Yes</button>
                </form>
            </div>
            <div>
                <div>
        HTML;
        $this->view .= "<a href='index.php?view=forms&user=$user&query'>Forms</a>";
        $this->view .= "<a href='index.php?view=templates&user=$user&query'>Templates</a>";
        $this->view .= "<a href='index.php?view=submissions&user=$user&query'>Submission</a>";
        $this->view .= <<<HTML
            <a href="index.php">Logout</a>
                </div>
                <div>
                    Template List
        HTML;
        $this->view .= "<a href='index.php?view=viewTemplates&user=$user&id=0'>Create New Template</a>";
        $this->view .= <<<HTML
            <form method="POST" name="search-template">
                <input type="text" placeholder="Search..." name="query">
                <button id="search" type="submit">Search</button>
            </form>
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Updated By</th>
                            <th>Updated Date</th>
                            <th>Action</th>
                        </tr>
        HTML;
        $this->getAllData();
    }

    private function getAllData(){
        $query = "";
        if(isset($_GET['query'])){
            $query = $_GET['query'];
        }
        $templateList = $this->db->fetchAllTemplate($query);
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
        $this->handleSubmit();
    }

    private function handleSubmit(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['templateId'])) {
                $templateId = $_POST['templateId'];
                if($templateId != ""){
                    $this->deleteConfirm();
                }
            } else if(isset($_POST['query'])) {
                $query = $_POST['query'];
                $this->reconstructData($query);
            }
        }
    }
    private function deleteConfirm(){
        $templateId = $_POST['templateId'];
        $user = $_GET['user'];
        if ($templateId != 0) {
                $deleteSuccess = $this->db->deleteTemplate($templateId);
                if ($deleteSuccess) {
                    echo "<script>alert('Delete Successful');</script>";
                    header("Location: index.php?view=templates&user=$user&query");
                }
                else {
                    echo "<script>alert('Something Wrong');</script>";
                } 
        }
    }

    private function reconstructData($query){
        $user = $_GET['user'];
        header("Location: index.php?view=templates&user=$user&query=$query");
    }
}