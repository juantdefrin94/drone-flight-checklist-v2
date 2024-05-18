<?php

class SubmissionsViewUI{

    private $db = null;
    private $view = <<<HTML
    <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="styles/submission-view-style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="script/submissions-view.js"></script>
                <title></title>
            </head>
            <body>
                <div>
                    <nav class="top-bar" id="top-bar">
    HTML;

    public function __construct($db, $id){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<a class='back-button' href='index.php?view=submissions&user=$user&query'><i class='fa-solid fa-arrow-left-long fa-2x' style='color:#d4e9ea; margin-right:30px;'></i></a>";
        $this->view .= <<<HTML
                        <div class='header-title'><h1>View Submission</h1></div>
                    </nav>
                    <div id="container">
                        <div class="submission-content">
                
        HTML;
        $id = 0;
        $json = "";
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $json = $this->db->fetchDetailSubmission($id);
        }
        $jsonObj = json_decode($json);
        $submissionName = $jsonObj->submissionName;
        $this->view .= "<input type='text' id='json' style='display: none;' value='$json'/>";
        $this->view .= "<div class='submission-name'>Submission Name <i class='fa-solid fa-arrow-right-long fa-sm' style='color:#d4e9ea; margin:4px 15px 0 15px;'></i> $submissionName</div>";
        $this->view .= <<<HTML
                            <div id="assessment-answer"></div>
                            <div id="pre-answer"></div>
                            <div id="post-answer"></div>
                        </div>  
                    </div>
                </body>
            </html>
        HTML;
    }

    public function getView(){
        echo $this->view;
    }

}