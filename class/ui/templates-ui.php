<?php

class TemplatesUI{

    private $db = null;
    private $view = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles/list-style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="script/templates.js"></script>
            <title>Template List Page</title>
        </head>
        <body>
            <div id="modal" style="display: none;" name="delete-template">
                <div class="delete-container">
                    <div class="delete-confirmation">
                        <div class="delete-title">
                            <h2>Confirmation</h2>
                            <i class='fa-solid fa-circle-exclamation fa-5x' style='color:#ffc107; margin: 20px 0 10px 0;'></i>
                        </div>
                        <div class="delete-content">
                            <b>Are you sure want to delete this data?</b>
                            <form method="POST">
                                <input type="text" name="templateId" id="template-id" style="display: none;">
    HTML;

    public function __construct($db){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<input type='text' id='user' name='user' style='display: none;'/>";
        $this->view .= "<div class='confirm-button'><a href='index.php?view=templates&user=$user&query=&delete='><div class='no-button'>No</div></a>";
        $this->view .= <<<HTML
                                    <button class="yes-button">Yes</button>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div id="sidebar-menu">
                    <div class="absolute">
        HTML;
        $this->view .= "<div class='menu'><a href='index.php?view=dashboard&user=$user'>Dashboard</a></div>";
        $this->view .= "<div class='menu'><a href='index.php?view=forms&user=$user&query=&delete='>Forms</a></div>";
        $this->view .= "<div class='menu active-menu'><a href='index.php?view=templates&user=$user&query=&delete='>Templates</a></div>";
        $this->view .= "<div class='menu'><a href='index.php?view=submissions&user=$user&query='>Submission</a></div>";
        $this->view .= <<<HTML
                    <div class='menu'><a href="index.php">Logout</a></div>
                    </div>
                </div>
                <div class="template-container">
                    <div class="top-bar">
        HTML;
        $isDelete = $_GET['delete'];
        if($isDelete){
            $this->view .= "<div id='delete-alert'>Delete Successful!</div>";
        }
        $this->view .= "<div class='template-title'>Template List</div>";
        $this->view .= "<div class='button-container'><a href='index.php?view=viewTemplates&user=$user&id=0'><div class='create-template-button'><i class='fa-solid fa-plus fa-lg' style='color:#d4e9ea;margin-right:15px'></i>Create New Template</div></a></div></div>";
        $this->view .= <<<HTML
        <div style="display:flex">
            <form method="POST" name="search-template" class="search-container">
                <input class="search-input" type="text" placeholder="Search..." name="query">
                <button id="search" type="submit"><i class='fa-solid fa-magnifying-glass fa-sm' style='color:#d4e9ea;margin-right:15px;'></i>Search</button>
            </form>
        </div>
        <table id="table-header">
            <tr>
                <th class="col-1">No</th>
                <th class="col-2">Name</th>
                <th class="col-4">Updated By</th>
                <th class="col-5">Updated Date</th>
                <th class="col-6">Action</th>
            </tr>
        </table>
        <div class="table-container">
            <table>
        
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
                    header("Location: index.php?view=templates&user=$user&query=&delete=1");
                }
                else {
                    echo "<script>alert('Something Wrong');</script>";
                } 
        }
    }

    private function reconstructData($query){
        $user = $_GET['user'];
        header("Location: index.php?view=templates&user=$user&query=$query&delete=");
    }
}