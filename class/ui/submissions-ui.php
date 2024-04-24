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
                <a href="index.php?view=forms&user=309d186d7aa0aa99baf5f215c86122edf1f2c7526ccfa80560a6828acdf7d1c902bd29e47abcea682e16dcbcdc0e58e559034b0279dafe5ff8c2da79218ca9e7">Forms</a>
                <a href="index.php?view=templates&user=309d186d7aa0aa99baf5f215c86122edf1f2c7526ccfa80560a6828acdf7d1c902bd29e47abcea682e16dcbcdc0e58e559034b0279dafe5ff8c2da79218ca9e7">Templates</a>
                <a href="index.php?view=submissions&user=309d186d7aa0aa99baf5f215c86122edf1f2c7526ccfa80560a6828acdf7d1c902bd29e47abcea682e16dcbcdc0e58e559034b0279dafe5ff8c2da79218ca9e7">Submission</a>
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