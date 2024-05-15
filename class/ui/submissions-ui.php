<?php

class SubmissionsUI{

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
        $this->view .= "<a href='index.php?view=forms&user=$user&query'>Forms</a>";
        $this->view .= "<a href='index.php?view=templates&user=$user&query'>Templates</a>";
        $this->view .= "<a href='index.php?view=submissions&user=$user&query'>Submission</a>";
        $this->view .= <<<HTML
                <a href="index.php">Logout</a>
            </div>
            <div>
                Submission List
                <form method="POST">
                    <input type="text" placeholder="Search..." name="query">
                    <button type="submit">Search</button>
                </form>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Submitted By</th>
                        <th>Submitted Date</th>
                    </tr>
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