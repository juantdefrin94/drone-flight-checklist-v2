<?php
ob_start();

class DashboardUI{

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
            <script src="script/dashboard.js"></script>
            <title>Dashboard Page</title>
        </head>
        <body>
                    
    HTML;

    public function __construct($db){
        $this->db = $db;
        $user = $_GET['user'];
        $this->view .= "<input type='text' id='user' name='user' style='display: none;' value='$user'/>";
        $this->view .= <<<HTML
            </div>
            <div class="container">
                <div id="sidebar-menu">
                    <div class="absolute">
        HTML;
        $this->view .= "<div class='menu active-menu'><a href='index.php?view=dashboard&user=$user'>Dashboard</a></div>";
        $this->view .= "<div class='menu'><a href='index.php?view=forms&user=$user&query=&delete='>Forms</a></div>";
        $this->view .= "<div class='menu'><a href='index.php?view=templates&user=$user&query=&delete='>Templates</a></div>";
        $this->view .= "<div class='menu'><a href='index.php?view=submissions&user=$user&query='>Submission</a></div>";
        $this->view .= <<<HTML
                    <div class='menu'><a href="index.php">Logout</a></div>
                </div>
            </div>
            <div class="dashboard-container">
        HTML;
        $this->view .= <<<HTML
                <div class="top-bar">
                    <div class="form-title">Dashboard</div>
        HTML;
        $count = $this->db->getCountData();
        $count = json_decode($count);
        $forms = $count->forms;
        $templates = $count->templates;
        $submissions = $count->submissions;

        $this->view .= <<<HTML
                    </div>
                    <div class="all-card-container">
                        <div class="card">
                            <h1>Forms</h1>
                            <div class="card-container">
                                Submission : $forms
                            </div>
                        </div>
                        <div class="card mid">
                            <h1>Templates</h1>
                            <div class="card-container">
                                Submission : $templates
                            </div>
                        </div>
                        <div class="card">
                            <h1>Submission</h1>
                            <div class="card-container">
                                Submission : $submissions
                            </div>
                        </div>
                    </div>
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