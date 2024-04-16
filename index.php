<?php

include 'class/ui/login-ui.php';
include 'class/ui/register-ui.php';
include 'class/ui/forms-ui.php';
include 'class/ui/templates-ui.php';
include 'class/ui/submissions-ui.php';
include 'class/database/master-database.php';

$masterDatabase = new MasterDatabase();
$masterUI = new SubmissionsUI($masterDatabase);
$masterUI->getView();