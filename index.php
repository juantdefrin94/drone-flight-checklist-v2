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

$masterDatabase = new MasterDatabase();
$masterUI = null;

if (isset($_GET['view'])) {
    $action = $_GET['view'];
    
    // Route based on action
    switch ($action) {
        case 'login':
            $masterUI = new LoginUI($masterDatabase);
            $masterUI->getView();
            break;
        case 'register':
            $masterUI = new RegisterUI($masterDatabase);
            $masterUI->getView();
            break;
        case 'forms':
            $masterUI = new FormsUI($masterDatabase);
            $masterUI->getView();
            break;
        case 'viewForms':
            $id = $_GET['id'];
            $masterUI = new FormsViewUI($masterDatabase, $id);
            $masterUI->getView();
            break;
        case 'templates':
            $masterUI = new TemplatesUI($masterDatabase);
            $masterUI->getView();
            break;
        case 'viewTemplates':
            $id = $_GET['id'];
            $masterUI = new TemplatesViewUI($masterDatabase, $id);
            $masterUI->getView();
            break;
        case 'submissions':
            $masterUI = new SubmissionsUI($masterDatabase);
            $masterUI->getView();
            break;
        case 'viewSubmissions':
            $id = $_GET['id'];
            $masterUI = new SubmissionsViewUI($masterDatabase, $id);
            $masterUI->getView();
            break;
        default:
            // Handle other actions or show default page
            break;
    }
} else {
    // Default action, show login page
    $masterUI = new LoginUI($masterDatabase);
    $masterUI->getView();
}