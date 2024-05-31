<?php
ob_start();

class TemplatesViewUI{

    private $db = null;
    private $view = <<<HTML
    <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="styles/template-view-style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="script/templates-view.js"></script>
                <title></title>
            </head>
            <body>
                <div>
                    <nav class="top-bar" id="top-bar">
    HTML;
    
    function filterForm($item, $type){
        return $item['formType'] === $type;
    }
    
    public function __construct($db, $id){
        $this->db = $db;
        
        $user = $_GET['user'];
        $id = $_GET['id'];
        $isCreate = $id == 0 ? "Create New" : "Edit";
        $this->view .= "<a class='back-button' href='index.php?view=templates&user=$user&query=&delete='><i class='fa-solid fa-arrow-left-long fa-2x' style='color:#d4e9ea; margin-right:30px;'></i></a>";
        $this->view .= "<div class='header-title'><h1>$isCreate Template</h1></div>";
        $this->view .= <<<HTML
                    </nav>
                    <div id="container">
                        <div class="content-box">
                            <form method="POST">
                                    <div>
                                        <div class="label-title">Template Name</div>
                                        <input type="text" id="template-name" name="template-name" required>
                                    </div>
                        
                            
        HTML;

        $json = $this->db->getAllForm();
        $json = json_decode($json);

        $this->view.=<<<HTML
                        <div class="select-container">
                            <div class="assessment-container">
                                <div class="assessment-label">Assesment Form</div>
                                <select id="assessment-select">
                                    <option disabled selected value="empty"> -- select an option -- </option>
        HTML;

        foreach ($json as $opt){
            if($opt->formType === "assessment"){
                $value = $opt->id;
                $formName = $opt->formName;
                $this->view .= "<option value='$value'>$formName</option>";
            }
        }

        $this->view .= <<<HTML
                                </select>
                            </div>

                            <div class="pre-container">
                                <div class="pre-label">Pre-Fligt Form</div>
                                <select id="pre-select">
                                    <option disabled selected value="empty"> -- select an option -- </option>
        HTML;

        foreach ($json as $opt){
            if($opt->formType === "pre"){
                $value = $opt->id;
                $formName = $opt->formName;
                $this->view .= "<option value='$value'>$formName</option>";
            }
        }

        $this->view .= <<<HTML
                                </select>
                            </div>

                            <div class="post-container">
                                <div class="post-label">Post-Fligt Form</div>
                                <select id="post-select">
                                    <option disabled selected value="empty"> -- select an option -- </option>
        HTML;

        foreach ($json as $opt){
            if($opt->formType === "post"){
                $value = $opt->id;
                $formName = $opt->formName;
                $this->view .= "<option value='$value'>$formName</option>";
            }
        }

        $this->view .= <<<HTML
                                        </select>
                                    </div>
                                </div>

                                <input type="text" name="assessment-id" id="assessment-id" style="display: none">
                                <input type="text" name="pre-id" id="pre-id" style="display: none">
                                <input type="text" name="post-id" id="post-id" style="display: none">

                                <button id="save" type="submit" style="display: none">Save Template</button>

                            </form>
        HTML;


        $json = "";
        if($id != 0){
            $json = $this->db->fetchDetailTemplate($id);
        }

        $this->view .= "<input type='text' id='template-id' style='display: none' value='$id'>";
        $this->view .= "<input type='text' id='json' style='display: none' value='$json'>";
        $this->view .= <<<HTML
                                    <div id="save-container">
                                        <button id="save-button">Save Template</button>
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
        $this->saveTemplate();
    }

    public function saveTemplate(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_GET['id'];
            $templateName = $_POST['template-name'];
            $assessmsnetId = $_POST['assessment-id'];
            $preId = $_POST['pre-id'];
            $postId = $_POST['post-id'];

            $user = $_GET['user'];

            $isSaved = $this->db->saveTemplate($id, $templateName, $assessmsnetId, $preId, $postId, $user);
            if($isSaved){
                header("Location: index.php?view=templates&user=$user&query=&delete=");
            }
        }
    }



}