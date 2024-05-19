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
        $countRecent = $this->db->getCountRecentData();
        $countRecent = json_decode($countRecent);
        $forms = $countRecent->forms->count;
        $templates = $countRecent->templates->count;
        $submissions = $countRecent->submissions->count;

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
                    <div class="recent-container">
                        <div class="recent">
                            <h1>Recent Form</h1>
                            <table class="table-header">
                                <tr>
                                    <th class="col-1">No</th>
                                    <th class="col-2">Name</th>
                                    <th class="col-3">Type</th>
                                    <th class="col-4">Updated By</th>
                                    <th class="col-5">Updated Date</th>
                                </tr>
                            </table>
                            <table class="table-container">
        HTML;

        $formRecent = $countRecent->forms->recent;
        $templateRecent = $countRecent->templates->recent;
        $submissionRecent = $countRecent->submissions->recent;

        $formLength = count($formRecent);
        for($i = 0; $i < $formLength; $i++){
            $no = $i + 1;
            $currRecent = $formRecent[$i];
            $oddEven = $no % 2 == 0 ? "even" : "odd";
            $this->view .= "<tr class='table-data $oddEven'>";
            $this->view .= <<<HTML
                                    <td class="col-1">$no</td>
                                    <td class="col-2">$currRecent->formName</td>
                                    <td class="col-3">$currRecent->formType</td>
                                    <td class="col-4">$currRecent->updatedBy</td>
                                    <td class="col-5">$currRecent->updatedDate</td>
                                </tr>
            HTML;
        }

        $this->view .= <<<HTML
                            </table>
                        </div>
                        <div class="recent">
                            <h1>Recent Template</h1>
                            <table class="table-header">
                                <tr>
                                    <th class="col-1">No</th>
                                    <th class="col-2">Name</th>
                                    <th class="col-4">Updated By</th>
                                    <th class="col-5">Updated Date</th>
                                </tr>
                            </table>
                            <table class="table-container">
        HTML;

        $templateLength = count($templateRecent);
        for($i = 0; $i < $templateLength; $i++){
            $no = $i + 1;
            $currRecent = $templateRecent[$i];
            $oddEven = $no % 2 == 0 ? "even" : "odd";
            $this->view .= "<tr class='table-data $oddEven'>";
            $this->view .= <<<HTML
                                    <td class="col-1">$no</td>
                                    <td class="col-2">$currRecent->templateName</td>
                                    <td class="col-4">$currRecent->updatedBy</td>
                                    <td class="col-5">$currRecent->updatedDate</td>
                                </tr>
            HTML;
        }

        $this->view .= <<<HTML
                            </table>
                        </div>
                        <div class="recent">
                            <h1>Recent Submission</h1>
                            <table class="table-header">
                                <tr>
                                    <th class="col-1">No</th>
                                    <th class="col-2">Name</th>
                                    <th class="col-4">Submitted By</th>
                                    <th class="col-5">Submitted Date</th>
                                </tr>
                            </table>
                            <table class="table-container">
        HTML;

        $submissionLength = count($submissionRecent);
        for($i = 0; $i < $submissionLength; $i++){
            $no = $i + 1;
            $currRecent = $submissionRecent[$i];
            $oddEven = $no % 2 == 0 ? "even" : "odd";
            $this->view .= "<tr class='table-data $oddEven'>";
            $this->view .= <<<HTML
                                    <td class="col-1">$no</td>
                                    <td class="col-2">$currRecent->submissionName</td>
                                    <td class="col-4">$currRecent->submittedBy</td>
                                    <td class="col-5">$currRecent->submittedDate</td>
                                </tr>
            HTML;
        }

        $this->view .= <<<HTML
                            </table>
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