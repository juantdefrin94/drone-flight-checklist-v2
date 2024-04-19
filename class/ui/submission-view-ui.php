<?php

require_once 'class/ui/master-ui.php';
class SubmissionsViewUI extends MasterUI{

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
                        <h3>Submission Name</h3>
                        <input type="text">
                    </div>
                    
                    <div>
                        <button>Assesment</button>
                        <button>Pre-Flight</button>
                        <button>Post-Flight</button>
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

                            <!-- <button>Pre-Flight and Post-Flight Form</button> -->
                            <!-- <div class="right-button">
                                <input type="submit" value="Save" />
                                <input type="submit" value="Complete">
                            </div> -->
                        </form>
                    </div>
                </div>  
            </body>
        </html>
    HTML;

    public function __construct($db){
        $this->db = $db;
        
    }

    public function getAllData(){
        $formList = $this->db->fetchAllForms();
        $this->view .= $formList;
    }

    public function getView(){
        echo $this->view;
    }

}