<?php

include 'class/ui/login-ui.php';
include 'class/database/master-database.php';

$masterDatabase = new MasterDatabase();
$masterUI = new LoginUI($masterDatabase);
$masterUI->getView();