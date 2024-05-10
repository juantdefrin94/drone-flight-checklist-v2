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
                <link rel="stylesheet" href="styles/login-style.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="script/templates-view.js"></script>
                <title></title>
            </head>
            <body>
                <div>
                    <nav>
                        <a href=""><i class='fa-solid fa-arrow-left-long fa-lg' style='color:#bb9d93; margin-right:30px;'></i></a>
                        <h1></h1>
                    </nav>
                    
                    <form method="POST">
                        <div>
                            <h3>Template Name</h3>
                            <input type="text" id="template-name" name="template-name">
                        </div>
                    
                    
    HTML;

    function filterForm($item, $type){
        return $item['formType'] === $type;
    }

    public function __construct($db, $id){
        $this->db = $db;
        $json = $this->db->getAllForm();
        $json = json_decode($json);

        $this->view.=<<<HTML
                    <div>
                        Assesment Form
                        <select id="assessment-select">
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

                <div>
                    Pre-Fligt Form
                    <select id="pre-select">
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

                        <div>
                            Post-Flight Form
                            <select id="post-select">
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

                            <input type="text" name="assessment-id" id="assessment-id" >
                            <input type="text" name="pre-id" id="pre-id">
                            <input type="text" name="post-id" id="post-id">

                            <div>
                                <button id="save" type="submit" style="display: none">Save Template</button>
                            </div>

                        </form>

                        <button id="save-button">Save Template</button>
                    </div>  
                </body>
            </html>
        HTML;
        $this->getTemplateView($id);
    }

    private function getTemplateView($id){
        $templateList = $this->db->fetchDetailTemplate($id);
        $this->view .= $templateList;
    }

    public function getView(){
        echo $this->view;
        $this->saveTemplate();
    }

    private function verifyData($id, $templateName, $assessmsnetId, $preId, $postId){
        return true;
    }

    public function saveTemplate(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_GET['id'];
            $templateName = $_POST['template-name'];
            $assessmsnetId = $_POST['assessment-id'];
            $preId = $_POST['pre-id'];
            $postId = $_POST['post-id'];

            $verify = $this->verifyData($id, $templateName, $assessmsnetId, $preId, $postId);
            if ($verify) {
                $user = $_GET['user'];
                $isSaved = $this->db->saveTemplate($id, $templateName, $assessmsnetId, $preId, $postId, $user);
                if($isSaved){
                    header("Location: index.php?view=templates&user=$user");
                }
            }
        }
    }
}