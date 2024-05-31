<?php
ob_start();

class FormsViewUI{

    private $db = null;
    private $view = <<<HTML
    <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="styles/form-view-style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="script/forms-view.js"></script>
                <title></title>
            </head>
            <body>
                <div>
                    <nav class="top-bar" id="top-bar">
    HTML;

    public function __construct($db, $id){
        $this->db = $db;
        $user = $_GET['user'];
        $formId = $_GET['id'];
        $isCreate = $formId == 0 ? "Create New" : "Edit";
        $this->view .= "<div class='back-button'><a href='index.php?view=forms&user=$user&query=&delete='><i class='fa-solid fa-arrow-left-long fa-2x' style='color:#d4e9ea; margin-right:30px;'></i></a></div>";
        $this->view .= "<div class='header-title'><h1>$isCreate Form</h1></div>";
        $this->view .= <<<HTML
                        </nav>
                        <div id="container">
                            <div class="content-box">
                                <form method="POST">
                                    <div class="title-label">
                                        <div class="header-input">Form Name</div>
                                        <div class="header-input">Form Type</div>
                                        
                                    </div>

                                    <div class="input-label">
                                        <div class="content-input">
                                            <input type="text" name="form-name" id="form-name">
                                        </div>
                                        <div class="content-input">
                                            <select id="form-type-dropdown">
                                                <option value="assessment">Assessment</option>
                                                <option value="pre">Pre-Flight</option>
                                                <option value="post">Post-Flight</option>
                                            </select>
                                            <input type="text" name="form-type" id="form-type" style="display: none">
                                        </div>
                                    </div>
                                    
                                    <div id="container-field">
                                    <!-- for show the data -->
                                    </div>
                                   
                                    <button id="add-new-field">
                                        <i class='fa-solid fa-plus fa-lg' style='color:#d4e9ea;margin-right:15px'></i>Add New Field
                                    </button>
                            
        HTML;
        $json = "";
        if($formId != 0){
            //edit form
            $json = $this->db->fetchDetailForm($formId);
        }
        $this->view .= "<input type='text' id='json' name='json' value='$json' style='display: none'>";
        $this->view .= "<input type='text' id='form-id' name='form-id' value='$formId' style='display: none'>";
        $this->view .= <<<HTML
                                   
                                    <button id="save" type="submit" style="display: none">Save Form</button>
                                </form>
                                <div id="save-container">
                                    <button id="save-button">Save Form</button>
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
        $this->saveForm();
    }

    public function saveForm(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id = $_GET['id'];
            $json = $_POST['json'];
            $formName = $_POST['form-name'];
            $formType = $_POST['form-type'];
            $user = $_GET['user'];
            $isSaved = $this->db->saveForm($id, $formName, $formType, $user, $json);
            if($isSaved){
                header("Location: index.php?view=forms&user=$user&query=&delete=");
            }
        }
    }

}

ob_end_flush();