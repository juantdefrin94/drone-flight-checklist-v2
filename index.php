<?php

include 'class/ui/login-ui.php';
include 'class/ui/register-ui.php';
include 'class/database/master-database.php';

$masterDatabase = new MasterDatabase();
$masterUI = new RegisterUI($masterDatabase);
$masterUI->getView();