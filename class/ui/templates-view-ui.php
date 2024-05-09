<?php

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
                <title></title>
            </head>
            <body>
                <div>
                    <nav>
                        <a href=""><i class='fa-solid fa-arrow-left-long fa-lg' style='color:#bb9d93; margin-right:30px;'></i></a>
                        <h1></h1>
                    </nav>
                    
                    <div>
                        <h3>Template Name</h3>
                        <input type="text" id="template-name" name="template-name">
                    </div>
                    
                    
    HTML;

    public function __construct($db, $id){
        $this->db = $db;
        $json = $this->db->getAllForm();
        $this->view.=<<<html
                    <div>
                        Assesment Form
                        <select id="assessment-id">
                            <option value=""></option>
                        </select>
                    </div>

                    <div>
                        Pre-Fligt Form
                        <select id="pre-id">
                            <option value=""></option>
                        </select>
                    </div>

                    <div>
                        Post-Flight Form
                        <select id="post-id">
                            <option value=""></option>
                        </select>
                    </div>

                    <div>
                        <button>Save Template</button>
                    </div>
                </div>  
            </body>
        </html>
        html;
        $this->getTemplateView($id);
    }

    private function getTemplateView($id){
        $templateList = $this->db->fetchDetailTemplate($id);
        $this->view .= $templateList;
    }

    public function getView(){
        echo $this->view;
    }

    private function verifyData($id, $templateName, $assessmsnetId, $preId, $postId){
        return true;
    }

    public function saveTemplate($id, $templateName, $assessmsnetId, $preId, $postId){
        $verify = $this->verifyData($id, $templateName, $assessmsnetId, $preId, $postId);
        if ($verify) {
            $this->db->saveTemplate($id, $templateName, $assessmsnetId, $preId, $postId);
        }
    }



}