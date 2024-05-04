<?php

class FormsViewUI{

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
                <script src="script/forms-view.js"></script>
                <title></title>
            </head>
            <body>
                <div>
                    <nav>
                        <a href=""><i class='fa-solid fa-arrow-left-long fa-lg' style='color:#bb9d93; margin-right:30px;'></i></a>
                        <h1></h1>
                    </nav>
                    
                    <div>
                        <h3>Form Name</h3>
                        <input type="text">
                    </div>
                    
                    <div>
                        <select>
                            <option value="assessment">Assessment</option>
                            <option value="pre">Pre-Flight</option>
                            <option value="post">Post-Flight</option>
                        </select>
                    </div>

                    <div>
                        <form>
                            <div id="container-field">
                                <!-- <div class="field-box">
                                    <div class="header-field">
                                        Statement
                                        <input type="text" class="title-field-input-text">
                                    </div>
                                    <div class="header-field">
                                        Type of Answer
                                            <option value="text" selected>Text</option>
                                            <option value="multiple">Multiple Choice</option>
                                            <option value="checklist">Checklist</option>
                                            <option value="longtext">Long Text</option>
                                        </select>
                                    </div>
                                    <div class="delete-margin">
                                        <button class="delete-field"><i class='fa-regular fa-circle-xmark fa-2x' style='color:#ffffff'></i></button>
                                    </div>
                                </div> -->
                            </div>
                            <div class="button-new-field" style="text-align: center; margin-top: 20px">
                                <button id="add-new-field">
                                    <b>
                                        <div class="button-container">
                                            <span class="plus-icon"><i class='fa-solid fa-plus fa-lg' style='color:#ffffff; margin-right: 15px'></i></span>Add New Field
                                        </div>
                                    </b>
                                </button>
                            </div>

                            <!-- <button>Pre-Flight and Post-Flight Form</button> -->
                            <!-- <div class="right-button">
                                <input type="submit" value="Save" />
                                <input type="submit" value="Complete">
                            </div> -->
                        </form>
                    </div>

                    <div class="save-container">
                        <button id="save-button" type="button" class="button-save">Save Form</button>
                    </div>
                </div>  
            </body>
        </html>
    HTML;

    public function __construct($db, $id){
        $this->db = $db;
        $this->getFormView($id);
    }

    private function getFormView($id){
        $formList = $this->db->fetchDetailForm($id);
        $this->view .= $formList;
    }

    public function getView(){
        echo $this->view;
    }

    private function verifyData($id, $json){
        return true;
    }

    public function saveForm($id, $json, $updatedBy, $updatedDate){
        $verify = $this->verifyData($id, $json);
        if ($verify) {
            $this->db->updateForm($id, $json);
        }
    }

}