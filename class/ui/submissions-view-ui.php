<?php

class SubmissionsViewUI{

    private $db = null;
    private $view = <<<HTML
    <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="styles/submission-form-style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="script/submissions-view.js"></script>
                <title></title>
            </head>
            <body>
                <div>
                    <nav>
    HTML;

    public function __construct($db, $id){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<a href='index.php?view=submissions&user=$user&query'><i class='fa-solid fa-arrow-left-long fa-lg' style='color:#bb9d93; margin-right:30px;'></i></a>";
        $this->view .= <<<HTML
                        <h1></h1>
                    </nav>
                <div>
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
        $this->view .= "<h3>Submission Name : $submissionName</h3>";
        $this->view .= <<<HTML
                        <div id="assessment-answer"></div>
                        <div id="pre-answer"></div>
                        <div id="post-answer"></div>
                    </div>  
                </body>
            </html>
        HTML;
    }

    public function getView(){
        echo $this->view;
    }

}