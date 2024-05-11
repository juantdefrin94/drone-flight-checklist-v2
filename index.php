<?php

include 'class/ui/login-ui.php';
include 'class/ui/register-ui.php';
include 'class/ui/forms-ui.php';
include 'class/ui/forms-view-ui.php';
include 'class/ui/templates-ui.php';
include 'class/ui/templates-view-ui.php';
include 'class/ui/submissions-ui.php';
include 'class/ui/submissions-view-ui.php';
include 'class/database/master-database.php';

class Main{

    private $masterDatabase = null;
    private $masterUI = null;

    public function __construct(){
        $this->masterDatabase = new MasterDatabase();
        $this->init();
    }

    private function init(){
        if (isset($_GET['view'])) {
            $action = $_GET['view'];
            
            // Route based on action
            switch ($action) {
                case 'login':
                    $this->masterUI = new LoginUI($this->masterDatabase);
                    $this->masterUI->getView();
                    break;
                case 'register':
                    $this->masterUI = new RegisterUI($this->masterDatabase);
                    $this->masterUI->getView();
                    break;
                case 'forms':
                    $this->masterUI = new FormsUI($this->masterDatabase);
                    $this->masterUI->getView();
                    break;
                case 'viewForms':
                    $id = $_GET['id'];
                    $this->masterUI = new FormsViewUI($this->masterDatabase, $id);
                    $this->masterUI->getView();
                    break;
                case 'templates':
                    $this->masterUI = new TemplatesUI($this->masterDatabase);
                    $this->masterUI->getView();
                    break;
                case 'viewTemplates':
                    $id = $_GET['id'];
                    $this->masterUI = new TemplatesViewUI($this->masterDatabase, $id);
                    $this->masterUI->getView();
                    break;
                case 'submissions':
                    $this->masterUI = new SubmissionsUI($this->masterDatabase);
                    $this->masterUI->getView();
                    break;
                case 'viewSubmissions':
                    $id = $_GET['id'];
                    $this->masterUI = new SubmissionsViewUI($this->masterDatabase, $id);
                    $this->masterUI->getView();
                    break;
                default:
                    break;
            }
        } else {
            // Default action, show login page
            $masterUI = new LoginUI($this->masterDatabase);
            $masterUI->getView();
        }
    }

}

new Main();