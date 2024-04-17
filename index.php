<?php

include 'class/ui/login-ui.php';
include 'class/ui/register-ui.php';
include 'class/ui/forms-ui.php';
include 'class/ui/templates-ui.php';
include 'class/ui/submissions-ui.php';
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
        case 'forms':
            $masterUI = new FormsUI($masterDatabase);
            $masterUI->getAllData();
            $masterUI->getView();
            break;
        case 'register':
            $masterUI = new RegisterUI($masterDatabase);
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