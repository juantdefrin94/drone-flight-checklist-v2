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
            <title>Submission List Page</title>
        </head>
        <body>
           <div>
            <div>
                <a href="index.php?view=forms&user=anVhbnRkZWZyaW4=">Forms</a>
                <a href="index.php?view=templates&user=anVhbnRkZWZyaW4=">Templates</a>
                <a href="index.php?view=submissions&user=anVhbnRkZWZyaW4=">Submission</a>
                <a href="index.php">Logout</a>
            </div>
            <div>
                Submission List
                <input type="text" placeholder="Search...">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Submitted By</th>
                        <th>Submitted Date</th>
                    </tr>
    HTML;

    public function __construct($db){
        $this->db = $db;
        $this->getAllData();
    }

    private function getAllData(){
        $submissionList = $this->db->fetchAllSubmission();
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
    }

    

}