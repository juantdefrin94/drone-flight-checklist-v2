<?php

require_once 'class/ui/master-ui.php';
class RegisterUI extends MasterUI{

    private $db = null;
    private $view = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>Register Page</title>
        </head>
        <body>
            <div class="container">
                <div class="image-container">
                    <img class="background-login" src="assets/login-background.png" alt="">
                </div>
                <form class="login-container" method="POST" action="action/login.php">
                    <div class="login-title-no-bold ">Register Your Account</div>
                    <div class="label-input-container">
                        <label for="" class="label-input">Email</label>
                        <div class="container-input">
                            <i class='fa-solid fa-user fa-lg' style='color:#d69883; margin-right:10px;'></i>
                            <input class="input-style" type="text" name="email" placeholder="example123@gmail.com">
                        </div>
                    </div>
                    <div class="label-input-container">
                        <label for="" class="label-input">Username</label>
                        <div class="container-input">
                            <i class='fa-solid fa-user fa-lg' style='color:#d69883; margin-right:10px;'></i>
                            <input class="input-style" type="text" name="username" placeholder="example123">
                        </div>
                    </div>
                    <div class="label-input-container">
                        <label for="" class="label-input">Password</label>
                        <div class="container-input">
                            <i class='fa-solid fa-lock fa-lg' style='color:#d69883; margin-right:10px;'></i>
                            <input class="input-style" type="password" name="password" placeholder="**********">
                        </div>
                    </div>
                    <div><input class="" type="submit" value="Register"></div>
                </form>
                <div>
                    Already Have An Accpunt? <span><a href="index.php?view=login">Login here</a></span> 
                </div>
            </div>
        </body>
        </html>
    HTML;

    public function __construct($db){
        $this->db = $db;
    }

    public function getView(){
        echo $this->view;
    }

    public function verifyData($username, $password){
        return true;
    }
    public function login($username, $password){
        $verified = $this->verifyData($username, $password);
        if($verified){
            $validated = $this->db->validateLogin($username, $password);
            if($validated){
                return true;
            }
        }
        return false;
    }

    

}