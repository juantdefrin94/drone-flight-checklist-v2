<?php

include 'class/ui/dahboard-ui.php';
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
    private $ui = null;

    public function __construct(){
        $this->masterDatabase = new MasterDatabase();
        $this->init();
    }

    private function init(){
        if (isset($_GET['view'])) {
            $action = $_GET['view'];
            
            // Route based on action
            switch ($action) {
                case 'dashboard':
                    $this->ui = new DashboardUI($this->masterDatabase);
                    $this->ui->getView();
                    break;
                case 'login':
                    $this->ui = new LoginUI($this->masterDatabase);
                    $this->ui->getView();
                    break;
                case 'register':
                    $this->ui = new RegisterUI($this->masterDatabase);
                    $this->ui->getView();
                    break;
                case 'forms':
                    $this->ui = new FormsUI($this->masterDatabase);
                    $this->ui->getView();
                    break;
                case 'viewForms':
                    $id = $_GET['id'];
                    $this->ui = new FormsViewUI($this->masterDatabase, $id);
                    $this->ui->getView();
                    break;
                case 'templates':
                    $this->ui = new TemplatesUI($this->masterDatabase);
                    $this->ui->getView();
                    break;
                case 'viewTemplates':
                    $id = $_GET['id'];
                    $this->ui = new TemplatesViewUI($this->masterDatabase, $id);
                    $this->ui->getView();
                    break;
                case 'submissions':
                    $this->ui = new SubmissionsUI($this->masterDatabase);
                    $this->ui->getView();
                    break;
                case 'viewSubmissions':
                    $id = $_GET['id'];
                    $this->ui = new SubmissionsViewUI($this->masterDatabase, $id);
                    $this->ui->getView();
                    break;
                default:
                    break;
            }
        } else {
            // Default action, show login page
            $ui = new LoginUI($this->masterDatabase);
            $ui->getView();
        }
    }

}

new Main();