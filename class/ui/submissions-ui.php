<?php

class SubmissionsUI{

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
            <script src="script/submissions.js"></script>
            <title>Submission List Page</title>
        </head>
        <body>
           <div>
            <div>
    HTML;

    public function __construct($db){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<input type='text' id='user' name='user' style='display: none;'/>";
        $this->view .= <<<HTML
            <div class="container">
                <div id="sidebar-menu">
                    <div class="absolute">
        HTML;
        $this->view .= "<div class='menu'><a href='index.php?view=forms&user=$user&query'>Forms</a></div>";
        $this->view .= "<div class='menu'><a href='index.php?view=templates&user=$user&query'>Templates</a></div>";
        $this->view .= "<div class='menu active-menu'><a href='index.php?view=submissions&user=$user&query'>Submission</a></div>";
        $this->view .= <<<HTML
                    <div class='menu'><a href="index.php">Logout</a></div>
                </div>
            </div>
            <div class="submission-container">
                <div>
                    <div class="top-bar">
                        <div class="submission-title">Submission List</div>
                    </div>
                    <div style="display: flex">
                        <form method="POST" class="search-container">
                            <input class="search-input" type="text" placeholder="Search..." name="query">
                            <button id="search" type="submit"><i class='fa-solid fa-magnifying-glass fa-sm' style='color:#d4e9ea;margin-right:15px;'></i>Search</button>
                        </form>
                    </div>
                    <table id="table-header">
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Name</th>
                            <th class="col-4">Submitted By</th>
                            <th class="col-5">Submitted Date</th>
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
        $submissionList = $this->db->fetchAllSubmission($query);
        $this->view .= $submissionList;
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
        $this->search();
    }

    private function search(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $_GET['user'];
            $query = $_POST['query'];
            header("Location: index.php?view=submissions&user=$user&query=$query");
        }
    }

}